<?php
$DB_PATH = "data/";
`mkdir -p {$DB_PATH}`;


class Database
{
    private string $db_name;
    public function __construct($db_name)
    {
        $this->db_name = $db_name;
    }


    public function generateID()
    {
        $file = "data/" . $this->db_name . "_" . "counter";
        $count = 0;
        if (file_exists($file)) {
            $count = (int)file_get_contents($file) + 1;
        }
        file_put_contents($file, "{$count}");
        return $count;
    }

    function insertRow($entry)
    {
        $file = "data/" . $this->db_name . ".json";
        $data = [];
        if (file_exists($file)) {
            global $data;
            $raw = file_get_contents($file);
            if (gettype($raw) != "string") throw new Error("Cannot read file");
            $data = json_decode($raw, true);
            if ($data == null) $data = [];
        }
        $data[] = $entry;
        file_put_contents($file, json_encode($data));
    }

    function getAllRows()
    {
        $data = [];
        $file = "data/" . $this->db_name . ".json";

        if (file_exists($file)) {
            global $data;
            $raw = file_get_contents($file);
            if (gettype($raw) != "string") throw new Error("Cannot read file");
            $data = json_decode($raw, true);
            if ($data == null) $data = [];
        }
        return $data;
    }

    function findRow($callback)
    {
        foreach ($this->getAllRows() as $row) {
            if ($callback($row)) return $row;
        }
        return null;
    }

    function deleteRow($id)
    {
        $data = [];
        $file = "data/" . $this->db_name . ".json";
        if (file_exists($file)) {
            global $data;
            $raw = file_get_contents($file);
            if (gettype($raw) != "string") throw new Error("Cannot read file");
            $data = json_decode($raw, true);
            if ($data == null) $data = [];
        }
        $oldLength = count($data);
        $data = array_filter($data, fn($row) => $row['id'] != $id);
        file_put_contents($file, json_encode($data));
        return count($data) != $oldLength;
    }
}
