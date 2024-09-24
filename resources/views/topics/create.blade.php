<x-main-layout title="{{__('Create Topics')}}">
    <div class="container">
        <x-navbar-with-img title="Topics" :classroom-name="$classroom->name" :classroom-id="$classroom->id"
            :classroom-cover-img="$classroom->cover_image_path" />
        <x-alert name='success' />
        @can('topic.manage', $classroom)
        <form id="form-create">
            @csrf
            <input type="hidden" class="form-control" id="classroom_id" value="{{ $classroom->id }}" placeholder="">
            <input type="hidden" class="form-control" id="user_id" value="{{ Auth::id() }}" placeholder="">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" placeholder="Enter Topic Name">
                <label for="name">Topic Name</label>
            </div>
            <x-form.error name='name' />
            <button type="button" onclick="store('{{$classroom->id}}')"
                class="btn btn-primary mb-3">{{__('Create Topic')}}</button>
        </form>
        @endcan

    </div>

    @push('scripts')
    <script>
        function store(classroom){
            axios.post(`/classrooms/${classroom}/topics`,{
                name : document.getElementById('name').value,
                classroom_id:document.getElementById('classroom_id').value,
                user_id:document.getElementById('user_id').value,
            })
            .then(function (response) {
            console.log(response.data);
            document.getElementById('form-create').reset();
            showToastify(response.data)
            })
            .catch(function (error) {
            console.log(error.response);
            showToastify(error.response.data)
            })
        }

        function showToastify(data){
            Toastify({
                text: data.message,
                className: 'info',
                style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
                }
                }).showToast();
        }



    </script>
    @endpush
</x-main-layout>
