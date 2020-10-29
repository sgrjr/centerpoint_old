<?php namespace App\Interfaces;

interface ModelInterface {
    public function createTable();
    public static function seedTable();
    public function dropTable();
    public function emptyTable();
    public function delete();
    public function saveChanges();
    public function schema($table);
}