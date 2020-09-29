<?php

namespace Tests\Feature\Http\Controller\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $category = Category::factory()->create();

        $response = $this->from(route("categories.edit", $category->id))
            ->post(route("categories.destroy", $category->id), [
                "_method" => "delete"
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("categories.index"));
    }
}
