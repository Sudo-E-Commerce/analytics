@php
	$fields = $name ?? '';
	$field_start = $name.'_start' ?? '';
	$field_end = $name.'_end' ?? '';
	$label = $label ?? '';
@endphp
<div class="form-group mb-0">
	<div id="{!! $fields !!}" style="background: #fff; cursor: pointer; padding: 4px 10px; border: 1px solid #ccc; width: 100%; height: 31px; font-size: 14px;" class="form-control">
        <i class="fa fa-calendar mr-1"></i>
        <span></span>
        <i class="fa fa-caret-down ml-1"></i>
    </div>
    <input id="{!! $fields !!}_start" type="hidden" name="{!! $fields !!}_start" value="">
    <input id="{!! $fields !!}_end" type="hidden" name="{!! $fields !!}_end" value="">
</div>
<script>
	$(function() {
        var start = moment('{{ Request()->$field_start ?? '01/01/1970' }}');
        var end = moment('{{ Request()->$field_end ?? '' }}');
        function callback(start, end) {
            if(start.format('DD/MM/YYYY') == '01/01/1970') {
                $('#{!! $fields !!} span').html('@lang('Hôm nay')');
                $('#{!! $fields !!}_start').val('').change();
                $('#{!! $fields !!}_end').val('').change();
            }else {
                $('#{!! $fields !!} span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                $('#{!! $fields !!}_start').val(start.format('YYYY-MM-DD')).change();
                $('#{!! $fields !!}_end').val(end.format('YYYY-MM-DD')).change();
            }
        }
        $('#{!! $fields !!}').daterangepicker({
            startDate: start,
            endDate: end,
            timePicker: false,
            timePicker24Hour: false,
            timePickerSeconds: false,
            ranges: {
               {{-- '@lang('Tất cả')': [moment('1970-01-01'), moment().endOf('day')], --}}
               '@lang('Hôm nay')': [moment().startOf('day'), moment().endOf('day')],
               '@lang('Hôm qua')': [moment().startOf('day').subtract(1, 'days'), moment().endOf('day').subtract(1, 'days')],
               '@lang('7 ngày qua')': [moment().startOf('day').subtract(6, 'days'), moment()],
               '@lang('30 ngày qua')': [moment().startOf('day').subtract(29, 'days'), moment()],
               '@lang('Tháng này')': [moment().startOf('month'), moment().endOf('month')],
               '@lang('Tháng trước')': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                applyLabel: "@lang('Chọn')",
                cancelLabel: "@lang('Xóa')",
                fromLabel: "@lang('Từ')",
                toLabel: "@lang('Đến')",
                customRangeLabel: "@lang('Tùy chọn')",
                daysOfWeek: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                monthNames: ["@lang('Tháng') 1", "@lang('Tháng') 2", "@lang('Tháng') 3", "@lang('Tháng') 4", "@lang('Tháng') 5", "@lang('Tháng') 6", "@lang('Tháng') 7", "@lang('Tháng') 8", "@lang('Tháng') 9", "@lang('Tháng') 10", "@lang('Tháng') 11", "@lang('Tháng') 12"],
                firstDay: 1
            }
        }, callback);
        callback(start, end);
    });
</script>