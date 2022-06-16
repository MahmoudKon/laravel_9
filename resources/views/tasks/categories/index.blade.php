@extends('layouts.tasks')

@section('content')
    <div class="card">
        {{-- START INCLUDE TABLE HEADER --}}
        <div class="card-header bg-info white">
            <h4 class="card-title white">List Category : {{ $count }} Rows</h4>
        </div>
        {{-- START INCLUDE TABLE HEADER --}}

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name AR</th>
                    <th>Name EN</th>
                </tr>
                </thead>
                <tbody id="load-table-data"></tbody>
            </table>

            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    @for ($i = 1; $i <= $pages; $i++)
                        <li class="page-item {{ $i == 1 ? 'active' : '' }}"><a class="page-link" href="?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                </ul>
            </nav>
        </div>
    </div>
@endsection
