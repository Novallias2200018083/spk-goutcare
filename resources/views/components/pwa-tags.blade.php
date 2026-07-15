<!-- PWA Meta Tags -->
<meta name="theme-color" content="#1e293b"/>
<link rel="apple-touch-icon" href="{{ asset('pwa/icon-192x192.png') }}">
<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="GoutCare">

<!-- Service Worker Registration -->
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/serviceworker.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }

    // PWA Pull-to-Refresh Logic
    let pwaTouchstartY = 0;
    document.addEventListener('touchstart', e => {
        if (window.scrollY === 0) pwaTouchstartY = e.touches[0].clientY;
    }, {passive: true});
    
    document.addEventListener('touchend', e => {
        if (window.scrollY === 0 && e.changedTouches[0].clientY - pwaTouchstartY > 150) {
            // Check if it's running as PWA (standalone)
            if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
                location.reload();
            }
        }
    }, {passive: true});
</script>
