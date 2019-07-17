<?php

namespace Gabia\LaravelDto;

use Illuminate\Support\ServiceProvider;

class LaravelDtoProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving(function ($object, $app) {
            $dto_mapper = DtoMapperFactory::getMapper($object);

            if ($dto_mapper) {
                $dto = $dto_mapper->createDto($object, $app->request);

                $abstract = get_class($object);
                $app->rebinding($abstract, function () use ($dto) {
                    return $dto;
                });
            }
        });
    }
}
