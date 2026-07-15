<?php
$files = glob('resources/views/layouts/*.blade.php');
foreach($files as $file) {
    $content = file_get_contents($file);
    if (!str_contains($content, 'components.pwa-tags')) {
        $content = str_replace('</head>', "    @include('components.pwa-tags')\n</head>", $content);
        file_put_contents($file, $content);
        echo "Updated $file\n";
    }
}
