<?php
	include '../config.php';

	// Check if a series is specified
	if (isset($_GET['movie'])) {
		$series = htmlspecialchars(urldecode(basename($_GET['movie'])), ENT_QUOTES, 'UTF-8');
	} else {
		header('Location: /');
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<title><?php echo str_replace('_', ':', $series); ?></title>
	<link rel="stylesheet" href="/main.css">
	<link rel="stylesheet" href="/index.css">
	<link rel="icon" href="/favicon.png" type="image/png">
</head>
<body>
	<header>
		<?php echo "<h1>" . str_replace('_', ':', $series) . "</h1>"; ?>
	</header>
	<main>
		<div class="movies">
		<?php
			foreach (glob(MOVIES_PATH . "$series/*", GLOB_ONLYDIR) as $season) {
				$season = basename($season);
				echo "<h2>" . str_replace('_', ':', basename($season)) . "</h2>";
				$episodes = glob(MOVIES_PATH . "$series/$season/*", GLOB_ONLYDIR);
				foreach ($episodes as $episode) {
					$episode = basename($episode);
					$episode = basename($episode);
					$URLseries = urlencode(basename($series));
					$URLseason = urlencode(basename($season));
					$URLepisode = urlencode($episode);
					$URLpath = urlencode("$series/$season/$episode");
					$title = str_replace('_', ':', $episode);
					echo "<a href='/player/?movie=$URLseries&season=$URLseason&episode=$URLepisode' class='movie'><img src='/serve.php?movie=$URLpath&file=thumbnail.jpg'><h3>$title</h3></a>";
				}
			}
		?>
		</div>
	</main>
</body>
</html>