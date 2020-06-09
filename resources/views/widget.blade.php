<div class="row">

@foreach ($data['include']??[] as $key => $value)
	@if (checkRole('widget_'.$key))
		@include($value['view'], ['id' => $key, 'data' => $value])
	@endif
@endforeach

</div>