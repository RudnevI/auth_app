<?php

namespace App\Http\Controllers;

use App\StaticData;
use Exception;
use Illuminate\Http\Request;

abstract class BaseCRUD_Contoller {

    protected $model;

    protected $uniqueModelAttributes;



    public function getAll() {
        return response()->json([class_basename($this->model) => $this->model::all()], 200);
    }


    public function __call($name, $arguments)
    {

    }



}
