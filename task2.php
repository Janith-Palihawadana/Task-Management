<?php
function isValidPalindrom(string $str) {
    
    $prepareString = preg_replace('/[ ,]+/', '', strtolower($str));

    $reverseString = strrev($prepareString);

    if ($reverseString == $prepareString) {
        echo "true";
    } else {
        echo "false";
    }
}

$string = "A man , a plan , a canal ,Panama";
$str = "race a car";
isValidPalindrom($string);
isValidPalindrom($str);


?>
