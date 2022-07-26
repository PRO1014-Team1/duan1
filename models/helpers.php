<?php

function pre($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function validate_input($input){
    $input = stripslashes(trim($input));
    $input = htmlentities($input,ENT_QUOTES);
    return $input;
}