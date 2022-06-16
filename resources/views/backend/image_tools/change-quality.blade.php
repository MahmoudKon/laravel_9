@extends('layouts.backend')

@section('content')
<div class="card">
    {{-- START INCLUDE TABLE HEADER --}}
    <div class="card-header bg-info white">
        <h4 class="card-title white">
            {{ trans('menu.'.getModel()) }}
        </h4>

        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse" data-toggle="tooltip" title="@lang('title.minus-section')" ><i class="ft-minus"></i></a></li>
                <li><a data-action="expand" data-toggle="tooltip" title="@lang('title.full-page')" ><i class="ft-maximize"></i></a></li>
                <li><a data-action="close" data-toggle="tooltip" title="@lang('title.remove-section')" ><i class="ft-x"></i></a></li>
            </ul>
        </div>
    </div>
    {{-- START INCLUDE TABLE HEADER --}}

    <div class="card-content collpase show">
        <div class="card-body">

            <div class="row">
                <fieldset class="col-md-8">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn bg-gradient-x2-grey-blue text-white btn-sm download-cropped" type="button">
                                <i class="fa fa-download"></i> Download Cropped Image
                            </button>
                        </div>

                        <div class="custom-file">
                            <input type="file" class="custom-file-input cursor-pointer upload-image" id="upload-image" accept="image/*">
                            <label class="custom-file-label" for="upload-image"><i class="fa fa-upload"></i> Choose file</label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="col-md-4">
                    <div class="form-group">
                        <div class="input-group">
                            <label class="mx-2 pt-1">Image Qulity</label>
                            <input type="number" min="1" data-step="5" max="100" class="touchspin-color" id="image-qulity" value="90" data-bts-postfix="%" placeholder="Image Qulity">
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="row mb-1">
                <div class="col-md-12">

                    <div class="overflow-hidden">
                        <img class="main-demo-image img-fluid" alt="Select Picture">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script type="text/javascript" src="{{ assetHelper('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
    <script type="text/javascript" src="{{ assetHelper('js/scripts/forms/input-groups.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/compressorjs/1.1.1/compressor.min.js"
        integrity="sha512-VaRptAfSxXFAv+vx33XixtIVT9A/9unb1Q8fp63y1ljF+Sbka+eMJWoDAArdm7jOYuLQHVx5v60TQ+t3EA8weA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(function() {
            let file = false;
            $('.download-cropped-canvas-btn, .download-cropped').on('click',function(){
                var a = document.createElement("a");
                a.href = $('.main-demo-image').attr('src');
                a.download = `${Math.floor(Date.now() / 1000)}.png`;
                a.click();
                a.remove;
            });

            $('#image-qulity').on('change keyup', function() {
                if ($(this).val() <= 100) compressor(file);
            });

            $('#upload-image').change(function(e) {
                file = e.target.files[0];
                compressor(file);
            });

            function compressor(file)
            {
                if (!file) return;
                new Compressor(file, {
                    quality: ($('#image-qulity').val() / 100),
                    success(result) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('.main-demo-image').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(result);
                    },
                    error(err) { console.log(err.message); },
                });
            }
        });
    </script>
@endpush
