<?php
require_once 'parser.php';

$text = "###### Sample Document
Hello!

This is sample markdown ### for the [Mailchimp ](  https://www.mailchimp.com) homework assignment.
";


// parse h1 and p

$parser = new HTMLParser();
print_r($parser->parse($text));
?>