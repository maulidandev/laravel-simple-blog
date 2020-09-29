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

        $response = $this->from(route("categories.edit", $category->id))
            ->post(route("categories.update", $category->id), [
                  "title" => $this->faker->words(3, true),
                "_method" => "put"
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("categories.index"));
    }
}