<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="{{asset('frontend/js/jquery.smartWizard.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{asset('frontend/js/main.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/slick.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/intlTelInput.min.js')}}"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>

<script>
    var firebaseConfig = {
        apiKey: "AIzaSyCG4ALeviYjIHFSVe2zA9prxSN6-tQPtpE",
        authDomain: "again-d0ab8.firebaseapp.com",
        databaseURL: "https://again-d0ab8-default-rtdb.firebaseio.com",
        projectId: "again-d0ab8",
        storageBucket: "again-d0ab8.appspot.com",
        messagingSenderId: "359225882388",
        appId: "1:359225882388:web:981a9f6c7c8d3f99d87401",
        measurementId: "G-5DC787N21N"
    };


    // measurementId: G-R1KQTR3JBN
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    @if(Auth::check())
    @if (request()->route()->getName() !== 'messages')

    messaging.onMessage(function (payload) {
        messageObject = JSON.parse(payload.data.value2);

        if (payload.data.event == 'DM' || payload.data.event == 'NewMessage') {


            const objdata = {

                'attachment': messageObject.attachment,
                'message_id': messageObject.message_id,
                'message_identifier': messageObject.message_identifier,
                'send_from': messageObject.send_from,
                'send_to': messageObject.send_to,

                'text': messageObject.text,
                'time': messageObject.time,
                'type': messageObject.type,
                'status': 1,
            }
            var message = JSON.stringify(objdata);
            socket.emit('message_receipt', {'sender_id': messageObject.send_from, 'message_object': message});
        }


        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,

        };
        new Notification(noteTitle, noteOptions);
    });

    @endif
    @endif
</script>


@include ('web.popups.join_popup')
@include ('web.popups.notify_popup')
