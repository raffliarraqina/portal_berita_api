@extends('admin.parent')

@section('content')
    
<form action="{{ route('siswa.update', $siswa->id) }}" method="post">
    @csrf
    @method('PUT')

    <label for="" class="from-label">Name Siswa</label>
    <input type="text" class="form-control" name="name" value="{{ $siswa->name }}">

    <label for="" class="from-label">Phone Number</label>
    <input type="number" class="form-control" name="phone" value="{{ $siswa->phone }}">

    <label for="" class="from-label">Address Siswa</label>
    <textarea class="form-control" id="" cols="30" rows="10" name="address">{{ $siswa->address }}</textarea>

    <button type="submit" class="btn btn-primary mt-3">Update Siswa</button>

</form>

@endsection