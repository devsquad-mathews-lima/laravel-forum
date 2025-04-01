<?php

namespace Feature\Controllers\PostController;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use LazilyRefreshDatabase;

    #[Test]
    public function it_can_show_a_post(): void
    {
        $post = Post::factory()->create();

        $this
            ->get(route('posts.show', $post))
            ->assertInertiaComponent('Posts/Show');
    }

    #[Test]
    public function it_passes_a_post_to_the_view(): void
    {
        $post = Post::factory()->create();
        $post->load('user');

        $this
            ->get(route('posts.show', $post))
            ->assertHasResource('post', PostResource::make($post));
    }
}
