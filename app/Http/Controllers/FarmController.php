<?php

namespace App\Http\Controllers;

use App\Http\Requests\FarmRequest;
use App\Models\Farm;
use App\Services\FarmService;
use Illuminate\Support\Facades\Auth;

class FarmController extends Controller
{
    protected $service;

    public function __construct(FarmService $service)
    {
        $this->service = $service;

        // $permissions = [
        //     'index'   => 'view-farms',
        //     'store'   => 'create-farms',
        //     'update'  => 'edit-farms',
        //     'destroy' => 'delete-farms',
        // ];

        // foreach ($permissions as $method => $permission) {
        //     $this->middleware("permission:{$permission}")->only($method);
        // }
    }

    public function index()
    {
        $this->authorize('viewAny', Farm::class);
        $farms = $this->service->list();
        return view('farms.index', compact('farms'));
    }

    public function show(int $id)
    {
        $currentUser = Auth::user();
        $farm = $this->service->find($id);

        if (!$farm) {
            abort(404, 'Farm not found');
        }

        if ($currentUser->isFarmAdmin() && $farm->id != $currentUser->farm_id) {
            abort(403, 'Unauthorized');
        }

        return view('farms.show', compact('farm'));
    }

    public function create()
    {
        $currentUser = Auth::user();

        // Only super admin can create
        if (!$currentUser->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        return view('farms.create');
    }

    public function store(FarmRequest $request)
    {
        $currentUser = Auth::user();

        if (!$currentUser->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $this->service->create($request->validated());
        return redirect()->route('farms.index')->with('success', 'Farm created successfully.');
    }

    public function edit(Farm $farm)
    {
        $currentUser = Auth::user();

        // Farm admin can edit only their farm, super admin can edit all
        if ($currentUser->isFarmAdmin() && $farm->id != $currentUser->farm_id) {
            abort(403, 'Unauthorized');
        }

        return view('farms.edit', compact('farm'));
    }

    public function update(FarmRequest $request, Farm $farm)
    {
        $currentUser = Auth::user();

        if ($currentUser->isFarmAdmin() && $farm->id != $currentUser->farm_id) {
            abort(403, 'Unauthorized');
        }

        $this->service->update($farm, $request->validated());

        if ($currentUser->isSuperAdmin()) {
            return redirect()->route('farms.index')->with('success', 'Farm updated successfully.');
        } else {
            return back()->with('success', 'Farm updated successfully.');
        }
    }

    public function destroy(Farm $farm)
    {
        $currentUser = Auth::user();

        // Only super admin can delete
        if (!$currentUser->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $this->service->delete($farm);
        return redirect()->route('farms.index')->with('success', 'Farm deleted successfully.');
    }
}
