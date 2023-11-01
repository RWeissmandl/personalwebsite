<!DOCTYPE html>
<html>

<head>
    <title>cycling</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="cycling.css">
    <meta name="viewport" content="width=device-width, inital-scale=1">
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

<body>
        <header>
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
        
        </header>
        <main>
            <section>
                <h1>Cycling</h1>
                <h2>A single goal. A simple project. A budding engineer.</h2>
                <p>No better way to experience the joys of a project's fruition, when it always reminds of the simple joys of cycling. I am learning to program by displaying my cycling activities. <a href="https://github.com/RWeissmandl/Pulling_Strava_Activities">Here is the code</a>.</p>
            </section>

<!-- Connecting to db with PHP -->
            <?php

$db = parse_url(getenv("DATABASE_URL"));
$db["path"] = ltrim($db["path"], "/");
$db_connection = pg_connect("host=".$db["host"]." port=".$db["port"]." dbname=".$db["path"]." user=".$db["user"]." password=".$db["pass"]);
$result = pg_query($db_connection, "select * from activities where (Sport_type='Ride' and Distance > 44) OR (Sport_type='Run' and Distance > 6) or (Sport_type='Hike' and Distance > 10)");

// while ($row = pg_fetch_array($result)) {
// echo $row[0].$row[1].$row[2].$row[3].$row[4].$row[5].$row[6].$row[7].$row[8];
// echo "<br />\n";
// }  

?>

    <?php
        while($row = pg_fetch_row($result)) {
           echo "<table>";
            echo "<tr><td>$row[0]</td></tr>";
            $activity_title = "$row[0]";
            echo "<tr><td>$row[6]</td></tr>";
            echo "<tr><td>$row[1]miles</td></tr>";
            echo "<tr><td>$row[2]seconds</td></tr>";
            echo "<tr><td>$row[3]meters</td></tr>";
            echo "<tr><td>$row[8]average speed</td></tr>";
            $php_map = "$row[7]";
            $escaped_php_map = str_replace('\\', '\\\\', $php_map);
           // echo "<tr><td><script> document.write($row[7]) </script></td></tr>";
            // echo "<tr><td><script> js_map = $php_map; document.write(js_map) </script></td></tr>";
            // echo "<tr><td>$map_variable</td></tr>"; 
            echo "</table>";
        }
        pg_close($db_connection); #CLOSE CONNECTION 
        ?>    
   

<div id="map"><script>
var polyline = L.Polyline.fromEncoded('<?php echo $escaped_php_map; ?>'); //getting the summary polyline string and converting to lat/long
let coordinates = L.Polyline.fromEncoded('<?php echo $escaped_php_map; ?>').getLatLngs(); //storing above as lat/long
let object_1 = polyline.getLatLngs()[0]; //grabbing fifth lat/long object
//var map = L.map('map').setView(Object.values(object_1), 13); //initialising map using the first lat/long object
let map = L.map('map').fitBounds(coordinates); //initialising map
L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
}).addTo(map); //adding openstreetmap layer
L.polyline(coordinates, {color:"red"}).addTo(map); //adding route to map
// Adding popup with Name of Activity at starting point
L.marker(Object.values(object_1)).addTo(map)
    .bindPopup('<?php echo $activity_title; ?>')
    .openPopup();
</script></div>

</body>

</html>