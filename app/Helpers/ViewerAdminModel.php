<?php namespace App\Helpers;

class ViewerAdminModel {

    public function __construct($name, $model)
    {
        $this->name = $name;
        $this->model = $model;
        $this->args = [];
    }

    public function args($args){
        $this->args = $args;
        return $this;
    }

    public function get(){
        return $this->model->ask()->graphqlArgs($this->args, false)->get()->records;
    }
}
