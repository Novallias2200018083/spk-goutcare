<?php
@mkdir('public/pwa');
$sizes = [192, 512];
foreach ($sizes as $size) {
    $img = imagecreatetruecolor($size, $size);
    $bg = imagecolorallocate($img, 30, 41, 59); // Tailwind slate-800
    imagefill($img, 0, 0, $bg);
    $tc = imagecolorallocate($img, 255, 255, 255);
    $fontSize = 5;
    if ($size > 200) $fontSize = 20; // fake bigger font
    // We will just draw a simple rectangle and text
    $fontPath = 5; // Built in font 5
    $text = "GoutCare";
    $tw = imagefontwidth($fontPath) * strlen($text);
    $th = imagefontheight($fontPath);
    imagestring($img, $fontPath, ($size - $tw) / 2, ($size - $th) / 2, $text, $tc);
    imagepng($img, "public/pwa/icon-{$size}x{$size}.png");
    imagedestroy($img);
}
echo "Icons generated.";
