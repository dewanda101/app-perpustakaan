<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_books_index_route_returns_expected_response(): void
    {
        $user = User::factory()->create(['role' => 'petugas']);

        $this->actingAs($user)
            ->get('/books')
            ->assertOk()
            ->assertSeeText('Daftar Buku');
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
