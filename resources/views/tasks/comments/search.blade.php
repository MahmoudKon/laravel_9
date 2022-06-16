@push('style')
<link rel="stylesheet" type="text/css" href="{{ assetHelper('vendors/css/forms/selects/select2.min.css') }}">
@endpush

<form id="form-search" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">

            <div class="col-md-12">
                {{-- START USER --}}
                <div class="form-group">
                    <label>Select User</label>
                    <select class="select2 form-control" multiple name="user_id[]" id="users">
                        <option value="">@lang('inputs.please-select')</option>
                        @foreach ($users as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- END USER --}}
            </div>

            <div class="col-md-12">
                {{-- START CATEGORIES --}}
                <div class="form-group">
                    <label>Select Category</label>
                    <select class="select2 form-control" multiple name="category_id[]" id="categories">
                        <option value="">@lang('inputs.please-select')</option>
                        @foreach ($categories as $id => $name)
                        @php $name = json_decode($name); @endphp
                            <option value="{{ $id }}">{{ "$name->ar - $name->en" }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- END CATEGORIES --}}
            </div>

            <div class="col-md-12">
                {{-- START POSTS --}}
                <div class="form-group">
                    <label>Select Post</label>
                    <select class="select2 form-control" multiple name="post_id[]" id="posts"></select>
                </div>
                {{-- END POSTS --}}
            </div>

            <div class="col-md-12">
                {{-- START START DATE --}}
                <div class="form-group">
                    <label>Select Start Date</label>
                    <input type="date" class="form-control" name="start_date">
                </div>
                {{-- END START DATE --}}
            </div>

            <div class="col-md-12">
                {{-- START START DATE --}}
                <div class="form-group">
                    <label>Select End Date</label>
                    <input type="date" class="form-control" name="end_date">
                </div>
                {{-- END START DATE --}}
            </div>
        </div>
    </div>

    @include('backend.includes.buttons.form-buttons')
</form>

@push('script')
<script type="text/javascript" src="{{ assetHelper('js/scripts/forms/select/form-select2.js') }}"></script>

<script>
    $(function() {
        $('body').on('change', '#users, #categories', function() {
            let users = $('#users').val();
            let categories = $('#categories').val();
            let posts = $('#posts');
            posts.select2().empty();

            $.ajax({
                type: "post",
                url: "{{ routeHelper('tasks.comments.get.posts') }}",
                data: {users: users, categories: categories, _token: "{{ csrf_token() }}"},
                success: function (response) {
                    $.each(response.posts, function (index, post) {
                        console.log(post);
                        posts.append(`<option value="${post.id}">${post.title}</option>`);
                    });
                    posts.select2();
                },
                error: function (response) {
                    console.log(response);
                }
            });

        });
    })
</script>
@endpush
