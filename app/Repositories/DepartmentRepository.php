<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function getAll(): Collection
    {
        return Department::all();
    }

    public function getAllWithRelations(): Collection
    {
        return Department::with(['parent', 'children'])->get();
    }

    public function find(int $id): ?Department
    {
        return Department::with(['parent', 'children'])->find($id);
    }

    public function findOrFail(int $id): Department
    {
        return Department::with(['parent', 'children'])->findOrFail($id);
    }

    public function create(array $data): Department
    {
        return Department::create($data);
    }

    public function update(int $id, array $data): Department
    {
        $department = Department::findOrFail($id);
        $department->update($data);
        return $department->load(['parent', 'children']);
    }

    public function delete(int $id): bool
    {
        return Department::destroy($id) > 0;
    }

    public function getSubdepartments(int $parentId): Collection
    {
        return Department::where('parent_id', $parentId)
                        ->with('children')
                        ->orderBy('name')
                        ->get();
    }

    public function getRootDepartments(): Collection
    {
        return Department::roots()
                        ->with('children')
                        ->orderBy('name')
                        ->get();
    }

    public function getDepartmentHierarchy(): Collection
    {
        return Department::roots()
                        ->with('children.children.children')
                        ->orderBy('name')
                        ->get();
    }
}