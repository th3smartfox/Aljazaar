@extends('layouts.vertical', ['title' => 'Drawer Page Content'])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
@endsection

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Dynamic Content</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);">Dynamic Content</a></li>
                <li class="breadcrumb-item active">Drawer Page</li>
            </ol>
        </div>
    </div>

    <!-- Datatables -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">

                <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Drawer Page Content List</h5>
                    <a href="{{ route('drawer-pages.create') }}" class="btn btn-primary" id="createButton">
                        <i data-feather="plus" class="me-1" style="width: 16px;"></i>
                        Create New
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

                    <table id="datatable" class="table table-bordered dt-responsive table-hover table-responsive nowrap align-middle">
                        <thead>
                            <tr>
                                <th>App Name (Title)</th>
                                <th>My Account Button</th>
                                <th>Wallet Button</th>
                                <th>Messages Button</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drawerPages as $page)
                                @php
                                    $myAccountData = is_array($page->button_my_account) ? $page->button_my_account : json_decode($page->button_my_account, true);
                                    $walletData = is_array($page->button_wallet) ? $page->button_wallet : json_decode($page->button_wallet, true);
                                    $messagesData = is_array($page->button_messages) ? $page->button_messages : json_decode($page->button_messages, true);
                                @endphp
                                <tr>
                                    <td>{{ $page->title }}</td>
                                    <td>
                                        {{ $myAccountData['title'] ?? $page->button_my_account }}
                                        @if (isset($myAccountData['is_subtitle']) && $myAccountData['is_subtitle'])
                                            <span class="badge bg-info-subtle text-info ms-1">Subtitle</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $walletData['title'] ?? $page->button_wallet }}
                                        @if (isset($walletData['is_subtitle']) && $walletData['is_subtitle'])
                                            <span class="badge bg-info-subtle text-info ms-1">Subtitle</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $messagesData['title'] ?? $page->button_messages }}
                                        @if (isset($messagesData['is_subtitle']) && $messagesData['is_subtitle'])
                                            <span class="badge bg-info-subtle text-info ms-1">Subtitle</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($page->status)
                                            <span class="badge bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('drawer-pages.edit', $page->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('drawer-pages.destroy', $page->id) }}" method="POST"
                                                class="delete-form" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-danger delete-btn">Delete</button>
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
        // Delete confirmation script
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    if (confirm('Are you sure you want to delete this item?')) {
                        btn.closest('form').submit();
                    }
                });
            });
        });
    </script>
@endsection