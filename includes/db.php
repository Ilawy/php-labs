<?php

function generateID() {
    $count = 0;
    if(file_exists("counter")){
        $count = (int)file_get_contents("counter") + 1;
    }
    file_put_contents("counter", "{$count}");
    return $count;
}

function insertRow($entry) {
    $data = [];
    if(file_exists("customer.json")){
        global $data;
        $raw = file_get_contents("customer.json");
        if(gettype($raw) != "string")throw new Error("Cannot read file");
        $data = json_decode($raw, true);
        if($data == null)$data = [];
    }
    $data[] = $entry;
    file_put_contents("customer.json", json_encode($data));
}

function getAllRows() {
    $data = [];
    if(file_exists("customer.json")){
        global $data;
        $raw = file_get_contents("customer.json");
        if(gettype($raw) != "string")throw new Error("Cannot read file");
        $data = json_decode($raw, true);
        if($data == null)$data = [];
    }
    return $data;
}

function deleteRow($id) {
    $data = [];
    if(file_exists("customer.json")){
        global $data;
        $raw = file_get_contents("customer.json");
        if(gettype($raw) != "string")throw new Error("Cannot read file");
        $data = json_decode($raw, true);
        if($data == null)$data = [];
    }
    $oldLength = count($data);
    $data = array_filter($data, fn($row)=>$row['id'] != $id);
    file_put_contents("customer.json", json_encode($data));
    return count($data) != $oldLength;
}




?>