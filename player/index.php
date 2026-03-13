<?php
	include '../config.php';
	// Check if a movie is specified
	if (isset($_GET['movie'])) {
		$URLmovie = rawurlencode(basename($_GET['movie']));
		$movie = htmlspecialchars(urldecode(basename($_GET['movie'])), ENT_QUOTES, 'UTF-8');
		$cookieName = 'video_time_' . $URLmovie;
	} else {
		header('Location: /');
		exit();
	}

	if (isset($_COOKIE[$cookieName])) {
		$savedTime = (float)$_COOKIE[$cookieName];
	} else {
		$savedTime = 0;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/main.css">
	<link rel="stylesheet" href="index.css">
	<link rel="icon" href="/favicon.png" type="image/png">
	<?php
		// Include the movie title in the page title
		echo "<title>".str_replace('_',':',htmlspecialchars($movie, ENT_QUOTES, 'UTF-8'))."</title>";
	?>
	<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
</head>
<body>
	<header>
		<?php echo "<h1>".str_replace('_',':',$movie)."
    <a href='download.php?movie=$URLmovie' class='download-btn'>
		<img src='/download.svg' style='height: 2.5rem; transform: translateY(10px); margin-left: 5px;' alt='Download'>
    </a>
</h1>"; ?>
		<nav class="navigation">
			<a href="/">Back</a>
		</nav>
	</header>
	<main>
		<div class="metadata">
		<?php
				$xml = simplexml_load_file(MOVIES_PATH . "$movie/metadata.xml");
				$year = $xml->year;
				$duration = (int)$xml->duration;
				$duration = floor($duration / 3600) . 'h ' . (($duration / 60) % 60) . 'mins';
				$genre = $xml->genre;
				$description = $xml->description;
				$cast = $xml->cast->actor;
				$directors = $xml->directors->director;
				$screenwriters = $xml->screenwriters->writer;
				$producers = $xml->producers->producer;
				$studios = $xml->studios->studio;

				echo "<h2>$genre · $year · $duration</h2>";
				echo "<h3>Description:</h3>";
				echo "<p>$description</p>";
				echo '<div class="people">';
				echo '<div class="cast">';
				echo '<h3>Cast</h3>';
				$counter = 0;
				foreach ($cast as $actor) {
					if ($counter++ >= 5) break;
					echo "<p>$actor</p>";
				}
				echo '</div>';
				echo '<div class="directors">';
				echo '<h3>Directors</h3>';
				foreach ($directors as $director) {
					echo "<p>$director</p>";
				}
				echo '</div>';
				echo '<div class="studio">';
				echo '<h3>Studio</h3>';
				foreach ($studios as $studio) {
					echo "<p>$studio</p>";
				}
				echo '</div>';
				echo '</div>';
			?>
		</div>
		<video id="video" controls poster=<?php echo "'/serve.php?movie=$URLmovie&file=thumbnail.jpg'"?>></video>
			<script>
				const video = document.getElementById('video');
				// Check if HLS.js is supported
				if (Hls.isSupported()) {
					const hls = new Hls();
					hls.loadSource(<?php echo "'/serve.php?movie=$URLmovie&file=master.m3u8'"?>);
					hls.attachMedia(video);
				} else if (video.canPlayType('application/x-mpegURL')) {
					// For Safari and native HLS support
					video.src = <?php echo "'/serve.php?movie=$URLmovie&file=master.m3u8'"?>;
				}

				// Set the video current time from the cookie
				const savedTime = <?php echo $savedTime; ?>;
				console.log('Loaded saved time:', savedTime, 'Type:', typeof savedTime);
				
				video.addEventListener('loadedmetadata', () => {
    			if (savedTime > 0 && savedTime < video.duration) {
        			video.currentTime = savedTime;
    			}

				setInterval(() => {
  				document.cookie = `video_time_<?php echo $URLmovie?>=${video.currentTime}; max-age=31536000; path=/`;
				}, 5000);

				video.addEventListener('pause', () => {
					document.cookie = `video_time_<?php echo $URLmovie?>=${video.currentTime}; max-age=31536000; path=/`;
				});

				video.addEventListener('ended', () => {
					document.cookie = `video_time_<?php echo $URLmovie?>=; max-age=0; path=/`;
				});
				});
			</script>
	</main>
</body>
</html>