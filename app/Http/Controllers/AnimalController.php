<?php
namespace App\Http\Controllers;

use App\Http\Requests\AnimalRequest;
use App\Models\Animal;
use App\Services\AnimalService;
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{
    protected $service;

    public function __construct(AnimalService $service)
    {
        $this->service = $service;

        // $permissions = [
        //     'index'   => 'view-animals',
        //     'store'   => 'create-animals',
        //     'update'  => 'edit-animals',
        //     'destroy' => 'delete-animals',
        // ];

        // foreach ($permissions as $method => $permission) {
        //     $this->middleware("permission:{$permission}")->only($method);
        // }
    }

    public function index()
    {
        $animals = $this->service->list();
        return view('animals.index', compact('animals'));
    }

    public function show(Animal $animal)
    {
        $currentUser = Auth::user();

        if ($currentUser->isFarmAdmin() && $animal->farm_id != $currentUser->farm_id) {
            abort(403, 'Unauthorized');
        }

        $animal->load('farm', 'milkProductions');

        $today     = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        $todayMilk     = $animal->milkProductions()->whereDate('recorded_at', $today)->sum('litres');
        $yesterdayMilk = $animal->milkProductions()->whereDate('recorded_at', $yesterday)->sum('litres');

        $milkDiffPercent = $yesterdayMilk > 0
            ? (($todayMilk - $yesterdayMilk) / $yesterdayMilk) * 100
            : 0;

        $monthly = $animal->milkProductions()
            ->where('recorded_at', '>=', now()->subDays(30))
            ->orderBy('recorded_at')
            ->get()
            ->groupBy(function ($row) {
                return \Carbon\Carbon::parse($row->recorded_at)->format('d M');
            })
            ->map(function ($day) {
                return $day->sum('litres');
            });

        $monthlyLabels = $monthly->keys();
        $monthlyValues = $monthly->values();

        return view('animals.show', compact(
            'animal',
            'todayMilk',
            'yesterdayMilk',
            'milkDiffPercent',
            'monthlyLabels',
            'monthlyValues'
        ));
    }

    // public function show(Animal $animal)
    // {
    //     $currentUser = Auth::user();

    //     // Farm admins can only view animals in their farm
    //     if ($currentUser->isFarmAdmin() && $animal->farm_id != $currentUser->farm_id) {
    //         abort(403, 'Unauthorized');
    //     }

    //     // Load related farm if needed
    //     $animal->load('farm');

    //     return view('animals.show', compact('animal'));
    // }

    public function create()
    {
        $currentUser = Auth::user();

        // Only super admin or farm admin can create
        if (! $currentUser->isSuperAdmin() && ! $currentUser->isFarmAdmin()) {
            abort(403);
        }

        return view('animals.create', [
            'farms' => $currentUser->isSuperAdmin()
                ? \App\Models\Farm::all()
                : \App\Models\Farm::where('id', $currentUser->farm_id)->get(),
        ]);
    }

    public function store(AnimalRequest $request)
    {
        $data        = $request->validated();
        $currentUser = Auth::user();

        // Farm admins can only create in their farm
        if ($currentUser->isFarmAdmin()) {
            $data['farm_id'] = $currentUser->farm_id;
        }

        $this->service->create($data);
        return redirect()->route('animals.index')->with('success', 'Animal created successfully.');
    }

    public function edit(Animal $animal)
    {
        $currentUser = Auth::user();

        // Farm admin can only edit their own animals
        if ($currentUser->isFarmAdmin() && $animal->farm_id != $currentUser->farm_id) {
            abort(403);
        }

        return view('animals.edit', compact('animal'));
    }

    public function update(AnimalRequest $request, Animal $animal)
    {
        $currentUser = Auth::user();

        // Farm admin can only update their own animals
        if ($currentUser->isFarmAdmin() && $animal->farm_id != $currentUser->farm_id) {
            abort(403);
        }

        $this->service->update($animal, $request->validated());
        return redirect()->route('animals.index')->with('success', 'Animal updated successfully.');
    }

    public function destroy(Animal $animal)
    {
        $currentUser = Auth::user();

        // Farm admin can only delete their own animals
        if ($currentUser->isFarmAdmin() && $animal->farm_id != $currentUser->farm_id) {
            abort(403);
        }

        $this->service->delete($animal);
        return redirect()->route('animals.index')->with('success', 'Animal deleted successfully.');
    }

    public function loadSubpanel(Request $request, Animal $animal, $panel)
    {
        $page    = $request->get('page', 1);
        $perPage = 15;

        $mapping = [
            'milk-production' => 'milkProductions',
            'reproductions'   => 'reproductions',
            'calves'          => 'calves',
            'health-checks'   => 'healthChecks',
            'vaccinations'    => 'vaccinations',
            'treatments'      => 'treatments',
            'diseases'        => 'diseases',
        ];

        if (! isset($mapping[$panel])) {
            return response()->json(['html' => '<p>Invalid panel.</p>']);
        }

        $relation = $mapping[$panel];

        $data = $animal->$relation()->orderBy('id', 'desc')->paginate($perPage);

        return response()->json([
            'html' => view('animals.partials.subpanel-table', [
                'data'  => $data,
                'panel' => $panel,
            ])->render(),
        ]);
    }
}
