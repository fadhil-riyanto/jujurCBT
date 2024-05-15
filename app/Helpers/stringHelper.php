<?php

if (!function_exists("normal2snake_case")) {
    function normal2snake_case(string $normal) {
        return str_replace(" ", "_", strtolower($normal));
    }
}

if (!function_exists("normal2snake_case_invers")) {
    function normal2snake_case_invers(string $not_normal) {
        return strtoupper(str_replace("_", " ", $not_normal));
    }
}

if (!function_exists("literal2charindex")) {
    function literal2charindex(string $literal): int {
        $char_literals = [
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", 
            "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"
        ];
        for($i = 0; $i < count($char_literals); $i++) {
            if (strtoupper($literal) == $char_literals[$i]) {
                return $i;
            }
        }
    }
}