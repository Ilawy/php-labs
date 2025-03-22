<?php


function validate($key, $nonempty = false, $nonset = false, $pattern = null, $source = null, $custom=null, $message = null) {    
    if($source == null)$source = $_POST;
    if($nonset && !isset($source[$key]))return [false, $message ? $message : "Field is required"];
    $value = $source[$key];
    if($nonempty && empty($value))return [false, $message ? $message : "Field cannot be empty"];
    if($pattern != null && !preg_match($pattern, $value))return [false, $message ? $message : "Field does not match pattern $pattern"];
    if($custom){
        $customResult = $custom($value);
        if(!$customResult[0])return $customResult;
    }
    return [true, $value];
}


function getValidationErrors($fields){
    $errors = [];
    foreach($fields as $key => $value){
        if(!$value[0])$errors[$key] = $value[1];
    }
    return $errors;
}

function getValidationValues($fields) {
    $result = [];
    foreach($fields as $key => $value){
        if($value[0])$result[$key] = $value[1];
    }
    return $result;
}