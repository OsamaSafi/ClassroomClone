import './bootstrap';

if (classroomId) {
    Echo.private('classroom.' + classroomId)
        .listen('.classwork-created', function (event) {
            Swal.fire({
                title: event.title,
                text: event.body,
                icon: 'success',
                confirmButtonText: 'Oks'
            })
        })
}

Echo.private('App.Models.User.' + userId)
    .notification(function (event) {
        Swal.fire({
            title: event.title,
            text: event.body,
            icon: 'success',
            confirmButtonText: 'Oks'
        })
    });


