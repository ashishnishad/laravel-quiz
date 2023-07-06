@if($questions)
@foreach($questions as $key=>$question)
<div class="form-check">
  <label class="form-check-label">
      <input class="questChecked" type="checkbox" value="{{ $question->id }}">
      {{ $question->question }}
      <span class="form-check-sign">
          <span class="check"></span>
      </span>
  </label>
</div>
@endforeach
@endif