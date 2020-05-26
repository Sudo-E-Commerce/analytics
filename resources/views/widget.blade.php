<div class="row">

@foreach ($data['include']??[] as $key => $value)

	@include($value['view'], ['id' => $key, 'data' => $value])

@endforeach

</div>