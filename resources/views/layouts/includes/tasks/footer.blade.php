{{-- START FOOTER --}}
<footer class="footer footer-static footer-light navbar-border navbar-shadow">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
        <span class="float-md-left d-block d-md-inline-block">
            Copyright &copy; {{ date('Y') }}
            <a class="text-bold-800 grey darken-2" target="_blank">IVAS</a>
            , All rights reserved.
        </span>
        <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">
            Hand-crafted & Made with <i class="ft-heart pink"></i>
        </span>
    </p>
</footer>

{{-- END FOOTER --}}

{{-- ************** START VENDOR JS ************** --}}
<script> var main_path = "{{ url('/') }}"; </script>
<script type="text/javascript" src="{{ assetHelper('vendors/js/vendors.min.js') }}"></script>
<script type="text/javascript" src="{{ assetHelper('vendors/js/forms/select/select2.full.min.js') }}"></script>
{{-- ************** END VENDOR JS ************** --}}

{{-- ************** START FONTAWESOME JS ************** --}}
<script type="text/javascript" src="{{ assetHelper('js/scripts/fontawesome-all.min.js') }}"></script>
{{-- ************** START FONTAWESOME JS ************** --}}

{{-- ************** START MODERN JS ************** --}}
<script type="text/javascript" src="{{ assetHelper('js/core/app-menu.js') }}"></script>
<script type="text/javascript" src="{{ assetHelper('js/core/app.js') }}"></script>
{{-- ************** END MODERN JS ************** --}}


<script>
    $(document).ready(function() {
        $(`li[data-route="{{ request()->route()->action['as'] }}"]`).addClass('active').closest('.has-sub').addClass('active');


        loadTableData();

        $('body').on('click', '.page-link', function (e) {
            e.preventDefault();
            if ($(this).parent().hasClass('active'))
                return true;
            $(this).parent().addClass('active').siblings().removeClass('active');
            loadTableData($(this).attr('href'), $('#form-search').serialize());
        });


        $('body').on('submit', '#form-search', function(e){
            e.preventDefault();
            loadTableData(null, $(this).serialize());
        });

        function loadTableData(url = null, data = null) {
            url = url ?? window.location.href;
            let type = data ? "POST" : "GET";

            $('.table').addClass('load');
            $.ajax({
                url: url,
                type: type,
                data: data,
                success: function (data, textStatus, jqXHR) {
                    $('#load-table-data').html(data);
                    $('.table').removeClass('load');
                },
                error: function(jqXHR) {
                    console.log(jqXHR);
                    $('.table').removeClass('load');
                },
            });
        }
    });
</script>

@yield('script')
@stack('script')
</body>

</html>
