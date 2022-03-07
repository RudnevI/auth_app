<?php

namespace App\Http\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CrudService {













    public static function getAll($model) {




            return ($model)::all();
    }


    public static function create($model, $data) {
        return ($model)::create($data);

    }


    public static function getById($model,$id) {


        $entity = ($model)::where('id',$id)->first();


        if($entity === null) throw new NotFoundHttpException();
        return $entity;
    }


    public static  function updateById( $model,$data, $id) {
        $entity = ($model)::where('id', $id)->first();
        if($entity === null) throw new NotFoundHttpException();

        unset($data['id']);
        if($model === User::class) {
            $data['email'] = Hash::make($data['email']).'@example.com';
        }
        $entity->fill($data)->save();

        return $entity;


    }

    public static function deleteById($model,$id) {
        $entity = ($model)::where('id', $id)->first();
        if($entity === null)  throw new NotFoundHttpException();
        $entity->delete();

        return true;
    }




}
