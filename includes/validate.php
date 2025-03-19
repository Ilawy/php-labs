<?php


function validate($key, $nonempty = false, $nonset = false, $pattern = null, $source = null) {
    if($source == null)$source = $_POST;
    if($nonset && !isset($source[$key]))return false;
    $value = $source[$key];
    if($nonempty && empty($value))return false;
    if($pattern != null && !preg_match($pattern, $value))return false;
    return $value;
}