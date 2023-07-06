<x-app-layout>
    <x-slot name="header"></x-slot>
      <h2>Welcome {{ auth()->user()->first_name }},</h2>
      <div class="container mt-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-10 col-lg-10">
                <div class="border">
                    <div class="question bg-white p-3 border-bottom">
                        <div class="d-flex flex-row justify-content-between align-items-center mcq">
                            <h4>MCQ Quiz</h4><span>(<span class="current_page"></span> of <span class="total_page"></span>)</span></div>
                    </div>
                    <div class="question bg-white p-3 border-bottom">
                      <div class="d-flex flex-row align-items-center question-title">
                        <h3 class="text-danger">Q<span class="current_page"></span>.</h3>
                        <h5 class="mt-1 ml-2 q_question"></h5>
                        <input type="hidden" name="ques_id" class="ques_id" value="1">
                      </div>
                      <div class="optionDiv">
                      <!--- options here !-->
                      </div>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center p-3 bg-white">
                      <button class="btn btn-primary d-flex align-items-center btn-danger prevQuest" type="button"><i class="fa fa-angle-left mt-1 mr-1"></i>&nbsp;Previous</button>
                      <button class="btn btn-primary border-success align-items-center btn-success nextQuest" type="button">Next<i class="fa fa-angle-right ml-2"></i></button>
                      <button class="btn btn-primary border-success align-items-center btn-success submitQuest" type="button" style="display: none;">Submit<i class="fa fa-angle-right ml-2"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="cssjss">
      <script type="text/javascript">
        page = 1;
        $(".nextQuest").click(function(){
          var ques_id = $(".ques_id").val();
          var options = $('input.q_option').serialize();
          $.ajax({
            url: "{{ route('quiz_questions') }}",
            data: {quiz_id: {{ $quiz_id }},ques_id:ques_id,options:options,action: 'next',_token: csrf_token,page:page+1},
            type: 'GET',
            success: function(json){
              if(json.success){
                setOptions(json);
              }
            }    
          });
        });

        $(".prevQuest").click(function(){
          var ques_id = $(".ques_id").val();
          var options = $('input.q_option').serialize();
          $.ajax({
            url: "{{ route('quiz_questions') }}",
            data: {quiz_id: {{ $quiz_id }},ques_id:ques_id,options:options,action: 'prev',_token: csrf_token,page:page-1},
            type: 'GET',
            success: function(json){
              if(json.success){
                setOptions(json);
              }
            }    
          });
        });

        $(".submitQuest").click(function(){
          var ques_id = $(".ques_id").val();
          var options = $('input.q_option').serialize();
          $.ajax({
            url: "{{ route('quiz_questions') }}",
            data: {quiz_id: {{ $quiz_id }},ques_id:ques_id,options:options,action: 'next',_token: csrf_token,page:page-1},
            type: 'GET',
            success: function(json){
              if(json.success){
                window.location.href = "{{ route('quiz_result', $quiz_id) }}";
              }
            }    
          });
        });

        $(document).ready(function(){
          $.ajax({
            url: "{{ route('quiz_questions') }}",
            data: {quiz_id: {{ $quiz_id }},page:page,_token: csrf_token,action: ''},
            type: 'GET',
            success: function(json){
              if(json.success){
                setOptions(json);
              }
            }    
          });
        });

        function setOptions(json){
          if(json.first_page)
          $('.prevQuest').prop('disabled', true);
          else
          $('.prevQuest').prop('disabled', false);
          if(json.last_page){
            $('.nextQuest').hide();
            $('.submitQuest').show();
          }else{
            $('.nextQuest').prop('disabled', false);
          }

          $('.total_page').text(json.total_page);
          $('.current_page').text(json.current_page);
          $(".q_question").text(json.question.question);
            $(".ques_id").val(json.question.id);
            var toAppend = [];
          
            json.options.forEach(function(item) {
              if(jQuery.inArray(item.id, json.s_options) !== -1){
                var isChecked = 'checked';
              }else{
                var isChecked = '';
              }

              toAppend.push('<div class="ans ml-2">');
              toAppend.push('<label class="radio"><input type="checkbox" class="q_option" name="q_option[]" value="'+item.id+'" '+isChecked+'><span>'+item.answer_option+'</span></label>');
              toAppend.push('</div>');
          });
              $(".optionDiv").html(toAppend.join(""));
        }
      </script>
      <style type="text/css">
        label.radio {
            cursor: pointer;
          }

          label.radio input {
            position: absolute;
            top: 0; 
            left: 0;
            visibility: hidden;
            pointer-events: none;
          }

          label.radio span {
            padding: 4px 0px;
            border: 1px solid red;
            display: inline-block;
            color: red;
            width: 100px;
            text-align: center;
            border-radius: 3px;
            margin-top: 7px;
            text-transform: uppercase;
          }

          label.radio input:checked + span {
            border-color: red;
            background-color: red;
            color: #fff;
          }

          .ans {
            margin-left: 36px !important;
          }

          .btn:focus {
            outline: 0 !important;
            box-shadow: none !important;
          }

          .btn:active {
            outline: 0 !important;
            box-shadow: none !important;
          }
      </style>
    </x-slot>
</x-app-layout>