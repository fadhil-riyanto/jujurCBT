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