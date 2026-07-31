<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_homepage_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_products_page_loads()
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
    }

    public function test_cart_page_loads()
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }

    public function test_login_page_loads()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_search_works()
    {
        $response = $this->get('/search?q=test');
        $response->assertStatus(200);
    }

    public function test_admin_access_denied_for_guests()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }
}