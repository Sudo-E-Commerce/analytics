<div class="col-lg-3 col-6" id="{{$id ?? ''}}">
    <!-- small box -->
    <div class="small-box bg-info">
        <div class="inner">
            <h3>@lang('Analytic::general.uploading')</h3>
            <p>@lang('Analytic::general.active_visitor')</p>
        </div>
        <div class="icon">
            <i class="fas fa-users"></i>
        </div>
        <a href="#" class="small-box-footer text-sm p-1 reload">@lang('Analytic::general.click_to_reload')</a>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('body').on('click', '#{{$id ?? ''}} .reload', function() {
            getActiveVisitor();
        })
        $('#{{$id ?? ''}} .reload').click();
        @if ($data['autoload']??'' == true)
            setInterval(function() {
                $('#{{$id ?? ''}} .reload').click();
            }, 5000);
        @endif
    });
    function getActiveVisitor() {
        loadAjaxPost('{{ route('admin.ajax.get_active_visitors') }}', {}, {
            beforeSend: function(){
                $('#{{$id ?? ''}}').find('.small-box').addClass('loading');
            },
            success:function(result){
                $('#{{$id ?? ''}}').find('.small-box').removeClass('loading');
                $('#{{$id ?? ''}}').find('h3').html(result);
            },
            error: function (error) {}
        }, 'no_action');
    }
</script>