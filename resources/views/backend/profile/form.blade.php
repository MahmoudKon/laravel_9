<div class="card-header {{ $bg }}">
    <span class="white">Change {{ ucfirst($form_type) }}</span>
</div>

<div class="card-body">
    <form action="{{ routeHelper("profile.$form_type") }}" method="post" class="submit-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="form_type" value="{{ $form_type }}">
        @method("PUT")

        {{-- END ROLES --}}
        @include("backend.profile.$form_type")
        {{-- END ROLES --}}

        {{-- END FORM BUTTONS --}}
        @include('backend.includes.buttons.form-buttons')
        {{-- END FORM BUTTONS --}}
    </form>
</div>
