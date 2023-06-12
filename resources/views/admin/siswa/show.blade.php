@extends('admin.parent')

@section('content')

    <label for="" class="form-label">Name Siswa</label>
    <input type="text" class="form-control" value="{{ $siswa->name }}" readonly>

    <label for="" class="form-labe mt-3">Number Phone</label>
    <input type="text" class="form-control" value="{{ $siswa->phone }}" readonly>

    <label for="" class="form-label mt-3">Address</label>
    <textarea class="form-control" cols="30" rows="10" readonly>{!! $siswa->address !!}</textarea>

    <a href="{{ route('siswa.index') }}" class="btn btn-outline-info mt-3">
        Back
    </a>

@endsection
