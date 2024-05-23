<?php

function generateNumericSalt($minLength = 10, $maxLength = 16) {
    $length = rand($minLength, $maxLength);
    $salt = '';
    for ($i = 0; $i < $length; $i++) {
        $salt .= rand(0, 9);
    }
    return $salt;
}


?>