<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

abstract class BaseRepository
{
    protected Model $model;
    protected string $cachePrefix;
    protected int $cacheTTL = 3600;

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function find(int $id): ?Model
    {
        return Cache::remember("{$this->cachePrefix}.{$id}", $this->cacheTTL, function () use ($id) {
            return $this->model->find($id);
        });
    }

    public function create(array $data): Model
    {
        $model = $this->model->create($data);
        $this->clearCache();
        return $model;
    }

    public function update(int $id, array $data): bool
    {
        $model = $this->find($id);
        $updated = $model->update($data);
        $this->clearCache();
        return $updated;
    }

    public function delete(int $id): bool
    {
        $deleted = $this->model->destroy($id);
        $this->clearCache();
        return (bool) $deleted;
    }

    protected function clearCache(): void
    {
        Cache::tags([$this->cachePrefix])->flush();
    }
}
