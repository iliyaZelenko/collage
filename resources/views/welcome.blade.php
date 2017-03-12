<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    </head>
    <body>
    <style type="text/css">
        #messages{
            border: 1px solid black;
            height: 300px;
            margin-bottom: 8px;
            overflow: scroll;
            padding: 5px;
        }
    </style>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Чат-бокс
            </div>
            <ul id="messages-container" class="list-group list-group-flush">
                {{--<li class="list-group-item">Здравствуйте!</li>--}}
                {{--<li class="list-group-item">Приветсвую!</li>--}}
                {{--<li class="list-group-item">Как разработка нашего проекта?</li>--}}
            </ul>
            <div class="card-block">
                <h4 class="card-title">Отправка сообщения</h4>
                <p class="card-text">Чатик подъехал.</p>

                <form class="form-send-message" action="sendmessage" method="POST">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="form-send-message__user-name-input">User name</label>
                        <input id="form-send-message__user-name-input" value="Ilya Zelenko" class="form-control" placeholder="Enter name" />
                    </div>
                    <div class="form-group">
                        <label for="form-send-message__msg-box-input">Message</label>
                        <textarea id="form-send-message__msg-box-input" class="form-control" placeholder="Enter message"></textarea>
                    </div>

                    <button id="form-send-message__submit" class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>

        </div>
    </div>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}',
            appName: '{{ config('app.name') }}',
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            }
        });



        var socket = io.connect('http://ilya.local.com:3000/');
//        var socket = io();



        $('#form-send-message__submit').click(function(e) {
            var user = $('#form-send-message__user-name-input').val();
            var msg = $('#form-send-message__msg-box-input').val();

            if (msg) {
                socket.emit('message', {
                    message: msg,
                    user: user
                });
                {{--$.ajax({--}}
                    {{--type: 'POST',--}}
                    {{--url: '{!! URL::to('sendmessage') !!}',--}}
                    {{--dataType: 'json',--}}
//                    data: {
//                        _token: window.Laravel.csrfToken,
//                        message: msg,
//                        user: user
//                    },
                    {{--success: function(data) {--}}
                        {{--console.log('Success', data);--}}
                        {{--$('#form-send-message__msg-box-input').val('');--}}
                    {{--}--}}
                {{--});--}}
            } else {
                alert('Please Add Message.');
            }

            return false;
        });

        socket.on('message', function (data) {
//            var data = JSON.parse(dataJson);
            console.log(data.user);
            $('#messages-container').append(`
                <li class="list-group-item">
                    <span>[${data.user}]:</span>
                    <span>${data.message}</span>
                </li>
            `);
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    </body>
</html>
