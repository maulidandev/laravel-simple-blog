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
        $title = $this->faker->words(3, true);

        $response = $this->from(route("categories.create"))
            ->post(route("categories.store"), [
                "title" => $title
            ]);

        $this->assertDatabaseHas('categories', [
            'title' => $title,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("categories.index"));
    }

    public function testUsingInvalidTitle(){
        $title = $this->faker->words(500, true);

        $response = $this->from(route("categories.create"))
            ->post(route("categories.store"), [
                "title" => $title
            ]);

        $this->assertDatabaseMissing('categories', [
            'title' => $title,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("categories.create"));
    }

    public function testUsingNotUniqueTitle(){
        $category = Category::factory()->create();

        $this->assertDatabaseHas('categories', [
            'title' => $category->title,
        ]);

        $response = $this->from(route("categories.create"))
            ->post(route("categories.store"), [
                "title" => $category->title
            ]);

        $this->assertDatabaseCount('categories', 1);

        $response->assertStatus(302);
        $response->assertRedirect(route("categories.create"));
    }
}
