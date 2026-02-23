import './bootstrap';

import Alpine from 'alpinejs';
import { initThreeHeroAnimation } from './three-hero-animation'; // Import the 3D animation function
import "@hotwired/turbo"; // Instantly turns the app into a seamless SPA

window.Alpine = Alpine;
Alpine.start();

// --- TURBO SPA HACK FOR INLINE SCRIPTS (LARAVEL VIEWS) ---
// Turbo Drive replaces the <body> but doesn't re-execute `<head>` scripts.
// Many views have inline scripts binding to `DOMContentLoaded` which would normally 
// fail or double-bind when navigating via Turbo.
// This override intercepts those calls and runs them safely exactly once per navigation.
const originalAddEventListener = document.addEventListener;
document.addEventListener = function(type, listener, options) {
    if (type === 'DOMContentLoaded') {
        // If DOM is already parsed (like when Turbo injects the new body)
        if (document.readyState === 'interactive' || document.readyState === 'complete') {
            // Delay execution very slightly to ensure elements are fully in DOM
            setTimeout(listener, 1);
        } else {
            originalAddEventListener.call(document, 'DOMContentLoaded', listener, options);
        }
    } else {
        originalAddEventListener.call(document, type, listener, options);
    }
};

// Initialize the 3D animation on every Turbo load (page visit)
document.addEventListener('turbo:load', () => {
    if (document.getElementById('hero-3d-canvas')) {
        initThreeHeroAnimation('hero-3d-canvas');
    }
});
