<?php
/**
 * Created by PhpStorm.
 * User: maulidan
 * Date: 25/10/20
 * Time: 12:51
 */

namespace App\Helpers;


class CategoryHelper
{
    private $UNCATEGORIZE = 1;

    public static function isUncategorize($id){
        $self = new Self;

        return $self->UNCATEGORIZE == $id;
    }

    public static function getUncategorizeID(){
        $self = new Self;

        return $self->UNCATEGORIZE;
    }
}