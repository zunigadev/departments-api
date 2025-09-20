<?php

namespace App\Services;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class DepartmentService
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    ) {}

    public function getAllDepartments(): Collection
    {
        return $this->departmentRepository->getAllWithRelations();
    }

    public function getDepartment(int $id): Department
    {
        return $this->departmentRepository->findOrFail($id);
    }

    public function createDepartment(array $data): Department
    {
        $cleanData = collect($data)->only([
            'name', 
            'parent_id', 
            'level', 
            'employee_count', 
            'ambassador_name'
        ])->toArray();

        $cleanData = $this->enrichDepartmentData($cleanData);
        
        $this->validateDepartmentHierarchy($cleanData);
        
        return $this->departmentRepository->create($cleanData);
    }

    public function updateDepartment(int $id, array $data): Department
    {

        if (isset($data['parent_id'])) {
            $this->validateNoCircularReference($id, $data['parent_id']);
        }
        
        return $this->departmentRepository->update($id, $data);
    }

    public function deleteDepartment(int $id): bool
    {
        $subdepartments = $this->departmentRepository->getSubdepartments($id);
        
        if ($subdepartments->isNotEmpty()) {
            throw ValidationException::withMessages([
                'department' => ['No se puede eliminar un departamento con subdepartamentos']
            ]);
        }
        
        return $this->departmentRepository->delete($id);
    }

    public function getSubdepartments(int $parentId): Collection
    {
        $this->departmentRepository->findOrFail($parentId);
        
        return $this->departmentRepository->getSubdepartments($parentId);
    }

    public function getDepartmentHierarchy(): Collection
    {
        return $this->departmentRepository->getDepartmentHierarchy();
    }

    private function enrichDepartmentData(array $data): array
    {
        if (!isset($data['level'])) {
            $data['level'] = rand(1, 10);
        }
        
        if (!isset($data['employee_count'])) {
            $data['employee_count'] = rand(1, 100);
        }
        
        return $data;
    }

    private function validateDepartmentHierarchy(array $data): void
    {
        if (isset($data['parent_id'])) {
            $parent = $this->departmentRepository->find($data['parent_id']);
            
            if ($parent && isset($data['level']) && $data['level'] <= $parent->level) {
                throw ValidationException::withMessages([
                    'level' => ['El nivel del departamento debe ser mayor al de su departamento padre']
                ]);
            }
        }
    }

    private function validateNoCircularReference(int $departmentId, int $parentId): void
    {
        if ($departmentId === $parentId) {
            throw ValidationException::withMessages([
                'parent_id' => ['Un departamento no puede ser padre de sí mismo']
            ]);
        }
        
        $parent = $this->departmentRepository->find($parentId);
        if (!$parent) return;
        
        $currentParentId = $parent->parent_id;
        
        while ($currentParentId !== null) {
            if ($currentParentId === $departmentId) {
                throw ValidationException::withMessages([
                    'parent_id' => ['Esta asignación crearía un ciclo en la jerarquía']
                ]);
            }
            
            $currentParent = $this->departmentRepository->find($currentParentId);
            $currentParentId = $currentParent?->parent_id;
        }
    }
}