<?php

class HTMLParser {

    public $h_limit = 6;

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
                //echo "\nthis is a header";
                unset($paragraph[0]);
                //var_dump($paragraph);
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
            if ($char !== "#") {
                return false;
            }
        }

        // echo "\n this->h_limit = ".$this->h_limit." \n";
        // echo "\n count($word_arr) = ".count($word_arr)." \n";
        if (count($word_arr) > $this->h_limit) {
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