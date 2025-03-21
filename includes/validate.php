<?php


function validate($key, $nonempty = false, $nonset = false, $pattern = null, $source = null, $custom=null, $message = null) {    
    if($source == null)$source = $_POST;
    if($nonset && !isset($source[$key]))return [false, $message || "Field is required"];
    $value = $source[$key];
    if($nonempty && empty($value))return [false, $message || "Field cannot be empty"];
    if($pattern != null && !preg_match($pattern, $value))return [false, $message || "Field does not match pattern $pattern"];
    if($custom){
        $customResult = $custom($value);
        if(!$customResult[0])return $customResult;
    }
    return [true, $value];
}