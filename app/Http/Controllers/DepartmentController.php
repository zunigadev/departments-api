<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Services\DepartmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(
 *     name="Departments",
 *     description="API para la gestión de departamentos"
 * )
 */
class DepartmentController extends Controller
{
    public function __construct(
        private DepartmentService $departmentService
    ) {}

    /**
     * Listar todos los departamentos
     *
     * @OA\Get(
     *     path="/api/departments",
     *     summary="Obtener lista de departamentos",
     *     tags={"Departments"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de departamentos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Human Resources"),
     *                 @OA\Property(property="level", type="integer", example=2),
     *                 @OA\Property(property="employee_count", type="integer", example=12),
     *                 @OA\Property(property="parent_department_id", type="integer", nullable=true, example=1),
     *                 @OA\Property(property="ambassador_first_name", type="string", nullable=true, example="John"),
     *                 @OA\Property(property="ambassador_last_name", type="string", nullable=true, example="Smith"),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-19T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-19T12:00:00Z")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return DepartmentResource::collection($this->departmentService->getAllDepartments());
    }

    /**
     * Crear un nuevo departamento
     *
     * @OA\Post(
     *     path="/api/departments",
     *     summary="Crear departamento",
     *     tags={"Departments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name","level","employee_count"},
     *             @OA\Property(property="name", type="string", example="Finance"),
     *             @OA\Property(property="level", type="integer", example=2),
     *             @OA\Property(property="employee_count", type="integer", example=8),
     *             @OA\Property(property="parent_department_id", type="integer", nullable=true, example=1),
     *             @OA\Property(property="ambassador_first_name", type="string", nullable=true, example="Mary"),
     *             @OA\Property(property="ambassador_last_name", type="string", nullable=true, example="Johnson"),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Departamento creado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Finance"),
     *             @OA\Property(property="level", type="integer", example=2),
     *             @OA\Property(property="employee_count", type="integer", example=8),
     *             @OA\Property(property="parent_department_id", type="integer", nullable=true, example=1),
     *             @OA\Property(property="ambassador_first_name", type="string", nullable=true, example="Mary"),
     *             @OA\Property(property="ambassador_last_name", type="string", nullable=true, example="Johnson"),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     )
     * )
     */
    public function store(StoreDepartmentRequest $request): DepartmentResource
    {
        return new DepartmentResource($this->departmentService->createDepartment($request->validated()));
    }

    /**
     * Mostrar un departamento específico
     *
     * @OA\Get(
     *     path="/api/departments/{id}",
     *     summary="Obtener departamento por ID",
     *     tags={"Departments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del departamento",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Departamento encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Human Resources"),
     *             @OA\Property(property="level", type="integer", example=2),
     *             @OA\Property(property="employee_count", type="integer", example=12),
     *             @OA\Property(property="parent_department_id", type="integer", nullable=true, example=1),
     *             @OA\Property(property="ambassador_first_name", type="string", nullable=true, example="John"),
     *             @OA\Property(property="ambassador_last_name", type="string", nullable=true, example="Smith"),
     *             @OA\Property(property="is_active", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-19T12:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-19T12:00:00Z")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Departamento no encontrado")
     * )
     */
    public function show(int $id): DepartmentResource
    {
        return new DepartmentResource($this->departmentService->getDepartment($id));
    }

    /**
     * Actualizar un departamento
     *
     * @OA\Put(
     *     path="/api/departments/{id}",
     *     summary="Actualizar departamento",
     *     tags={"Departments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del departamento",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Finance"),
     *             @OA\Property(property="level", type="integer", example=2),
     *             @OA\Property(property="employee_count", type="integer", example=8),
     *             @OA\Property(property="parent_department_id", type="integer", nullable=true, example=1),
     *             @OA\Property(property="ambassador_first_name", type="string", nullable=true, example="Mary"),
     *             @OA\Property(property="ambassador_last_name", type="string", nullable=true, example="Johnson"),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Departamento actualizado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Finance"),
     *             @OA\Property(property="level", type="integer", example=2),
     *             @OA\Property(property="employee_count", type="integer", example=8),
     *             @OA\Property(property="parent_department_id", type="integer", nullable=true, example=1),
     *             @OA\Property(property="ambassador_first_name", type="string", nullable=true, example="Mary"),
     *             @OA\Property(property="ambassador_last_name", type="string", nullable=true, example="Johnson"),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(response=404, description="Departamento no encontrado")
     * )
     */
    public function update(UpdateDepartmentRequest $request, int $id): DepartmentResource
    {
        return new DepartmentResource($this->departmentService->updateDepartment($id, $request->validated()));
    }

    /**
     * Eliminar un departamento
     *
     * @OA\Delete(
     *     path="/api/departments/{id}",
     *     summary="Eliminar departamento",
     *     tags={"Departments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del departamento",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Departamento eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Departamento eliminado exitosamente")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Departamento no encontrado")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->departmentService->deleteDepartment($id);
        return response()->json(['message' => 'Departamento eliminado exitosamente']);
    }

    /**
     * Listar subdepartamentos de un departamento
     *
     * @OA\Get(
     *     path="/api/departments/{id}/subdepartments",
     *     summary="Obtener subdepartamentos de un departamento",
     *     tags={"Departments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del departamento padre",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de subdepartamentos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=2),
     *                 @OA\Property(property="name", type="string", example="Finance Team"),
     *                 @OA\Property(property="level", type="integer", example=3),
     *                 @OA\Property(property="employee_count", type="integer", example=5),
     *                 @OA\Property(property="parent_department_id", type="integer", nullable=true, example=1),
     *                 @OA\Property(property="ambassador_first_name", type="string", nullable=true, example="Anna"),
     *                 @OA\Property(property="ambassador_last_name", type="string", nullable=true, example="Taylor"),
     *                 @OA\Property(property="is_active", type="boolean", example=true)
     *             )
     *         )
     *     )
     * )
     */
    public function getSubdepartments(int $id): AnonymousResourceCollection
    {
        return DepartmentResource::collection($this->departmentService->getSubdepartments($id));
    }

    /**
     * Obtener jerarquía completa de departamentos
     *
     * @OA\Get(
     *     path="/api/departments/hierarchy",
     *     summary="Obtener jerarquía de departamentos",
     *     tags={"Departments"},
     *     @OA\Response(
     *         response=200,
     *         description="Jerarquía completa de departamentos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Human Resources"),
     *                 @OA\Property(property="level", type="integer", example=2),
     *                 @OA\Property(property="employee_count", type="integer", example=12),
     *                 @OA\Property(property="parent_department_id", type="integer", nullable=true, example=null),
     *                 @OA\Property(property="ambassador_first_name", type="string", nullable=true, example="John"),
     *                 @OA\Property(property="ambassador_last_name", type="string", nullable=true, example="Smith"),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-19T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-19T12:00:00Z")
     *             )
     *         )
     *     )
     * )
     */
    public function getHierarchy(): AnonymousResourceCollection
    {
        return DepartmentResource::collection($this->departmentService->getDepartmentHierarchy());
    }
}
