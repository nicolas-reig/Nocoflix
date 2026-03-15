# Nocoflix

Self-hosted streaming service for watching owned movies on the go in any browser.

## Demo

At [nocoflix.nocoweb.es](https://nocoflix.nocoweb.es) you can find a live demo with public domain movies.   

<img src="https://nocoweb.es/assets/nocoflix_startpage_screenshot.png" alt="Start Page" width="49%">
<img src="https://nocoweb.es/assets/nocoflix_player_screenshot.png" alt="Player" width="49%">

## Technical overview

This streaming service is a minimalist streaming service built with PHP using the HTTP Live Streming (HLS) protocol.

The project intentionally avoids heavy frameworks and libraries, relying instead on:   
- PHP for backend logic
- HLS (m3u8 playlists + TS video segments) for video streaming
- XML metadata files
- Standard HTML/CSS/JS

## Usage

1. Setup a web server (Apache, Nginx, etc.).
2. Install PHP and configure it with your web server.
3. Edit ´config.php´ to define the path where your media will live.
4. Your media will need to be segmented according to the HLS (HTTP Live Stream) format. See [ffmpeg](https://ffmpeg.org/ffmpeg-formats.html##hls-1) for documentation.
5. Place your Movies in the chosen path

## Media Structure

Place your media in the chosen path with the following file structure:

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
		│   ├── language1
		│   │   ├── languageSubtitle_.m3u8
		│   │   ├── sub1.vtt
		│   │   ├── sub2.vtt
		│   │   ├── sub3.vtt
		│   │   └── ...
		│   ├── language2
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
		│		├── spaSubtitle.m3u8
		│       ├── sub_spa1.vtt
		│       ├── sub_spa2.vtt
		│       ├── sub_spa3.vtt
		│       └── ...
		├── Charade
		│   └── ...
		└── ...

Each movie directory contains:

- `master.m3u8` — HLS master playlist
- `thumbnail.jpg` — movie poster
- `metadata.xml` — movie metadata
- `variant_stream*` — video bitrate variants
- `language*` — subtitle tracks in WebVTT format

## Metadata Format
The metadata should follow the structure described in [metadata.xsd](metadata.xsd).

	
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
				6345   <!-- Duration in seconds -->
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