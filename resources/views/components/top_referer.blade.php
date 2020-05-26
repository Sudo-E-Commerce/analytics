@php
    $date_id = $id.'_date';
@endphp
<div class="col-6" id="{{$id ?? ''}}">
    <div class="card card-info">
        <div class="card-header p-2">
            <h3 class="card-title">@lang('Analytic::general.top_referrers')</h3>
            <div class="card-tools m-0">
                <button type="button" class="btn btn-tool p-1" data-reload><i class="fas fa-redo"></i></button>
                <button type="button" class="btn btn-tool p-1" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 395px;">
            <table class="table table-bordered table-head-fixed table-sm">
                <thead>
                    <tr>
                    <th style="padding: 10px;">@lang('Analytic::general.url')</th>
                    <th style="width: 120px; padding: 10px;">@lang('Analytic::general.views')</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="card-footer p-2">
            <div class="float-left">
                @include('Analytic::form.daterangerpicker', [ 'name' => $date_id ?? '' ])
            </div>
            <div class="float-right">
                <button type="button" class="btn btn-success btn-sm text-right" data-more>@lang('Analytic::general.more')</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        {!! $date_id ?? '' !!}_page = 1;
        {!! $date_id ?? '' !!}_start = '';
        {!! $date_id ?? '' !!}_end = '';
        $('body').on('click', '#{{$id ?? ''}} *[data-reload]', function() {
            getTopReferrer({!! $date_id ?? '' !!}_page);
        })
        $('body').on('click', '#{{$id ?? ''}} *[data-more]', function() {
            {!! $date_id ?? '' !!}_page++;
            getTopReferrer({!! $date_id ?? '' !!}_page);
        })
        $('#{{$id ?? ''}} *[data-reload]').click();
        @if ($data['autoload']??'' == true)
            setInterval(function() {
                $('#{{$id ?? ''}} *[data-reload]').click();
            }, 5000);
        @endif
        $('body').on('change', '#{!! $date_id ?? '' !!}_start', function(e) {
            e.preventDefault();
            {!! $date_id ?? '' !!}_start = $('#{!! $date_id ?? '' !!}_start').val();
        });
        $('body').on('change', '#{!! $date_id ?? '' !!}_end', function(e) {
            e.preventDefault();
            {!! $date_id ?? '' !!}_page = 1;
            {!! $date_id ?? '' !!}_end = $('#{!! $date_id ?? '' !!}_end').val();
            $('#{{$id ?? ''}} *[data-reload]').click();
        });
    });
    function getTopReferrer({!! $date_id ?? '' !!}_page) {
        data = {
            'max_result': {!! $date_id ?? '' !!}_page*10,
        };
        if (!checkEmpty( {!! $date_id ?? '' !!}_start )) {
            data.date_start = {!! $date_id ?? '' !!}_start;
        }
        if (!checkEmpty( {!! $date_id ?? '' !!}_end )) {
            data.date_end = {!! $date_id ?? '' !!}_end;
        }
        loadAjaxPost('{{ route('admin.ajax.get_top_referrers') }}', data, {
            beforeSend: function(){
                $('#{{$id ?? ''}}').find('.card').addClass('loading');
            },
            success:function(result){
                $('#{{$id ?? ''}}').find('.card').removeClass('loading');
                if (result.status == 1) {
                    str = '';
                    $.each(result.data, function(index, item) {
                        str += `
                            <tr>
                                <td style="padding: 5px 10px;">${item.url}</td>
                                <td style="padding: 5px 10px;">${item.pageViews}</td>
                            </tr>
                        `;
                    });
                    $('#{{$id ?? ''}}').find('.table').find('tbody').html(str);
                } else {
                    alertText(result.message, 'error');
                }
            },
            error: function (error) {}
        }, 'no_action');
    }
</script>