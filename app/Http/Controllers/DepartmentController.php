<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
     /**
     * @OA\Get(
     *     path="/api/departments",
     *     summary="Listar todos los departamentos",
     *     tags={"Departments"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de departamentos"
     *     )
     * )
     */
    public function index()
    {
        return response()->json([
        'success' => true,
        'data' => Department::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
