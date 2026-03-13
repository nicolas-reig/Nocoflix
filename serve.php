<?php
include 'config.php';
if (isset($_GET['movie']) && isset($_GET['file'])) {
    $file = htmlspecialchars(urldecode($_GET['file']), ENT_QUOTES, 'UTF-8');
    $movie = htmlspecialchars(urldecode($_GET['movie']), ENT_QUOTES, 'UTF-8');
} else {
    header('Location: /');
    exit();
}

$filePath = MOVIES_PATH . $movie . '/' . $file;

if (!file_exists($filePath) || !is_readable($filePath)) {
    http_response_code(404);
    exit();
}

$extension = pathinfo($filePath, PATHINFO_EXTENSION);
switch ($extension) {
    case 'm3u8':
        $mimeType = 'application/vnd.apple.mpegurl';
        break;
    case 'ts':
        $mimeType = 'video/mp2t';
        break;
    case 'vtt':
        $mimeType = 'text/vtt';
        break;
    default:
        $mimeType = mime_content_type($filePath);
}

header("Content-Type: $mimeType");
header("Cache-Control: no-cache, must-revalidate");

// Process m3u8 files
if ($extension === 'm3u8') {
    $currentDir = dirname($file);
    $movieParam = urlencode($movie);
    $contents = file_get_contents($filePath);
    $lines = explode("\n", $contents);

    foreach ($lines as $line) {
        $line = rtrim($line);
        if (preg_match('/URI="([^"]+)"/i', $line, $matches)) {
            // Replace URIs in tags (ej: #EXT-X-MEDIA)
            $originalUri = $matches[1];
            $fullPath = ($currentDir !== '.') ? "$currentDir/$originalUri" : $originalUri;
            $encodedPath = urlencode($fullPath);
            $newUri = "/serve.php?movie=$movieParam&file=$encodedPath";
            $line = str_replace($originalUri, $newUri, $line);
        } elseif (!preg_match('/^#/', $line) && trim($line) !== '') {
            // Replace segments (ej: segment0.ts o subeng_0.vtt)
            $originalUri = trim($line);
            $fullPath = ($currentDir !== '.') ? "$currentDir/$originalUri" : $originalUri;
            $encodedPath = urlencode($fullPath);
            $newUri = "/serve.php?movie=$movieParam&file=$encodedPath";
            $line = $newUri;
        }
        echo $line . "\n";
    }
} else {
    readfile($filePath);
}
exit;
?>
