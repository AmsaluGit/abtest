<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="/setting/update" method="post" id="myForm">
                        @csrf
                        <label class="" for="setting">Enter Deadline in minutes<label>
                            <input type="text" name="setting" id="setting" value="{{ $minutes }}" />
                            <a href="#" class="btn btn-success" id="btn">Reset</a>
                    </form>
 
                </div>
            </div>
        </div>
    </div>

   
 
 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 <script>
        $("#btn").on('click', function(){
           yes = confirm('Reseting would clean the previously collected survey, are you sure you want to continue?');
           if(yes) $("#myForm").submit();
           
          
        })
    
    </script>

</x-app-layout>

