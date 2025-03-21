<?php

    function array_find($array, $callback) {
        foreach ($array as $value) {
            if($callback($value))return $value;
        }
        return false;
    }

?>