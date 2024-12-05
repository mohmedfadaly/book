@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4 text-primary">Books List</h1>
        @if (auth()->user()->hasRole('admin'))
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('books.export.pdf') }}" class="btn btn-success btn-sm shadow-sm">Export as PDF</a>
                <button class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#addBookModal">Add New
                    Book</button>
            </div>
        @endif
        <!-- Export Button -->


        <!-- Books Table -->
        <div class="table-responsive">
            <table id="books-table" class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be inserted dynamically here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Book Modal -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">Add New Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form to add a new book -->
                    <form action="{{ route('books.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Book Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control" id="author" name="author" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="is_available" required>
                                <option value="1">Available</option>
                                <option value="0">Not Available</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .container {
            max-width: 1000px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .modal-dialog {
            max-width: 500px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('books.index') }}',
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'author',
                        name: 'author'
                    },
                    {
                        data: 'is_available',
                        name: 'is_available'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
