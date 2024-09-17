import './bootstrap';

(function ($) {
    function getMessage(page = 1) {
        $.ajax({
            method: "get",
            url: url.list_message,
            success: function (responce) {
                for (let i in responce.data) {
                    let message = responce.data[i]
                    addMessage(message);
                }
            }
        })
    }

    function addMessage(message, prepend = false) {
        let html;
        if (message.user && message.user.id == user.id) {
            html = `
                        <li class="chat-left">
                            <div class="chat-avatar">
                                <div class="chat-name">${message.user.name}</div>
                            </div>
                            <div class="chat-text">${message.body}</div>
                            <div class="chat-hour">${message.created_at}</div>
                        </li>
                        `
        } else if (message.user && message.user.id !== user.id) {
            html = `
                        <li class="chat-right">
                            <div class="chat-hour">${message.created_at}</div>
                            <div class="chat-text">${message.body}</div>
                            <div class="chat-avatar">
                                <div class="chat-name">${message.user.name}</div>
                            </div>
                        </li>
                        `
        }

        if (prepend) {
            return $('#messages').prepend(html);
        }
        $('#messages').append(html);
    }


    function sendMessage(message) {
        $.post(
            url.store_message,
            {
                _token: csrf_token,
                body: message
            },
            function () {
                addMessage({
                    sender: {
                        name: user.name,
                        id: user.id
                    },
                    body: message,
                    created_at: (Date.now()).toString()
                })
            }
        )
    }


    $('#message-form').on('submit', function (e) {
        e.preventDefault()
        sendMessage($(this).find('textarea').val())
        $(this).find('textarea').val('')
    })

    $(document).ready(function () {
        getMessage();
    })

    Echo.join('chat-classroom-' + classroom)
        .here((users) => {
            for (let i in users) {
                $('ul#users').append(`
                            <li class="person" data-chat="person1">
                                    <div class="user">
                                        <span class="status online"></span>
                                    </div>
                                    <p class="name-time">
                                        <span class="name">${users[i].name}</span>
                                        <span class="time">${new Date()}</span>
                                    </p>
                                </li>
                    `);
            }
        })
        .joining((user) => {
            $('ul#users').append(`
                            <li class="person" data-chat="person1" id="${user.id}">
                                    <div class="user">
                                        <span class="status online"></span>
                                    </div>
                                    <p class="name-time">
                                        <span class="name" id="${user.id}">${user.name}</span>
                                        <br/>
                                        <span class="time">${(new Date()).toDateString}</span>
                                    </p>
                                </li>
                    `);
        })
        .leaving((user) => {
            $(`li#${user.id}`).remove()
        })
        .listen('.new-message', function (event) {
            addMessage(event.message);
        });
})(jQuery)







