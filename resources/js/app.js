import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Set up CSRF token for AJAX requests
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.csrfToken = token.content;
} else {
    console.error('CSRF token not found');
}

Alpine.start();
