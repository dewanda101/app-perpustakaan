<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteResourceTest extends TestCase
{
    public function test_books_index_route_returns_expected_response(): void
    {
        $this->get('/books')
            ->assertOk()
            ->assertSeeText('BookController@index');
    }

    public function test_categories_detail_route_returns_method_not_allowed(): void
    {
        $this->get('/categories/3')
            ->assertStatus(405);
    }

    public function test_admin_group_route_exists(): void
    {
        $this->get('/admin/info')
            ->assertOk()
            ->assertSeeText('Admin info');
    }
}
