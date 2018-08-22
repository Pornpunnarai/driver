<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <style type="text/css">
        html{
            padding:0px;
            margin:0px;
        }
        div#map_canvas{
            margin:auto;
            width:100%;
            height:700px;
            overflow:hidden;
        }
    </style>

</head>

<body>

<div id="map_canvas">
</div>

<?php
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "route";
$char_set = "charset=utf8";

// Create connection
$con = mysqli_connect($serverName,$username,$password,$dbName);

$sql = "SELECT max(route_id) AS route_id FROM `route_cm`";
$objQuery = mysqli_query($con,$sql);
$result = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);
$route_id = $result["route_id"];


$sql2 = "SELECT * FROM `route_cm` where `route_id` = '".$route_id."'";
$objQuery2 = mysqli_query($con,$sql2);
$result2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC);
$lat = $result2["latitude"];
$lon = $result2["longitude"];


echo $lat.$lon;
?>


<script src="//maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyCCeIm4Qr_eDTBDnE55Q1DJbZ4qXZLYjss" type="text/javascript"></script>
<script type="text/javascript">
    function initialize() {
        if (GBrowserIsCompatible()) {
            var map = new GMap2(document.getElementById("map_canvas"));
            var lat = '<?php echo $lat ;?>';
            var lon = '<?php echo $lon ;?>';
            var center = new GLatLng(lat,lon); // การกำหนดจุดเริ่มต้น
            map.setCenter(center, 19);  // เลข 13 คือค่า zoom  สามารถปรับตามต้องการ
            map.setUIToDefault();

            var marker = new GMarker(center, {draggable: true});
            map.addOverlay(marker);

            GEvent.addListener(marker, "dragend", function() {
                var point = marker.getPoint();
                map.panTo(point);

                $("#lat_value").val(point.lat());
                $("#lon_value").val(point.lng());
                $("#zoom_value").val(map.getZoom());

            });

        }
    }
</script>
<script type="text/javascript" src="vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
        initialize();
        $(document.body).unload(function(){
            GUnload();
        });
    });
</script>
<div id="showDD" style="margin:auto;padding-top:5px;width:600px;">
    <form action="form_get_detailMap.php" method="post" enctype="multipart/form-data" name="form1">
        Latitude
        <input name="lat_value" type="text" id="lat_value" value="0" />
        Longitude
        <input name="lon_value" type="text" id="lon_value" value="0" />
        Zoom
        <input name="zoom_value" type="text" id="zoom_value" value="0" size="5" />
        <input type="submit" name="button" id="button" value="บันทึก" />
    </form>
</div>
</body>
</html>