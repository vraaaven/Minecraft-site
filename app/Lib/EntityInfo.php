<?php

namespace App\Lib;

abstract class EntityInfo
{
    public static function getFromArray($array): object
    {
        $instance = new static();
        foreach ($array as $key => $value) {
            $instance->$key = $value;
        }
        return $instance;
    }

    public function getField($field)
    {
        if (property_exists($this, $field)) {
            return $this->$field;
        }
            return Helper::showError('Несуществующее свойство');
    }

    public function setField($field, $value)
    {
        if (property_exists($this, $field)) {
            return $this->$field = $value;
        } else {
             return Helper::showError('Несуществующее свойство');
        }
    }
}
