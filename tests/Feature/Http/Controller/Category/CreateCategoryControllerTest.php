<?php

namespace Tests\Feature\Http\Controller\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCategoryControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testUsingValidData()
    {
        $response = $this->from(route("categories.create"))
            ->post(route("categories.store"), [
                "title" => $this->faker->words(3, true)
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("categories.index"));
    }

    public function testUsingInvalidTitle(){
        $response = $this->from(route("categories.create"))
            ->post(route("categories.store"), [
                "title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae interdum arcu. Quisque sagittis venenatis massa in lobortis. Morbi pretium aliquet arcu vitae volutpat. Aliquam blandit feugiat ultricies. Quisque rutrum pulvinar bibendum. Maecenas sollicitudin lectus sit amet venenatis viverra. Cras sit amet gravida arcu. Nulla semper bibendum fermentum. Praesent a elit gravida dolor tempor tempor eu non neque. Cras efficitur lorem ut nulla dictum hendrerit."
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("categories.create"));
    }

    public function testUsingNotUniqueTitle(){
        if ($category = Category::first()){
            $response = $this->from(route("categories.create"))
                ->post(route("categories.store"), [
                    "title" => $category->title
                ]);

            $response->assertStatus(302);
            $response->assertRedirect(route("categories.create"));
        }
    }
}
