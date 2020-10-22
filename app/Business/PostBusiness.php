<?php
/**
 * Created by PhpStorm.
 * User: maulidan
 * Date: 22/10/20
 * Time: 15:09
 */

namespace App\Business;


use App\Models\Category;

class PostBusiness
{
    public static function getAllCategories(){
        $self = new Self();

        $categories = Category::orderBy("title", "asc")->get();
        $categories->prepend($self->addNewCategoryOption());

        return $categories;
    }

    private function addNewCategoryOption(){
        $category = new Category();
        $category->id = -1;
        $category->title = "New Category";

        return $category;
    }

    public static function insertNewCategory($data){
        if ($data["category_id"] == -1){
            $category = CategoryBusiness::store($data["new_category"]);
            $data["category_id"] = $category->id;
        }

        unset($data["new_category"]);

        return $data;
    }
}