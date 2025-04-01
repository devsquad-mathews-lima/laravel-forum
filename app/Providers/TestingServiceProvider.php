<?php

namespace App\Providers;

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
        if (!$this->app->runningUnitTests()) {
            return;
        }

        AssertableInertia::macro('hasPaginatedResource', function (string $key, ResourceCollection $resource) {
            $compiledResource = $resource->response()->getData(assoc: true);

            $this
                ->has($key)
                ->where("$key.data", $compiledResource['data'])
                ->hasAll("$key.data", "$key.links", "$key.meta");

            return $this;
        });

        TestResponse::macro('assertHasPaginatedResource', function (string $key, ResourceCollection $resource) {
            return $this->assertInertia(
                fn(AssertableInertia $inertia) => $inertia->hasPaginatedResource($key, $resource)
            );
        });
    }
}
