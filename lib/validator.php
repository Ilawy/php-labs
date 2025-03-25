<?php


function validate($key, $nonempty = true, $nonset = true, $pattern = null, $source = null, $custom = null, $message = null)
{
    if ($source == null) $source = $_POST;
    if ($nonset && !isset($source[$key])) return [false, $message ? $message : "Field is required"];
    $value = $source[$key];
    if ($nonempty && empty($value)) return [false, $message ? $message : "Field cannot be empty"];
    if ($pattern != null && !preg_match($pattern, $value)) return [false, $message ? $message : "Field does not match pattern $pattern"];
    if ($custom) {
        $customResult = $custom($value);
        if (!$customResult[0]) return $customResult;
    }
    return [true, $value];
}


function getValidationErrors($fields)
{
    $errors = [];
    foreach ($fields as $key => $value) {
        if (!$value[0]) $errors[$key] = $value[1];
    }
    return $errors;
}

function getValidationValues($fields)
{
    $result = [];
    foreach ($fields as $key => $value) {
        if ($value[0]) $result[$key] = $value[1];
    }
    return $result;
}



function validateFile(string $name, array | null $allowedExts = null, int | null $maxSize = null)
{
    if (!isset($_FILES[$name])) return [false, "File not found"];
    $file = $_FILES[$name];
    if(empty($file["temp_name"]) || $file["name"] || $file["error"] != 0)[false, "Please make sure that you uploaded the file correctly"];
    $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
    if (!is_null($allowedExts) && !in_array($ext, $allowedExts))return [false, "File type is not supported"];

    return [true, $file];    
}



function handleValidationResult($result, $redirectTo) {
    $errors = getValidationErrors($result);
    $values = getValidationValues($result);
    if($errors){
        $_SESSION["errors"] = $errors;
        $_SESSION["values"] = $values;
        header("Location: $redirectTo");
        exit;
    }
    return $values;
}


function getValidationReturn() {
    $errors = [];
    $values = [];
    if(isset($_SESSION["errors"]))$errors = $_SESSION["errors"];
    if(isset($_SESSION["values"]))$value = $_SESSION["values"];
    unset($_SESSION["errors"]);
    unset($_SESSION["values"]);
    return [$errors, $values];
}