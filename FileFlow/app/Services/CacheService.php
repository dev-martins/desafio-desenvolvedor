<?php

namespace App\Services;

use App\Repositories\CacheRepository;

class CacheService
{
    public function __construct(protected CacheRepository $cacheRepository)
    {
    }

    public function get(string $key)
    {
        return $this->cacheRepository->get($key);
    }

    public function put(string $key, mixed $value, ?int $seconds)
    {
        return $this->cacheRepository->put($key, $value, $seconds);
    }

    public function forget(string $key)
    {
        return $this->cacheRepository->forget($key);
    }

    public function has(string $key)
    {
        return $this->cacheRepository->has($key);
    }
}
