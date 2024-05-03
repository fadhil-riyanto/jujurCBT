<?php

namespace App\Repositories\Interfaces;

interface IAccount {
    public function getByID(int $id);
    public function getByTable(string $column, mixed $value);
    public function getAll();
    public function getFirst();
    public function get();
}

