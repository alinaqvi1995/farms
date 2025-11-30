@extends('dashboard.includes.partial.base')
@section('title', 'Edit Animal')

@section('content')
    @php $currentUser = auth()->user(); @endphp

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Dashboard</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('farms.index') }}">Farms</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('farms.show', $animal->farm->id) }}">{{ $animal->farm->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Animal</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('animals.update', $animal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Animal Info Panel -->
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Animal Information</h5>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-light btn-sm"><i class="material-icons-outlined">save</i>
                                Update</button>
                            <a href="{{ route('animals.show', $animal->id) }}" class="btn btn-light btn-sm"><i
                                    class="material-icons-outlined">cancel</i> Cancel</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('animals.partials.animal_form')
                    </div>
                </div>
            </div>

            <!-- Subpanels -->
            @include('animals.partials.milk_productions')
            @include('animals.partials.reproductions')
            @include('animals.partials.calves')
            @include('animals.partials.health_checks')
            @include('animals.partials.vaccinations')
            @include('animals.partials.treatments')
            @include('animals.partials.diseases')
        </div>
    </form>

    <!-- Modals -->
    @include('animals.modals.milk_modal')
    @include('animals.modals.reproduction_modal')
    @include('animals.modals.calf_modal')
    @include('animals.modals.health_modal')
    @include('animals.modals.vaccination_modal')
    @include('animals.modals.treatment_modal')
    @include('animals.modals.disease_modal')
@endsection
