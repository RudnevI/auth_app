<?php

namespace App\Http\Controllers;

use App\StaticData;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\CrudService;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BaseCrudController extends Controller {

    protected $model;

    protected $uniqueModelAttributes;


    protected abstract function getModel();






    public function getAll() {


            return response()->json(CrudService::getAll($this->getModel()), 200);

    }


    public function create(Request $request) {
        $entity = CrudService::create($this->getModel(), $request->all());
         return response()->json(["Message" => "CREATED", strtolower(class_basename($entity::class)) => $entity], 201);
    }


    public function getById($id) {


        $entity = CrudService::getById($this->getModel(), $id);


        return response()->json([$entity]);
    }


    public function updateById(Request $request, $id) {

        $entity = CrudService::updateById($this->getModel(),$request->all(), $id);
        return response()->json(["Message" => "UPDATED", strtolower(class_basename($entity::class)) => $entity], 200);


    }

    public function deleteById($id) {

        if(CrudService::deleteById($this->getModel() ,$id)) {
            return response()->json(["Message" => "DELETED"], 204);
        }
        else throw new HttpException('Delete has failed');
    }

}
