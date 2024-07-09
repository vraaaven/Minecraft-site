<?php

namespace App\Lib;


class Component extends EntityInfo
{
    public function showComponent ($name, $template)
    {
        if (file_exists('public/components/' .$name. '/'. $template.'/'.'template.php')) {
            require 'public/components/' .$name. '/'. $template.'/'.'template.php';
        } else {
            echo 'Компонент не найден';
        }
    }
}