// Import Firebase scripts
importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging-compat.js');

// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyBRn_tLO0tG-meqbMsq7FhfsVKzOoYTtmE",
  authDomain: "tugas-22b74.firebaseapp.com",
  databaseURL: "https://tugas-22b74-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "tugas-22b74",
  storageBucket: "tugas-22b74.firebasestorage.app",
  messagingSenderId: "1063367029736",
  appId: "1:1063367029736:web:e66adce6ecef7019f42a5d",
  measurementId: "G-HGGKRX7495"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging
const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage((payload) => {
    console.log('Received background message:', payload);

    const notificationTitle = payload.notification.title || 'New Notification';
    const notificationOptions = {
        body: payload.notification.body || 'You have a new notification',
        icon: '/favicon.ico',
        badge: '/favicon.ico',
        tag: 'notification-tag',
        requireInteraction: false,
        data: payload.data
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});

// Handle notification click
self.addEventListener('notificationclick', (event) => {
    console.log('Notification clicked:', event);
    event.notification.close();

    // Navigate to the app when notification is clicked
    event.waitUntil(
        clients.openWindow('/')
    );
});
