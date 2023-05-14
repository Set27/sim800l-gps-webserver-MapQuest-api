<?php
require 'config.php';

$sql = "SELECT * FROM tbl_gps WHERE 1";
$result = $db->query($sql);
if (!$result) {
    echo "Error: " . $sql . "<br>" . $db->error;
}

$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Author fullname. Трекер мобильного багажа</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
    <style>
     body { font-family: 'Roboto', sans-serif; margin: 0; padding: 0; background-color: #f5f5f5; }

    h1 {
        background-color: #3f51b5;
        color: white;
        padding: 20px;
        margin-bottom: 20px;
    }

    #mapImages img {
        margin-bottom: 10px;
        border-radius: 5px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    #map {
        margin: 20px 0px;
        max-width: 700px;
        min-height: 400px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    .container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
</style>
    <script src="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.js"></script>
    <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.css"/>
</head>
<body >
    <h1>Трекер мобильного багажа</h1>
    <div class = "container" id="mapImages"></div>
    <div id="map"></div>

    <script>
        L.mapquest.key = 'API-KEY';
        
        <?php
        $last_location = end($rows);
        $lat = $last_location['lat'];
        $lng = $last_location['lng'];
        ?>
            
        L.mapquest.map('map', {
          center: [<?php echo $lat; ?>, <?php echo $lng; ?>],
          layers: L.mapquest.tileLayer('map'),
          zoom: 18
        });
        
        
        
        <?php foreach ($rows as $location): ?>
            var lat = <?php echo $location['lat']; ?>;
            var lng = <?php echo $location['lng']; ?>;
            var imgSrc = "https://www.mapquestapi.com/staticmap/v5/map?key=API-KEY&center=" + lat + "," + lng + "&zoom=16&size=700,400@2x&type=map&locations=" + lat + "," + lng + "|marker-3f51b5-sm";
            var img = document.createElement("img");
            img.src = imgSrc;
            img.alt = "Location";
            document.getElementById("mapImages").appendChild(img);
        <?php endforeach; ?>
    </script>
    
</body>
</html>
