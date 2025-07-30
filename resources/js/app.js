import './bootstrap';

if (classroomId) {
    Echo.private('classroom.' + classroomId)
        .listen('.classwork-created', function (event) {
            if (event.body) {
                toastr.success(event.body)
            }
        });
}

Echo.private('App.Models.User.' + userId)
    .notification(function (event) {
        toastr.success(event.body)
    });


