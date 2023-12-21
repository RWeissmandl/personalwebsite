<!DOCTYPE html>
<html>

<head>
    <title>cycling</title>
    <!-- <link rel="stylesheet" href="reset.css"> -->
    <link rel="stylesheet" href="cycling.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <!-- including leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
     <script src="res/Polyline.encoded.js"></script>
</head>

<!-- including template header and styling -->
<?php require_once('header.php'); ?>

<body>
        <!-- <header>
            <nav>
                <ul class="webpages">
                    <li> 
                        <a href="index.html" class="website_pages">
                            <img src="res/homeicon.jpg" alt="home icon">
                        </a> 
                    </li>
                    <li> 
                        <a href="#" class="website_pages">Tech</a> 
                    </li>
                   <li>
                        <a href="#" class="website_pages">Research</a>
                   </li>
                   <li>
                        <a href="#" class="website_pages">Education</a>
                   </li>
                   <li>
                        <a href="cycling.html" class="website_pages">Cycling</a>
                    </li>
                    <li>
                        <a href="#" class="website_pages">Coffee</a>
                   </li>
                </ul> 
                </nav>
        
        </header> -->
    <div class='content'>
        <main>
            <section>
                <h1>Cycling</h1>
                <p class='intro'>
                    This project combines my love for cycling and my desire to teach myself to code. 
                    My goal was simply to pull any strava activity over 45miles onto a personal website. 
                    I picked Python as the first program to learn. Along the way, I learnt about API’s 
                    (Strava doesn’t make it too simple!), databases and SQL (I’m storing authentication tokens and strava data in postgreSQL in Heroku),
                    HTML, CSS, JavaScript, PHP, domains and general awesome skills. I committed my code to Github
                    <a href="https://github.com/RWeissmandl/Pulling_Strava_Activities">here</a>. 
                    Below lies the completion of the project, a culmination of coding and cycling efforts. 
                    I may be the only person to scroll down to see, but I figured that if 
                    I want at least someone to scroll….I should pick something where I’d be the one. 
                    <a href="#readmore">Read more</a>
                    <div id='readmore' class='intro'> Moving to Cambridge seemed a great time to begin cycling – a cycling-friendly city, flat roads, a useful way to commute. 
                    I was keen to improve fitness, this seemed a perfect way to do it. 
                    My first bike was an old mountain bike, it was so heavy, I couldn’t cycle on it. 
                    I quickly exchanged that for a hybrid, before realising that I’m a roadie at heart. 
                    I still have my hybrid, onto my second road bike and planning to build my next myself. 
                    I was lucky to be a member of CUCC (Cambridge University Cycling Club) once I got quick enough to join their easy rides.
                </div></p>
            </section>

<script> function loadMap(encodedMapString, activityTitle, varName) {
    let polyline = L.Polyline.fromEncoded(encodedMapString); //getting the summary polyline string and converting to lat/long
    let coordinates = L.Polyline.fromEncoded(encodedMapString).getLatLngs(); //storing above as lat/long
    let object_1 = polyline.getLatLngs()[0]; //grabbing fifth lat/long object
    //let map = L.map('map').fitBounds(coordinates); //initialising map
    let map = L.map(varName).fitBounds(coordinates); //initialising map
    L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
    }).addTo(map); //adding openstreetmap layer
    L.polyline(coordinates, {color:"red"}).addTo(map); //adding route to map
    // Adding popup with Name of Activity at starting point
    L.marker(Object.values(object_1)).addTo(map)
    .bindPopup(activityTitle)
    .openPopup();
}
</script>

<!-- Connecting to db with PHP -->
<?php

$db = parse_url(getenv("DATABASE_URL"));
$db["path"] = ltrim($db["path"], "/");
$db_connection = pg_connect("host=".$db["host"]." port=".$db["port"]." dbname=".$db["path"]." user=".$db["user"]." password=".$db["pass"]);
$result = pg_query($db_connection, "select * from activities where (Sport_type='Ride' and Distance > 46) OR (Sport_type='Run' and Distance > 6) or (Sport_type='Hike' and Distance > 14)");

$x=0;

while($row = pg_fetch_row($result)) {
    $activity_title = "$row[0]";
    $distance = "$row[1]";
    $moving_time = "$row[2]";
    $date = "$row[6]";
    echo "<div id='activity'>
    <div id='activityTitle'> $activity_title</div>
    <div class=metrics>
    <div class=dddt><img src='res/distanceicon.svg' alt='distance icon'> $row[1]mi<div class=hover>Distance</div></div>
    <div class=dddt><img src='res/movingtimeicon.svg' alt='distance icon'> $row[2]<div class=hover>Moving Time</div></div>
    <div class=dddt><img src='res/elevationicon.svg' alt='distance icon'> $row[3]ft<div class=hover>Elevation</div></div>
    <div class=dddt><img src='res/speedicon.svg' alt='distance icon'>$row[8]mph<div class=hover>Average Speed</div></div>
    </div>";
    $php_map = "$row[7]";
    $escaped_php_map = str_replace('\\', '\\\\', $php_map);
    echo "<div class='map' id=\"map$x\"></div>
    <script>loadMap(\"$escaped_php_map\", \"$activity_title\", \"map$x\")</script>";
    $x++;
    echo "<div id='date'> $date</div>";
    echo "</div>
    </br></br>";
}
pg_close($db_connection); #CLOSE CONNECTION 
?>    

</div>
</body>

</html>