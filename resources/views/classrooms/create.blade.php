<x-main-layout title="{{__('Create Classrooms')}}">
    <div class="container">
        {{-- enctype="multipart/form-data" تقوم بتقسيم ال (body) الى اجزاء --}}
        <x-form.all-errors />
        <x-alert name='danger' />
        <div class="massege"></div>
        <div class="card">
            <div class="card-header">
                <h1>{{__('Create Classroom')}}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('classrooms.store') }}" method="post" id="addClassroom"
                    enctype="multipart/form-data">
                    @csrf
                    @include('classrooms._form',[
                    'button' => 'Create',
                    ])
                </form>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#addClassroom').on('submit',function(event){
                event.preventDefualt();

                jQuery.ajax({

                    url: '{{ route('classrooms.store') }}',
                    data : jQuery('#addClassroom').serialize(),
                    type : 'post',

                    success: function(result){
                        $('.message').css('display','block');
                        jQuery('.massege').html(result.message);
                    }
                });
            })
    })
    </script>
</x-main-layout>
