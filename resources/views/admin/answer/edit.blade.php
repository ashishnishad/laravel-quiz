@extends('layouts.admin.app', ['page' => __('Answer Management'), 'pageSlug' => 'answer'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Edit answer') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('answer.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alerts.success')
                        <form method="post" action="{{ route('answer.update',$answer) }}" autocomplete='off' enctype="multipart/form-data">
                            <h6 class="heading-small text-muted mb-4">{{ __('answer information') }}</h6>
                            <div class="pl-lg-4">
                                @csrf
                                @method('PATCH')
                                <div class="form-group{{ $errors->has('question_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="question_id">{{ __('Question') }}</label>
                                    <select name="question_id" id="question_id" class="form-control form-control-alternative{{ $errors->has('question_id') ? ' is-invalid' : '' }}">
                                        @foreach($questions as $key=>$question)
                                        <option value="{{ $question->id }}" {{ $question->id==$answer->question_id?'selected':'' }}>{{ $question->question }}</option>
                                        @endforeach
                                    </select>                                    @include('alerts.feedback', ['field' => 'question_id'])
                                </div>
                                 <div class="form-group{{ $errors->has('answer_option') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="answer_option">{{ __('Answer') }}</label>
                                    <textarea name="answer_option" id="answer_option" class="form-control form-control-alternative{{ $errors->has('answer_option') ? ' is-invalid' : '' }}" placeholder="{{ __('Answer') }}" autofocus>{{ old('answer_option',$answer->answer_option) }}</textarea>
                                    @include('alerts.feedback', ['field' => 'answer_option'])
                                </div>
                                <div class="form-group{{ $errors->has('is_correct') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="is_correct">{{ __('Correct') }}</label>
                                    <select name="is_correct" id="is_correct" class="form-control form-control-alternative{{ $errors->has('is_correct') ? ' is-invalid' : '' }}">
                                        <option value="yes" {{ $answer->is_correct == 'yes' ? 'selected':'' }}>Yes</option>
                                        <option value="no" {{ $answer->is_correct == 'no'? 'selected':'' }}>No</option>
                                    </select>                                    @include('alerts.feedback', ['field' => 'is_correct'])
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Update') }}</button>
                                    <a href="javascript:;" data-href="{{ route('answer.remove',$answer->id) }}" data-toggle="modal" data-target="#confirm-delete" class="delete btn btn-danger mt-4">Delete</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.admin.includes.common_models', ['redirect'=>route('answer.index')])
@endsection

@push('js')
<script type="text/javascript" src="{{ asset('black/js/custom.js') }}"></script>
@endpush