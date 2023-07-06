@extends('layouts.admin.app', ['page' => __('Category Management'), 'pageSlug' => 'category'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Edit Category') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('category.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alerts.success')
                        <form method="post" action="{{ route('category.update',$category) }}" autocomplete='off' enctype="multipart/form-data">
                            <h6 class="heading-small text-muted mb-4">{{ __('Category information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="name">{{ __('Category') }}</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Category') }}" value="{{ old('name',$category->name) }}" autofocus>
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                    @csrf
                                    @method('PATCH')
                                    <label for="status">Parent</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="0" {{$category->status=='enabled'?'selected':''}}>Enable</option>
                                        <option value="0" {{$category->status=='disabled'?'selected':''}}>Disable</option>
                                    </select>                                   @include('alerts.feedback', ['field' => 'status'])
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <a href="javascript:;" data-href="{{ route('category.remove',$category->id) }}" data-toggle="modal" data-target="#confirm-delete" class="delete btn btn-danger mt-4">Delete</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.admin.includes.common_models', ['redirect'=>route('category.index')])
@endsection

@push('js')
<script type="text/javascript" src="{{ asset('black/js/custom.js') }}"></script>
@endpush