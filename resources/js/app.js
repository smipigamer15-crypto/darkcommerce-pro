import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.Alpine = Alpine;
Alpine.plugin(focus);
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        once: true,
    });
});

// resources/js/app.js
import { initPushNotifications } from './push';

// В кінці файлу:
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.push-enabled')) {
        initPushNotifications();
    }
});