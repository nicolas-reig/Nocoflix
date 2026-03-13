<?php
	include 'config.php';
	session_set_cookie_params([
		'lifetime' => 864000, // 10 days
		'path' => '/',
		'domain' => 'nocoflix.nocoweb.es',
		'secure' => true,
		'httponly' => true,
	]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<title>Movies</title>
	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="index.css">
	<link rel="icon" href="/favicon.png" type="image/png">
</head>
<body>
	<header>
		<h1>Nocoflix</h1>
	</header>
	<main>
			<input type="text" id="search" placeholder="Search for a movie...">
			<script>
				document.getElementById('search').addEventListener('input', function() {
					var searchText = document.getElementById('search').value.toLowerCase();
					document.querySelectorAll('.movies a').forEach(function(movie){
						var words = movie.querySelector('h3').textContent.toLowerCase().split(/\s+/);
						var match = words.some(function(word) {
							return word.startsWith(searchText);
						});
						if (!match && searchText !== "") {
							movie.style.display = 'none';
						} else {
							movie.style.display = '';
						}
					});
				});
			</script>
			<div class="movies">
			<?php
				$Legendary = LEGENDARY_MOVIES;
				$movies = glob(MOVIES_PATH . '*', GLOB_ONLYDIR);
				foreach ($movies as $movie) {
					$movie = basename($movie);
					$URLmovie = urlencode($movie);
					$title = str_replace('_', ':', $movie);
					$class = in_array($movie, $Legendary) ? 'legendary' : 'movie';
					if (!file_exists(MOVIES_PATH . "$movie/master.m3u8")){
						echo "<a href='/comingSoonSeries.html' class='$class'><img src='/serve.php?movie=$URLmovie&file=thumbnail.jpg'><h3>$title</h3></a>";
					} else {
						echo "<a href='player/?movie=$URLmovie' class='$class'><img src='/serve.php?movie=$URLmovie&file=thumbnail.jpg'><h3>$title</h3></a>";
					}
					
				}
			?>

			</div>
	</main>
	<!-- Randomize shine animation delay for legendary movies -->
	<script>
	    document.querySelectorAll('.legendary').forEach(el => {
	        const randomDelay = Math.random() * -4; // Random delay between -4s and 0s
	        el.style.setProperty('--shine-delay', randomDelay + 's');
	    });
	</script>
</body>
</html>
