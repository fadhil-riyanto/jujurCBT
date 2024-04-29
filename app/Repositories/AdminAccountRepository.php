<?php

namespace App\Repositories;

use App\Models;
use App\Exceptions;
use App\Repositories\Interfaces;

class AdminAccountRepository implements Interfaces\IAccount{
    protected $ctx;
    protected $modelname;

    public function __construct() {
        $this->modelname = new MOdels\AdminAccountModel;
    }

    public function getByID(int $id) {
        $this->ctx = $this->modelname::where("id", $id);
        return $this;
    }

    public function getByTable(string $table, mixed $value) {
        $this->ctx = $this->modelname::where($table, $value);
        return $this;
    }

    public function getAll() {
        $this->ctx = $this->modelname::all();
        return $this;
    }

    public function getFirst() {
        if ($this->ctx->first() == null) {
            throw new Exceptions\DataNotFoundByModel();
        } else {
            return $this->ctx->first();
        }
    }

    public function get() {
        return $this->ctx->get();
    }
}

