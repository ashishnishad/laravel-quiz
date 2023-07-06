@if($questions)
@foreach($questions as $key=>$question)
<div class="row">
	<div class="col">
		<label>Quest. {{$key+1}} {{ $question->question }}</label>
		<input type="number" class="form-control priorty" placeholder="Position" name="priorty[{{$question->id}}]" value="0" >
		<input type="hidden" class="quesids" name="quesids[]" value="{{$question->id}}" >
	</div>
</div>
@endforeach
@endif