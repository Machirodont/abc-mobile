<?php

class Action
{
    /**
     * @var string
     */
    public $description;

    /**
     * @var ReflectionMethod
     */
    private $method;

    public static function create(ReflectionMethod $method): ?self
    {
        $docBlock = $method->getDocComment();
        $action = null;
        if (preg_match('|@description (.+)|', $docBlock, $matches)) {
            $action = new self();
            $action->description = $matches[1];
            $action->method = $method;
        }
        return $action;
    }

    public function invoke(object $model)
    {
        echo $this->description . ":\r\n";
        echo json_encode($this->method->invoke($model), JSON_UNESCAPED_UNICODE) . "\r\n\r\n";
    }

}