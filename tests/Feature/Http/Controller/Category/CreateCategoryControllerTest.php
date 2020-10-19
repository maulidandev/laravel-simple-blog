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
                "title" => $this->faker->words(500, true)
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("categories.create"));
    }

    public function testUsingNotUniqueTitle(){
        $category = Category::factory()->create();

        $response = $this->from(route("categories.create"))
            ->post(route("categories.store"), [
                "title" => $category->title
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("categories.create"));
    }
}
