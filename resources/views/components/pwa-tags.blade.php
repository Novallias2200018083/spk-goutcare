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
</script>
