@extends('admin.parent')

@section('content')

    <label for="" class="form-label">Name Santri</label>
    <input type="text" class="form-control" value="{{ $santri->name }}" readonly>

    <label for="" class="form-labe mt-3">Number Phone</label>
    <input type="text" class="form-control" value="{{ $santri->phone }}" readonly>

    <label for="" class="form-label mt-3">Address</label>
    <textarea class="form-control" cols="30" rows="10" readonly>{!! $santri->address !!}</textarea>

    <label for="" class="form-label">City</label>
    <input type="text" class="form-control" value="{{ $santri->city }}" readonly>

    <label for="" class="form-label">Date</label>
    <input type="date" class="form-control" value="{{ $santri->date }}" readonly>

    <a href="{{ route('santri.index') }}" class="btn btn-outline-info mt-3">
        Back
    </a>

@endsection
