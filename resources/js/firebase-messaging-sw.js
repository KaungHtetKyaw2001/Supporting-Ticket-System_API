// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyDDps47HvppJvZkKznFbdiVaN2GDNbzYY4",
    authDomain: "support-ticket-api-6a6f5.firebaseapp.com",
    projectId: "support-ticket-api-6a6f5",
    storageBucket: "support-ticket-api-6a6f5.appspot.com",
    messagingSenderId: "828324146233",
    appId: "1:828324146233:web:b3caa4035a4f2f5750f1e8",
    measurementId: "G-XQH1NWG173"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});