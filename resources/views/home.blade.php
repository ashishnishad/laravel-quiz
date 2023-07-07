<x-app-layout>
  <x-slot name="header"></x-slot>
  <div class="row">
    <div class="col-12">
      <h2>Quiz Categories</h2>
    </div>
    <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
    <ul class="list-group">
      @if($categories)
      @foreach($categories as $key=>$category)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('quiz',$category->slug) }}">{{ $category->name }}</a>
        <span class="badge badge-primary badge-pill">{{ $category->quizzes_count }}</span>
      </li>
      @endforeach
      {{ $categories->links() }}
      @endif
    </ul>
    </div>
    <div class="col-8">
    </div>
  </div>
</x-app-layout>