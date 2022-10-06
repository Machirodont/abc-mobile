<?php

class DataView
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Выполняет все "действия" - публичные методы модели, имеющие @description
     * @return void
     */
    public function executeAll(): void
    {
        $reflector = new ReflectionClass($this->model);
        $methods = $reflector->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if ($action = Action::create($method)) {
                $action->invoke($this->model);
            }
        }
    }
}