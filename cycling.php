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
            echo "<tr><td>$row[6]</td></tr>";
            echo "<tr><td>$row[1]miles</td></tr>";
            echo "<tr><td>$row[2]seconds</td></tr>";
            echo "<tr><td>$row[3]meters</td></tr>";
            echo "<tr><td>$row[8]average speed</td></tr>";
            echo "<tr><td>$row[7]</td></tr>";
            echo "</table>";
        }
        ?>    
        
</body>

</html>