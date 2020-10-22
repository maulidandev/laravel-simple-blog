<?php
/**
 * Created by PhpStorm.
 * User: maulidan
 * Date: 22/10/20
 * Time: 15:25
 */

namespace App\Business;


use App\Models\Category;
use Illuminate\Support\Str;

class CategoryBusiness
{
    public static function store($title){
        $self = new Self;

        $category = Category::create($self->getData($title));
        return $category;
    }

    public static function update($title, $id){
        $self = new Self;

        $category = Category::where("id", $id)->update($self->getData($title));
        return $category;
    }

    private function getData($title){
        return [
            "title" => $title,
            "slug" => Str::slug($title)
        ];
    }
}