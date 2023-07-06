@extends('layouts.admin.app', ['page' => __('Category Management'), 'pageSlug' => 'category'])
@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Category Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alerts.success')
                        <form method="post" action="{{ route('category.store') }}" autocomplete="off" autocomplete='off' enctype="multipart/form-data">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Category information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="name">{{ __('Category') }}</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Category') }}" value="{{ old('name') }}" autofocus>
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="status">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-control form-control-alternative{{ $errors->has('status') ? ' is-invalid' : '' }}">
                                        <option value="enabled">Enable</option>
                                        <option value="disabled">Disable</option>
                                    </select>                                    @include('alerts.feedback', ['field' => 'status'])
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