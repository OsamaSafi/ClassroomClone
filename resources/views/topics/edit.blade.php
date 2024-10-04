<x-main-layout title="Edit Topics">
    <div class="container">
        <x-navbar-with-img title="Topics" :classroom-name="$classroom->name" :classroom-id="$classroom->id"
            :classroom-cover-img="$classroom->cover_image_path" />
        <form>
            @csrf

            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="name" value="{{$topic->name}}"
                    placeholder="Enter topic name">
                <label for="name">Topic Name</label>
                <input type="hidden" class="form-control" id="classroom_id" value="{{ $classroom->id }}" placeholder="">
                <input type="hidden" class="form-control" id="user_id" value="{{ Auth::id() }}" placeholder="">
            </div>
            <button type="button" onclick="update('{{$classroom->id}}','{{$topic->id}}')"
                class="btn btn-primary mt-3">Update
                Topic</button>
        </form>
    </div>

    @push('scripts')

    <script>
        function update(classroom,topic){
            axios.put(`/classrooms/${classroom}/topics/${topic}`,{
                name : document.getElementById('name').value,
                classroom_id:document.getElementById('classroom_id').value,
                user_id:document.getElementById('user_id').value,
            })
            .then(function (response) {
                console.log(response.data);
                toastr.success(response.data.message)
            })
            .catch(function (error) {
                console.log(error.response);
                toastr.error(error.response.data.message)
            })
        }
    </script>
    @endpush
</x-main-layout>
