<?php

namespace Tests\Feature\Controllers\PostController;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Collection;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use LazilyRefreshDatabase;

    #[Test]
    public function it_should_return_the_correct_component(): void
    {
        $this->get(route('posts.index'))
            ->assertInertia(fn (AssertableInertia $inertia) => $inertia
                ->component('Posts/Index', true)
            );
    }

    #[Test]
    public function it_should_passes_posts_to_the_view(): void
    {
        /** @var Collection<int, Post> $posts */
        $posts = Post::factory(3)->create();

        $resource = PostResource::collection($posts->reverse());

        $this
            ->get(route('posts.index'))
            ->assertHasPaginatedResource('posts', $resource);
    }
}
