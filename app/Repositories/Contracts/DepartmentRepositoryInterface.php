<?php

namespace App\Repositories\Contracts;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

interface DepartmentRepositoryInterface
{
    public function getAll(): Collection;
    public function getAllWithRelations(): Collection;
    public function find(int $id): ?Department;
    public function findOrFail(int $id): Department;
    public function create(array $data): Department;
    public function update(int $id, array $data): Department;
    public function delete(int $id): bool;
    public function getSubdepartments(int $parentId): Collection;
    public function getRootDepartments(): Collection;
    public function getDepartmentHierarchy(): Collection;
}