@extends('layouts.vertical', ['title' => 'Category Management'])

@section('css')
    {{-- Datatables CSS from your original file --}}
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
@endsection

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Category Management</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);">Categories</a></li>
                <li class="breadcrumb-item active">List</li>
            </ol>
        </div>
    </div>

    <!-- Datatables -->
    <div class="row">
        <div class="col-12">
            <!-- UI Improvement: Added shadow-sm and border-0 for a cleaner look -->
            <div class="card shadow-sm border-0">

                <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Category List</h5>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary" id="createButton">
                        <i data-feather="plus" class="me-1" style="width: 16px;"></i>
                        Create Category
                    </a>
                </div><!-- end card header -->

                <div class="card-body">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- UI Improvement: Added table-hover and align-middle -->
                    <table id="datatable" class="table table-bordered dt-responsive table-hover table-responsive nowrap align-middle">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="text-center">
                                        @if ($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                                class="rounded-circle" height="40" width="40" style="object-fit: cover;">
                                        @else
                                            {{-- Placeholder icon --}}
                                            <span class="badge bg-light text-dark rounded-circle p-2">
                                                <i data-feather="image" style="width: 20px; height: 20px;"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->status)
                                            <span class="badge bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- No @can check needed, route is admin-only --}}
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                                class="delete-user-form" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-danger delete-user-btn">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['resources/js/pages/datatable.init.js'])
    <script>
        // Delete confirmation script from your original file
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-user-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    if (confirm('Are you sure you want to delete this category?')) {
                        btn.closest('form').submit();
                    }
                });
            });
        });
    </script>
@endsection