<?php

    function array_find($array, $callback) {
        foreach ($array as $value) {
            if($callback($value))return $value;
        }
        return false;
    }

    function pick($array, $keys) {
        $flipped = array_flip($keys);
        return array_intersect_key($array, $flipped);
    }

?>