@extends('layouts.admin.app', ['page' => __('Quiz Management'), 'pageSlug' => 'quiz'])

@push('css')
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Quiz') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('quiz.create') }}" class="btn btn-sm btn-primary">{{ __('Add Quiz') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="datatable">
                            <thead class=" text-primary">
                                <th scope="col">{{ __('ID') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Category') }}</th>
                                <th scope="col">{{ __('Creation Date') }}</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    @include('layouts.admin.includes.common_models')
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    var table = $('#datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url" : "{{ route('quiz.datatable') }}",
            "type": "POST",
            "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
        },
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'category.name', name: 'category.name'},
            {data: 'created_at', name: 'created_at'},
            { data: 'action', searchable: false, orderable: false }
        ],
        error: function (xhr, error, code) {
            console.log(xhr, code);
        }
    });
</script>
<script type="text/javascript" src="{{ asset('black/js/custom.js') }}"></script>
@endpush