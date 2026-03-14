# Nocoflix

Homemade streaming service for watching owned movies on the go in any browser.

# Technical overview

This streaming service is a minimalist web-page using php for the backend to dynamically serve the html.

# Demo

At [nocoflix.nocoweb.es](https://nocoflix.nocoweb.es) you can find a live demo with public domain movies.   

<img src="https://nocoweb.es/assets/nocoflix_startpage_screenshot" alt="Start Page" width="45%">
<img src="https://nocoweb.es/assets/nocoflix_player_screenshot" alt="Player" width="45%">

# Usage

1. Setup a web server using somethig like apache or ngninx.
2. Install PHP and set it up to work with your web server.
3. Edit the config.php file to define the path where your media will live
4. Your media will need to be segmented according to the HLS (HTTP Live Stream) format. See [ffmpeg](https://ffmpeg.org/ffmpeg-formats.html#hls-1) for documentation.
5. Place your media in the chosen path with the following file structure:

		media
		├── Movie 1
		│   ├── master.m3u8
		│   ├── thumbnail.jpg
		│   ├── metadata.xml
		│   ├── variant_stream1
		│   │   ├── stream.m3u8
		│   │   ├── segment1.ts
		│   │   ├── segment2.ts
		│   │   ├── segment3.ts
		│   │   └── ...
		│   ├── variant_stream2
		│   │   └── ...
		│   ├── ...
		│   ├── subtitle_language1
		│   │   ├── subtitle_language.m3u8
		│   │   ├── sub1.vtt
		│   │   ├── sub2.vtt
		│   │   ├── sub3.vtt
		│   │   └── ...
		│   ├── subtitle_language2
		│   │   └── ...
		│   └── ...
		├── Movie 2
		│   └── ...
		└── ...
	For example:

		media
		├── Night of The Living Dead
		│   ├── master.m3u8
		│   ├── thumbnail.jpg
		│   ├── metadata.xml
		│   ├── v480p
		│   │   ├── stream.m3u8
		│   │   ├── segment1.ts
		│   │   ├── segment2.ts
		│   │   ├── segment3.ts
		│   │   └── ...
		│   ├── v720p
		│   │   └── ...
		│   ├── eng
		│   │   ├── engSubtitle.m3u8
		│   │   ├── sub_eng1.vtt
		│   │   ├── sub_eng2.vtt
		│   │   ├── sub_eng3.vtt
		│   │   └── ...
		│   └── spa
		│       ├── sub_spa1.vtt
		│       ├── sub_spa2.vtt
		│       ├── sub_spa3.vtt
		│       └── ...
		├── Charade
		│   └── ...
		└── ...
6. The metadata should follow the strucute described in [metadata.xsd](metadata.xsd).   
	For example:

		<?xml version="1.0"?>
		<metadata>
			<title>
				All Is Lost
			</title>
			<year>
				2013
			</year>
			<duration>
				6344.921917
			</duration>
			<genre>
				Action, Adventure, Drama
			</genre>
			<description>
				During a solo voyage in the Indian Ocean, a veteran mariner awakes to find his vessel taking on water after a collision with a stray shipping container. With his radio and navigation equipment disabled, he sails unknowingly into a violent storm and…
			</description>
			<cast>
				<actor>Robert Redford</actor>
			</cast>
			<directors>
				<director>J.C. Chandor</director>
			</directors>
			<screenwriters>
				<writer>J.C. Chandor</writer>
			</screenwriters>
			<producers>
				<producer>Anna Gerber</producer>
				<producer>Neal Dodson</producer>
				<producer>Justin Nappi</producer>
				<producer>Teddy Schwarzman</producer>
			</producers>
				<studios>
					<studio>Before the Door Pictures</studio>
					<studio>Washington Square Films</studio>
					<studio>Black Bear Pictures</studio>
					<studio>Treehouse Pictures</studio>
					<studio>Sudden Storm Productions</studio>
					<studio>FilmNation Entertainment</studio>
					<studio>Roadside Attractions</studio>
					<studio>Universal Pictures</studio>
					<studio>Lionsgate</studio>
					<studio>Baja Studios</studio>
					</studios>
		</metadata>