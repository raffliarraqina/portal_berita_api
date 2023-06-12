@extends('admin.parent')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Category</h5>

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house-door"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('category.index') }}">News</a></li>
                </ol>
            </nav>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        {{ $error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endif

            <div class="col-md-12">
                <form action="{{ route('searchCategory') }}" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="seacrh category"
                            aria-describedby="button-addon2" name="keyword">
                        <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>

                    </div>
                </form>
            </div>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                <i class="ri-add-circle-fill"></i> Add Data
            </button>
            @include('admin.category.create-modal')

            <!-- Table with stripped rows -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">slug</th>
                        <th scope="col">Image</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($category as $row)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->slug }}</td>
                            <td>
                                <img src="{{ $row->image }}" class="w-25" alt="">
                            </td>
                            <td>
                                {{ $row->created_at }}
                            </td>
                            <td>

                                <button type="button" class="btn btn-warning mb-1" data-bs-toggle="modal"
                                    data-bs-target="#editCategoryModal{{ $row->id }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                @include('admin.category.edit-modal')

                                <form action="{{ route('category.destroy', $row->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger mt-1" type="submit">
                                        <i class="bi bi-trash-fill"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-octagon me-1"></i>
                                    No Data
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </th>
                        </tr>
                    @endforelse

                </tbody>
            </table>

            {{ $category->links('pagination::bootstrap-5') }}
            <!-- End Table with stripped rows -->

        </div>
    </div>

@endsection
