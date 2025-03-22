<?php
require_once "lib/utils.php";
$STORAGE_PATH = "files";
`mkdir -p {$STORAGE_PATH}`;


function saveFile($file){
    global $STORAGE_PATH;
    $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
    $pathParts = explode("/", $file["tmp_name"]);
    $rand = $pathParts[count($pathParts) - 1];
    $finalPath = path_join($STORAGE_PATH, $rand . "." . $ext);
    move_uploaded_file($file["tmp_name"], $finalPath);
    return $finalPath;
}
