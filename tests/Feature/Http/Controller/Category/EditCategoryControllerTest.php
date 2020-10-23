<?php

namespace Tests\Feature\Http\Controller\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditCategoryControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUsingValidData()
    {
        $category = Category::factory()->create();

        $this->assertDatabaseHas("categories", [
            "id" => $category->id,
        ]);

        $title = $this->faker->words(3, true);

        $response = $this->from(route("categories.edit", $category->id))
            ->post(route("categories.update", $category->id), [
                  "title" => $title,
                "_method" => "put"
            ]);

        $this->assertDatabaseHas("categories", [
            "id" => $category->id,
            "title" => $title
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("categories.index"));
    }

    public function testUsingInvalidTitle(){
        $category = Category::factory()->create();

        $this->assertDatabaseHas("categories", [
            "id" => $category->id,
        ]);

        $title = $this->faker->unique()->words(100, true);

        $response = $this->from(route("categories.edit", $category->id))
            ->post(route("categories.update", $category->id), [
                "title" => $title,
                "_method" => "put"
            ]);

        $this->assertDatabaseHas("categories", [
            "id" => $category->id,
            "title" => $category->title
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(["title"]);
        $response->assertRedirect(route("categories.edit", $category->id));
    }

    public function testUsingNotUniqueTitle(){
        $categories = Category::factory(2)->create();

        $response = $this->from(route("categories.edit", $categories[0]->id))
            ->post(route("categories.update", $categories[0]->id), [
                "title" => $categories[1]->title,
                "_method" => "put"
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(["title"]);
        $response->assertRedirect(route("categories.edit", $categories[0]->id));
    }
}
