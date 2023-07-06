@extends('layouts.admin.app', ['page' => __('Quiz Management'), 'pageSlug' => 'quiz'])
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
                                <h3 class="mb-0">{{ __('Quiz Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('quiz.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alerts.success')
                      	<form method="post" action="{{ route('quiz.store') }}" autocomplete="off" autocomplete='off' enctype="multipart/form-data" id="quiz_form">
                            @csrf
						  <fieldset>
						  	<h3 class="heading-small text-muted mb-4">{{ __('Step 1') }}</h3>
						      	<div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="category_id">{{ __('Category') }}</label>
                                    <select name="category_id" id="category_id" class="form-control form-control-alternative{{ $errors->has('category_id') ? ' is-invalid' : '' }} select2" required>
                                    	<option value="">Choose Category</option>
                                        @foreach($categories as $key=>$category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>                                    @include('alerts.feedback', ['field' => 'category_id'])
                                </div>
                                <div class="form-group{{ $errors->has('complexity') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="complexity">{{ __('Filter by complexity') }}</label>
                                    <select name="complexity" id="complexity" class="form-control form-control-alternative{{ $errors->has('complexity') ? ' is-invalid' : '' }} select2">
                                    	<option value="easy">Easy</option>
                                    	<option value="medium">Medium</option>
                                    	<option value="hard">Hard</option>
                                    </select>                                    @include('alerts.feedback', ['field' => 'complexity'])
                                </div>
                                <div class="form-group{{ $errors->has('question_id') ? ' has-danger' : '' }}" id="question_id">
                                    <label class="form-control-label" for="question_id">{{ __('Question') }}</label>
                                    
                                </div>
						  </fieldset>

						  <fieldset>
						  	<h3 class="heading-small text-muted mb-4">{{ __('Step 2') }}</h3>
						     <div id="listq"></div>
						  </fieldset>
						   <button type="submit" id="SaveQuestion" class="btn btn-primary submit">Save Quiz</button>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script type="text/javascript" src="{{ asset('black/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('black/wizardform/jquery.formtowizard.js') }}"></script>
<script type="text/javascript" src="{{ asset('black/wizardform/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
        var $quizForm = $( '#quiz_form' );
		$quizForm.validate({errorElement: 'em'});
		$quizForm.formToWizard({
		    submitButton: 'SaveQuestion',
		    nextBtnClass: 'btn btn-primary next',
		    prevBtnClass: 'btn btn-default prev',
		    buttonTag:    'button',
		    select: function(ele,step){
		    	console.log(ele)
		    },
		    validateBeforeNext: function(form, step) {
		        var stepIsValid = true;
		        var returnValue = false;
		        var validator = form.validate();
		        $(':input,select', step).each( function(index) {
		            var xy = validator.element(this);
		            stepIsValid = stepIsValid && (typeof xy == 'undefined' || xy);
		        });
		        if(!form.find('input[class=questChecked]:checked').length){
		        	alert('Please select question');
		        	return false;
		        }
		        //stepIsValid = false;
		        if(stepIsValid){
		        	var returnValue = delayprocess();
		        }
		        
		        return returnValue;
		    },
		    progress: function (i, count) {
		    	
		        $('#progress-complete').width(''+(i/count*100)+'%');
		    }
		});

		$quizForm.on('submit', function(e){
			e.preventDefault();

			var category_id = $("#category_id").val();
			var priorty = $('input.priorty').serialize();
			var quesids = $('input.quesids').serialize();
			$.ajax({
                url: "{{ route('quiz.save') }}",
                data: {category_id: category_id,priorty: priorty,quesids: quesids,_token: csrf_token},
                type: 'POST',
                success: function(json){
                	if(json.success){
                		$(".card-body").html('<h3>Quiz created.</h3>');
                	}
                }    
            });
		})

		$("#category_id, #complexity").on('change', function(){
			var thisObj = $(this);
			var category_id = $("#category_id").val();
			var complexity = $("#complexity").val();
            $.ajax({
                url: "{{ route('question.ajax') }}",
                data: {category_id: category_id,complexity: complexity,_token: csrf_token},
                type: 'POST',
                success: function(json){
                    $('#question_id').html(json.html);
                }    
            });
		});

    });

	function delayprocess(){
		var ques_ids = $('input[class="questChecked"]:checked').map(function() {
	        return parseInt(this.value);
	    }).get().join(',');
    	
        $.ajax({
            url: "{{ route('question.ids') }}",
            data: {ques_ids: ques_ids,_token: csrf_token},
            type: 'POST',
            async: false,
            success: function(json){
                $('#listq').html(json.html);
            }    
        });
		return true;
	}


</script>
@endpush