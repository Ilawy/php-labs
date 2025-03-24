<?php
require_once "lib/utils.php";
$STORAGE_PATH = "files";
`mkdir -p {$STORAGE_PATH}`;


function generateFilePath($file) {
    global $STORAGE_PATH;
    $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
    $ts = time();
    $finalPath = path_join($STORAGE_PATH, $ts . "." . $ext);
    return $finalPath;
}

function saveFile(array $file, string $finalPath){
    return move_uploaded_file($file["tmp_name"], $finalPath);
}
