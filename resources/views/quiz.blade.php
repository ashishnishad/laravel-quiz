<x-app-layout>
  <x-slot name="header"></x-slot>
  <div class="row">
    <div class="col-12">
      <h2>Category: {{ $category->name }}</h2>
    </div>
    <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
      <h2>Quizzes</h2>
      @if($category->quizzes)
      <ul class="list-group">
        @foreach($category->quizzes as $key=>$quiz)
        <li class="list-group-item d-flex justify-content-between align-items-center">
        	{{ $quiz->name }}
          <a href="{{ route('bucket',$quiz->id) }}">Add to bucket</a>
        </li>
        @endforeach
      </ul>
      @endif
    </div>
    <div class="col-8">
    </div>
  </div>
</x-app-layout>