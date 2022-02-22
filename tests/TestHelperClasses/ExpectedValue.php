<?php



class ExpectedValue {

    public $message;

    public $status;

    public $entity;

    public $methodName;

    function __construct($message, $status, $entity, $methodName) {
        $args = func_get_args(__FUNCTION__);
        foreach($args as $arg) {
            echo $arg;
        }
    }
}

$expectedValue = new ExpectedValue('test', 200, 'test', 'test');
