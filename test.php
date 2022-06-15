<?php
require_once 'parser.php';


// Test 1
$text1 = "###### Sample Document
Hello!

This is sample markdown ### for the [Mailchimp ](  https://www.mailchimp.com) homework assignment.
";


// Test 2
$text2 = "# Header one
Hello there
How are you?
What's going on?
## Another Header
This is a paragraph [with an inline link](http://google.com). Neat, eh?
## This is a header [with a link](http://yahoo.com)";

$config = array(
    "header_max"=> 6,
    "header_char"=> "#"
);
$parser = new HTMLParser($config);

print_r($parser->parse($text1));
print_r($parser->parse($text2));

?>
