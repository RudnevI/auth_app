<?php

namespace App;

class StaticData {
    public static $createdMessageTemplate = ["Message" => "CREATED"];



    public static function formNotFoundByParameterTemplateMessage($modelName, $parameterName): array {
        return ["Message" => $modelName.' with passed '.$parameterName.' doesn\'t exist'];
    }

    public static function formAlreadyExistsTemplateMessage($modelName, $parameterName): array {
        return ['Message' => $modelName.' with passed '.$parameterName.' already exists'];
    }

    public static function formPasswordTooShortMessageTemplate():array {
        return ['Message' => 'Password should be at least '.env("MIN_PASSWORD_LENGTH").' characters long'];
    }

    public static function getCreatedMessageTemplateWithAppendage($appendage):array {

        $createdMessageTemplateBuff = StaticData::$createdMessageTemplate;
        array_push($createdMessageTemplateBuff, $appendage);
        return $createdMessageTemplateBuff;
    }

}
