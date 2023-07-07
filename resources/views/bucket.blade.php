<x-app-layout>
  <x-slot name="header"></x-slot>
  <div class="row">
    <div class="col-12">
      <h2>Bucket</h2>
    </div>
    <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
      @if(Auth::check())
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
        	Quiz
          <a href="{{ route('quiz_start',['quiz_id'=>$quiz_id,'bucket_id'=> $bucket_id]) }}">Start Quiz</a>
        </li>
      </ul>
      @else
      <label class="alert alert-warning">Login Required!</label>
      <a href="{{ route('login') }}">Login</a>
      @endif
    </div>
    <div class="col-8">
    </div>
  </div>
</x-app-layout>