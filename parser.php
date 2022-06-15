<?php

class HTMLParser {

    public $h_max, $h_char;

    public function __construct($config) {
        $this->h_max = $config['header_max'];
        $this->h_char = $config['header_char'];
    }

    public function parse($text) {
        $text = $this->parseHeadersOrPara($text);
        $text = $this->parseLink($text);
        return $text;
    }

    public function parseHeadersOrPara($text) {
        $data = explode(PHP_EOL, $text);
        foreach ($data as $key => $value) {
            $paragraph = explode(" ", trim($value));
            $first_word = str_split($paragraph[0]);
            if ($this->isHeader($first_word)) {
                unset($paragraph[0]);
                $h_count = count($first_word);
                $h_title = implode(" ", $paragraph);
                // I assumed this sanitization logic
                if (trim($h_title) !== "") {
                    $data[$key] = "<h$h_count>$h_title</h$h_count>";
                }
            } elseif (trim($value) !== "") {
                // Based on the current requirement I decided to combine both 
                $data[$key] = "<p>$value</p>";
            }
        }
    
        $text = implode(PHP_EOL, $data);
        return $text;
    
    }
    
    public function isHeader($word_arr) {
        // each character of this array has to be '#'
        foreach ($word_arr as $char) {
            if ($char !== $this->h_char) {
                return false;
            }
        }
        // Allowed header tags only
        if (count($word_arr) > $this->h_max) {
            return false;
        }
        return true;
    }
    
    public function parseLink($text) {
        $result = preg_replace('/\[(.*)\]\((.*)\)/', '<a href="\2">\1</a>', $text);
        return $result;
    }
}

?>
