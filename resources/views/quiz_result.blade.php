<x-app-layout>
    <x-slot name="header"></x-slot>
      <h2>Welcome {{ auth()->user()->first_name }},</h2>
      <div class="container mt-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-10 col-lg-10">
                <div class="border">
                    <h3>Quiz Result</h3>
                    <h4>Total Question: {{ $total_ques }}</h4>                
                    <h4>Right: {{ $correct }}</h4>              
                    <h4>Wrong: {{ $total_ques-$correct }}</h4>             
                    <h4>Percent: {{ ($correct/$total_ques)*100 }}%</h4>             
                </div>
            </div>
        </div>
    </div>
    <x-slot name="cssjss">
      <script type="text/javascript">
        
      </script>
      <style type="text/css">
        
      </style>
    </x-slot>
</x-app-layout>