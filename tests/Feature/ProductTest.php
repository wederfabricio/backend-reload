<?php

namespace Tests\Feature;
namespace App;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testProductIndex()
    {
        $response = $this->get('/api/product');

        $response->assertStatus(200);
    }

    public function testProductInsert()
    {
        $product = factory(Product::class, 1)->make()->toArray()[0];
        $response = $this->postJson('/api/product', $product);
        //dd($response, factory(Product::class, 1)->make()->toArray()[0]);

        $response
            ->assertStatus(200)
            ->assertJson($product);
    }

    public function testProductRemoval()
    {
        $product = Product::orderBy('id', 'desc')->first();
        $response = $this->deleteJson('/api/product/'.$product->id);

        $response
            ->assertStatus(200)
            ->assertJson($product->toArray());
    }

}
