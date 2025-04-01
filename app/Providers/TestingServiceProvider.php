<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia;

class TestingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (! $this->app->runningUnitTests()) {
            return;
        }

        AssertableInertia::macro('hasResource', function (string $key, JsonResource $resource) {
            $compiledResource = $resource->response()->getData(assoc: true);

            $this
                ->has($key)
                ->where($key, $compiledResource)
                ->etc();

            return $this;
        });

        AssertableInertia::macro('hasPaginatedResource', function (string $key, ResourceCollection $resource) {
            $compiledResource = $resource->response()->getData(assoc: true);

            $this
                ->has($key)
                ->where("$key.data", $compiledResource)
                ->hasAll("$key.data", "$key.links", "$key.meta")
                ->etc();

            return $this;
        });

        TestResponse::macro('assertHasResource', function (string $key, JsonResource $resource) {
            return $this->assertInertia(
                fn (AssertableInertia $inertia) => $inertia->hasResource($key, $resource)
            );
        });

        TestResponse::macro('assertHasPaginatedResource', function (string $key, ResourceCollection $resource) {
            return $this->assertInertia(
                fn (AssertableInertia $inertia) => $inertia->hasPaginatedResource($key, $resource)
            );
        });

        TestResponse::macro('assertInertiaComponent', function (string $component) {
            return $this->assertInertia(
                fn (AssertableInertia $inertia) => $inertia->component($component, true)
            );
        });
    }
}
