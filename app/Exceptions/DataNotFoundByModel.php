<?php

namespace App\Exceptions;

use Exception;

class DataNotFoundByModel extends Exception {
    public function __construct() {
        // $this->message = $message;
    }
}