<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\API\v1\Roles\RolesContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\v1\RoleResource;
use App\Models\API\v1\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private RolesContract $service;

    public function __construct(RolesContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::query()->get();
        return response()->json(RoleResource::collection($roles));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json(
            new RoleResource(
                $this->service->storeRole($request->validated())
            )
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return response()->json(new RoleResource($role));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        return response()->json([
            'status' => $this->service->updateRole($role, $request->validated())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        return response()->json([
            'status' => $this->service->destroyRole($role)
        ]);
    }
}
