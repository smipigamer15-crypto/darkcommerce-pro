// resources/js/push.js
export async function initPushNotifications() {
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        console.log('Push notifications not supported');
        return;
    }

    // Реєструємо Service Worker
    const registration = await navigator.serviceWorker.register('/service-worker.js');

    // Запитуємо дозвіл
    const permission = await Notification.requestPermission();
    
    if (permission !== 'granted') return;

    // Підписуємось
    const subscription = await registration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array('BEl62iXVY5tQ3k0RmBqGnYGFRPT1a0NfYKUZ5mz0Jk9_LHjTqZnPxVlbjEqP5nEKpHZ4tFQ5sRRqSUkBBS5PfJ0')
    });

    // Відправляємо підписку на сервер
    await fetch('/push/subscribe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify(subscription.toJSON()),
    });

    console.log('Push notifications enabled!');
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);
    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}