"use strict";

// Wrap in IIFE to prevent duplicate declaration errors during hot reload
(() => {
    const CACHE_NAME = "offline-cache-v1";
    const OFFLINE_URL = '/offline.html';

    const filesToCache = [
        OFFLINE_URL
    ];

    self.addEventListener("install", (event) => {
        event.waitUntil(
            caches.open(CACHE_NAME)
                .then((cache) => cache.addAll(filesToCache))
        );
        // Force waiting service worker to become active
        self.skipWaiting();
    });

    self.addEventListener("fetch", (event) => {
        if (event.request.mode === 'navigate') {
            event.respondWith(
                fetch(event.request)
                    .catch(() => {
                        return caches.match(OFFLINE_URL);
                    })
            );
        } else {
            event.respondWith(
                caches.match(event.request)
                    .then((response) => {
                        return response || fetch(event.request);
                    })
            );
        }
    });

    self.addEventListener('activate', (event) => {
        event.waitUntil(
            caches.keys().then((cacheNames) => {
                return Promise.all(
                    cacheNames.map((cacheName) => {
                        if (cacheName !== CACHE_NAME) {
                            return caches.delete(cacheName);
                        }
                    })
                );
            }).then(() => {
                // Claim all clients immediately
                return self.clients.claim();
            })
        );
    });
})();
