<?php

namespace Feature\Controllers\PostController;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
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
        $this->get(route('posts.index'))
            ->assertInertia(fn (AssertableInertia $inertia) => $inertia
                ->has('posts')
            );
    }
}
