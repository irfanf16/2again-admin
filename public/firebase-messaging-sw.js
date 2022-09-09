/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIzaSyCG4ALeviYjIHFSVe2zA9prxSN6-tQPtpE",
    authDomain: "again-d0ab8.firebaseapp.com",
    databaseURL: "https://again-d0ab8-default-rtdb.firebaseio.com",
    projectId: "again-d0ab8",
    storageBucket: "again-d0ab8.appspot.com",
    messagingSenderId: "359225882388",
    appId: "1:359225882388:web:981a9f6c7c8d3f99d87401",
    measurementId: "G-5DC787N21N"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    // Customize notification here
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});
