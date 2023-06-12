@extends('admin.parent')

@section('content')

@if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endforeach
        @endif

<form action="{{ route('santri.store') }}" method="post">
    @csrf
    @method('POST')

    <label for="" class="from-label">Name Santri</label>
    <input type="text" class="form-control" name="name">

    <label for="" class="from-label">Phone Number</label>
    <input type="number" class="form-control" name="phone">

    <label for="" class="from-label">Address Santri</label>
    <textarea class="form-control" id="" cols="30" rows="10" name="address"></textarea>

    <label for="" class="from-label">City</label>
    <input type="text" class="form-control" name="city">

    <label for="" class="from-label">Date</label>
    <input type="date" class="form-control" name="date">

    <button type="submit" class="btn btn-primary mt-3">Add Santri</button>

</form>

@endsection