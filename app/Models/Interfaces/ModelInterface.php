<?php namespace App\Models\Interfaces;

interface ModelInterface {
    public function createTable();
    public function seedTable();
    public function dropTable();
    public function emptyTable();
    public function delete();
    public function dbfSave();
}