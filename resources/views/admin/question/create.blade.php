@extends('layouts.admin.app', ['page' => __('Question Management'), 'pageSlug' => 'question'])
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('black/libs/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Question Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('question.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alerts.success')
                        <form method="post" action="{{ route('question.store') }}" autocomplete="off" autocomplete='off' enctype="multipart/form-data">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Question information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="category_id">{{ __('Category') }}</label>
                                    <select name="category_id" id="category_id" class="form-control form-control-alternative{{ $errors->has('category_id') ? ' is-invalid' : '' }} select2">
                                        @foreach($categories as $key=>$category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>                                    @include('alerts.feedback', ['field' => 'category_id'])
                                </div>
                                <div class="form-group{{ $errors->has('question') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="question">{{ __('Question') }}</label>
                                    <textarea name="question" id="question" class="form-control form-control-alternative{{ $errors->has('question') ? ' is-invalid' : '' }}" placeholder="{{ __('Question') }}" autofocus>{{ old('question') }}</textarea>
                                    @include('alerts.feedback', ['field' => 'question'])
                                </div>
                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="status">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-control form-control-alternative{{ $errors->has('status') ? ' is-invalid' : '' }}">
                                        <option value="enabled">Enable</option>
                                        <option value="disabled">Disable</option>
                                    </select>                                    @include('alerts.feedback', ['field' => 'status'])
                                </div>
                                <div class="form-group{{ $errors->has('complexity') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="complexity">{{ __('Complexity point') }}</label>
                                    <select name="complexity" id="complexity" class="form-control form-control-alternative{{ $errors->has('complexity') ? ' is-invalid' : '' }}">
                                        <option value="easy">Easy</option>
                                        <option value="medium">Medium</option>
                                        <option value="hard">Hard</option>
                                    </select>                                    @include('alerts.feedback', ['field' => 'complexity'])
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success mt-5">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script type="text/javascript" src="{{ asset('black/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush