<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Model\Product;
use Auth;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class ProductTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
        $user = User::find(1);
        Passport::actingAs($user);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('reviews')->truncate();
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        factory(Product::class, 1)->create([
            'user_id' => 1
        ]);

        factory(Product::class, 1)->create([
            'user_id' => 2
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testProductAll()
    {
        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
    }

    public function testProductCreated()
    {
        $response = $this->json(
            'POST',
            route('products.index'),
            [
                'name' => 'New Product',
                'description' => 'This is a new product',
                'price' => 100,
                'stock' => 10,
                'discount' => 30,
            ]
        );

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'name' => 'New Product',
                'totalPrice' => 70,
            ],
        ]);
    }

    public function testProductUpdated()
    {
        $response = $this->json(
            'PUT',
            route('products.update', 1),
            [
                'name' => 'New Product updated',
                'description' => 'Updated description...',
                'price' => 1000,
                'discount' => 30,
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'name' => 'New Product updated',
                'totalPrice' => 700,
            ],
        ]);
    }

    public function testProductDeleted()
    {
        $response = $this->json(
            'DELETE',
            route('products.destroy', 1)
        );

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNull(Product::find(1));
    }

    public function testProductCreateWithIncorrectParams()
    {
        $response = $this->json(
            'POST',
            route('products.index'),
            [
                'name' => 'Heello',
                'description' => 'This is a test',
                'discount' => 1000,
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            'message' => 'The given data was invalid.',
        ]);
    }

    public function testProductUpdatedWithNotBelongsToUser()
    {
        $response = $this->json(
            'PUT',
            route('products.update', 2),
            [
                'name' => 'New Product updated',
                'description' => 'Updated description...',
                'price' => 1000,
                'discount' => 30,
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'errors' => 'This product not belongs to user',
        ]);

    }

    public function testProductDeletedWithNotBelongsToUser()
    {
        $response = $this->json(
            'DELETE',
            route('products.update', 2)
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'errors' => 'This product not belongs to user',
        ]);
    }
}
