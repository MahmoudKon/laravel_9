@extends('layouts.tasks')

@section('content')
    <div class="card">
        {{-- START INCLUDE TABLE HEADER --}}
        <div class="card-header bg-info white">
            <h4 class="card-title white">List Comments</h4>
        </div>
        {{-- START INCLUDE TABLE HEADER --}}

        @include('tasks.comments.search')

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Comment</th>
                        <th>Post Title</th>
                        <th>User</th>
                        <th>Category</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody id="load-table-data"></tbody>
            </table>
        </div>
    </div>
@endsection
