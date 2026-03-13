<?php
include 'config.php';
if (!isset($_GET['movie'])) {
    exit('No movie specified');
}

$movie = htmlspecialchars(basename($_GET['movie']), ENT_QUOTES, 'UTF-8');
// Remove quotes and escape the paths properly
$inputFile = escapeshellarg(MOVIES_PATH . "$movie/v480p/stream.m3u8");
$outputFile = escapeshellarg(MOVIES_PATH . "$movie/temp_download.m4v");

$outputFilePath = MOVIES_PATH . "$movie/temp_download.m4v";

// Check if there already is a temp_file file exists
if (!file_exists($outputFilePath)) {
    // Execute ffmpeg command with properly escaped paths
    $command = "ffmpeg -i $inputFile -c copy $outputFile 2>&1";
    exec($command, $output, $returnVar);

    if ($returnVar !== 0) {
        //exit(implode("\n", $output));
        exit('Error processing video');
    }
}


// Send file to browser
header('Content-Type: video/m4v');
header('Content-Disposition: attachment; filename="movie.m4v"');
header('Content-Length: ' . filesize($outputFilePath));
readfile($outputFilePath);

// Delete temporary file
unlink($outputFilePath);
exit();
?>