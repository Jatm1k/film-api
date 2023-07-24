<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\API\v1\Roles\RolesContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Role\StoreRoleRequest;
use App\Http\Requests\API\v1\Role\UpdateRoleRequest;
use App\Http\Resources\API\v1\RoleResource;
use App\Models\API\v1\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    private RolesContract $service;

    public function __construct(RolesContract $service)
    {
        $this->service = $service;

        $this->middleware(['auth', 'role:admin']);
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
    public function store(StoreRoleRequest $request)
    {
        return response()->json(
            new RoleResource(
                $this->service->storeRole($request->validated())
            ),
            Response::HTTP_CREATED
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
    public function update(UpdateRoleRequest $request, Role $role)
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
