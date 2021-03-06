<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CM-Transit - route&timetable</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <style>
        .navbar-toggler-icon {
            border: 1px solid;
            border-color: cadetblue;
            width: 2.5em;
            height: 2em;
        }
        #map {
            height: 75%;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #2e3f501a;
        }
        #sidebar-wrapper{
            background-color: white;
        }
        .breadcrumb{
            background-color: white;
        }
        #sidebar-nav.li.a{
            color: #2e3f50;
        }
    </style>

</head>

<body>

<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#" style="background: #2e3f501a;color: #2e3f50; text-align: center; margin-left: -20px;height: 60px;">
                    CM-TRANSIT
                </a>
            </li>
            <li data-toggle="tooltip" data-placement="right" title="Map">
                <a class="nav-link-collapse collapsed" data-toggle="collapse" href="#mapselected" data-parent="#mapselected">
                    <i class="fa fa-fw fa-file"></i>
                    <span class="nav-link-text">Map</span>
                </a>
                <ul class="sidenav-second-level collapse" id="mapselected">
                    <li>
                        <a  href="#" id="stationR1G">R1G-Zoo-Cen</a>
                    </li>
                    <li>
                        <a  href="#" id="stationR1B">R1P-Cen-Zoo</a>
                    </li>
                    <li>
                        <a  href="#" id="stationR3L">R3Y</a>
                    </li>
                    <li>
                        <a href="#" id="stationR3R">R3R</a>
                    </li>
                    <li>
                        <a href="#" id="stationALL">ทุกเส้นทาง</a>
                    </li>
                    <li>
                        <a href="#" id="stationClear">Clear Station</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">Bus Stop</a>
            </li>
            <li>
                <a href="#">Route & Timetable</a>
            </li>
            <li>
                <a href="#">Promotion</a>
            </li>
            <li>
                <a href="#">About Us</a>
            </li>
            <li>
                <a href="#">Contact Us</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-dark" style="height: 60px; background-color: #2e3f50">
            <a href="#menu-toggle" class="btn navbar-toggler-icon" id="menu-toggle">
                <i class="fa fa-bars"></i>
            </a>
            <a class="navbar-brand" href="#">CM-TRANSIT</a>
            <button class="btn btn-secondary" style="background: cadetblue;">TH</button>
        </nav>


        <div class="btn-group">
            <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="btnStaion" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                เลือกสถานี
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a class="dropdown-item" href="#" id="stationR3L">R3 Left</a></li>
                <li><a class="dropdown-item" href="#" id="stationR3R">R3 Right</a></li>
                <li><a class="dropdown-item" href="#" id="stationClear">Clear Station</a></li>
            </ul>
        </div>


        <div class="btn-group">
            <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="btnCar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                เลือกรถ
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a class="dropdown-item" href="#" id="bus">รถบัส</a></li>
                <li><a class="dropdown-item" href="#" id="redcar">รถแดง</a></li>
                <li><a class="dropdown-item" href="#" id="tuktuk">รถตุ๊กตุ๊ก</a></li>
                <li><a class="dropdown-item" href="#" id="allcar">รถทั้งหมด</a></li>
            </ul>
        </div>

        <div class="container-fluid">
            <ol class="breadcrumb" style="margin-top: 1rem;">
                <li class="breadcrumb-item active">Route & Timetable</li>
            </ol>

            <div class="embed-responsive embed-responsive-16by9">
                <div id="map" class="embed-responsive-item" style="overflow: hidden;">
                </div>
            </div>
        </div>

        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>

    <script>
        var map;
        var flightPath;
        var flightPath1;
        var flightPath2;
        var flightPath3;
        var flightPath4;
        var info;
        var line = null;
        var markers = [];
        var carMark = [];
        var sB1 = 'image/icon_station/b1_beenhere.png';
        var sB2 = 'image/icon_station/b2_beenhere.png';
        var changeStation = document.getElementById("btnStaion");
        var changeCar = document.getElementById("btnCar");
        var car = "M17.402,0H5.643C2.526,0,0,3.467,0,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759c3.116,0," +
            "5.644-2.527,5.644-5.644 V6.584C23.044,3.467,20.518,0,17.402,0z M22.057,14.188v11.665l-2.729," +
            "0.351v-4.806L22.057,14.188z M20.625,10.773 c-1.016,3.9-2.219,8.51-2.219,8.51H4.638l-2.222-8.51C2.417," +
            "10.773,11.3,7.755,20.625,10.773z M3.748,21.713v4.492l-2.73-0.349 V14.502L3.748,21.713z M1.018," +
            "37.938V27.579l2.73,0.343v8.196L1.018,37.938z M2.575,40.882l2.218-3.336h13.771l2.219,3.336H2.575z M19.328," +
            "35.805v-7.872l2.729-0.355v10.048L19.328,35.805z";

        function initMap() {
            var location = {
                lat: 18.787635,
                lng: 98.985683
            };
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: location
            });

            $.getJSON("CM_CAR/API", function(jsonBus1) {
                $.each(jsonBus1, function(i, carB1) {

                    if(carB1.Type == "minibus") {
                        var color = "#0d0c55";
                    }
                    if(carB1.Type == "redcar") {
                        var color = "#bb110a";
                    }
                    if(carB1.Type == "tuktuk") {
                        var color = "#055500";
                    }
                    if(carB1.Type == "bus") {
                        if(carB1.Color=="เขียว"){
                            var color = "#055500";
                        }
                        if(carB1.Color=="เหลือง"){
                            var color = '#ffff07';
                        }
                        if(carB1.Color=="แดง"){
                            var color = '#fe0404';
                        }
                        if(carB1.Color=="น้ำเงิน"){
                            var color = "#515aee";
                        }
                    }

                    //var car_detail =carB1.Detail;
                    //var array = car_detail.split(',');
                    //if(array[0]=="R3"){
                    if(carB1.Type == "bus"){
                    var markBusB1 = new google.maps.Marker({
                        position: new google.maps.LatLng(carB1.LaGoogle, carB1.LongGoogle),
                        map: map,
                        title: carB1.Registerid,
                        icon: {
                            path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                            scale: 5,
                            strokeColor: 'white',
                            strokeWeight: .01,
                            fillOpacity: 1,
                            fillColor: color,
                            // offset: '5%',
                            rotation: parseFloat(carB1.Direction)

                            // anchor: new google.maps.Point(10, 25)
                        }
                    });


                    carMark.push(markBusB1);
                    info = new google.maps.InfoWindow();

                    google.maps.event.addListener(markBusB1, 'click', (function(markBusB1, i) {
                        return function() {
                            getInfo(carB1);
                            info.open(map, markBusB1);
                        }
                    })(markBusB1, i));
                    }

                });
            });


            addAll_Path();



        }

        $('#stationR1G').click(function() {

            removeLine();
            clearMarkers();
            markers = [];
            addR1_Go()();
        });
        $('#stationR1B').click(function() {

            removeLine();
            clearMarkers();
            markers = [];
            addR1_Back()();
        });
        $('#stationR3L').click(function() {

            removeLine();
            clearMarkers();
            markers = [];
            addR3_Left();
        });
        $('#stationR3R').click(function() {

            removeLine();
            clearMarkers();
            markers = [];
            addR3_Right();
        });
        $('#stationALL').click(function() {
            removeLine();
            clearMarkers();
            markers = [];
            addAll_Path();
        });
        $('#stationClear').click(function() {
            clearMarkers();
            removeLine();
            markers = [];
        });



        //line color
        var R3L_color = '#ffff07';
        var R3R_color = '#fe0404';
        var R1G_color = '#1ca1ae';
        var R1B_color = '#683db7';

        var BS_R1G = 'image/icon_station/R1G_busstop.png';
        var BS_R1P = 'image/icon_station/R1P_busstop.png';
        var BS_R3L = 'image/icon_station/R3L_busstop.png';
        var BS_R3R = 'image/icon_station/R3R_busstop.png';
        var Red_Green = 'image/icon_station/red-green.png';
        var Purple_Yellow = 'image/icon_station/purple-yellow.png';
        var Red_Purple = 'image/icon_station/red-purple.png';
        var Red_Purple_Yellow = 'image/icon_station/red-purple-yellow.png';

        //strokeWeight
        var strokeWeight = 4.0;

        function addR1_Go() {
            var myTrip=new Array();
            var lat = new Array();
            var long = new Array();
            var check = null;
            var count = 0;
            console.log(line);
            if(line!=null){
                console.log("right");
                line.remove();
            }


            $.getJSON("json_station/cm_stations_r1_g.json", function(jsonCM1) {
                $.each(jsonCM1, function(i, station1) {

                    if(station1.station_id==null) {
                        lat[count] = station1.lat;
                        long[count] = station1.lng;

                    }
                    if(station1.station_id!=null){
                        if(station1.station_name=="Hillside plaza 1 (จุดจอดรถ One Nimman)"||
                            station1.station_name=="วิทยาลัยศรีธนาฯ (ฝั่งตรงข้าม)"||
                            station1.station_name=="Icon aquare 1 (หน้า KFC Icon aquare)"||
                            station1.station_name=="ประตูช้างเผือก 1 (หน้าโชว์รูม ฟอร์ด)"||
                            station1.station_name=="ช้างม่อย (เซ็นทรัลอะไหล่)"||
                            station1.station_name=="ตลาดวโรรส 1 (ธ.กรุงเทพ)"||
                            station1.station_name=="กาดสวนแก้ว 2 (เซเว่น 12 ห้วยแก้ว)"||
                            station1.station_name=="ตลาดต้นลำไย (ตลาดดอกไม้)"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Green
                            });
                        }else {
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: BS_R1G
                            });
                        }


                        markers.push(marker1);
                        info = new google.maps.InfoWindow();
                        google.maps.event.addListener(marker1, 'click', (function(marker1, i) {
                            return function() {
                                info.setContent(station1.station_name);
                                info.open(map, marker1);
                            }
                        })(marker1, i));
                    }


                    if(station1.station_id==null){

                        if(lat[count]!=null){
                            myTrip.push(new google.maps.LatLng(parseFloat(lat[count]),parseFloat(long[count])));
                            count++;

                        }

                    }

                });

                flightPath = new google.maps.Polyline({
                    path: myTrip,
                    strokeColor: R1G_color,
                    strokeOpacity: 1.0,
                    strokeWeight: strokeWeight
                });

                addLine();

            });


        }

        function addR1_Back() {
            var myTrip=new Array();
            var lat = new Array();
            var long = new Array();
            var check = null;
            var count = 0;
            console.log(line);
            if(line!=null){
                console.log("right");
                line.remove();
            }


            $.getJSON("json_station/cm_stations_r1_p.json", function(jsonCM1) {
                $.each(jsonCM1, function(i, station1) {

                    if(station1.station_id==null) {
                        lat[count] = station1.lat;
                        long[count] = station1.lng;
                        // var marker2 = new google.maps.Marker({
                        //     position: new google.maps.LatLng(station1.lat, station1.lng),
                        //     map: map,
                        //     title: station1.station_name,
                        // });
                    }
                    if(station1.station_id!=null){
                        if(station1.station_name=="Hillside plaza 2 (ธนาคาร UOB)"||
                            station1.station_name=="วิทยาลัยศรีธนา 1"||
                            station1.station_name=="กาดสวนแก้ว 1 (จุดจอดรถ)"||
                            station1.station_name=="โรงพยาบาลเชียงใหม่ราม"||
                            station1.station_name=="Icon aquare 2 (วัดราชมณเฑียน)"||
                            station1.station_name=="ประตูช้างเผือก 2 (วัดหม้อคำตวง)"||
                            station1.station_name=="วัดบุพพาราม"||
                            station1.station_name=="ถนนท่าแพ"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Purple_Yellow
                            });
                        }
                        else if(station1.station_name=="ถนนศรีภูมิ"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Purple
                            });
                        }
                        else if(station1.station_name=="ประตูท่าแพ 1 (cool muang coffee)"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Purple_Yellow
                            });
                        }
                        else {
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: BS_R1P
                            });
                        }
                        // var marker2 = new google.maps.Marker({
                        //     position: new google.maps.LatLng(station1.point_lat, station1.point_lng),
                        //     map: map,
                        //     title: station1.station_name,
                        // });

                        markers.push(marker1);
                        info = new google.maps.InfoWindow();
                        google.maps.event.addListener(marker1, 'click', (function(marker1, i) {
                            return function() {
                                info.setContent(station1.station_name);
                                info.open(map, marker1);
                            }
                        })(marker1, i));
                    }


                    if(station1.station_id==null){

                        if(lat[count]!=null){
                            myTrip.push(new google.maps.LatLng(parseFloat(lat[count]),parseFloat(long[count])));
                            count++;

                        }

                    }

                });

                flightPath = new google.maps.Polyline({
                    path: myTrip,
                    strokeColor: R1B_color,
                    strokeOpacity: 1.0,
                    strokeWeight: strokeWeight
                });

                addLine();

            });


        }

        function addR3_Left() {
            var myTrip=new Array();
            var lat = new Array();
            var long = new Array();
            var check = null;
            var count = 0;
            console.log(line);
            if(line!=null){
                console.log("left");
                line.remove();
            }


            $.getJSON("json_station/cm_stations_r3_left.json", function(jsonCM1) {
                $.each(jsonCM1, function(i, station1) {

                    if(station1.station_id==null) {
                        lat[count] = station1.lat;
                        long[count] = station1.lng;

                    }
                    if(station1.station_id!=null){
                        if(station1.station_name=="Hillside plaza 2 (ธนาคาร UOB)"||
                            station1.station_name=="วิทยาลัยศรีธนา 1"||
                            station1.station_name=="กาดสวนแก้ว 1 (จุดจอดรถ)"||
                            station1.station_name=="โรงพยาบาลเชียงใหม่ราม"||
                            station1.station_name=="Icon aquare 2 (วัดราชมณเฑียน)"||
                            station1.station_name=="ประตูช้างเผือก 2 (วัดหม้อคำตวง)"||
                            station1.station_name=="วัดบุพพาราม"||
                            station1.station_name=="ถนนท่าแพ"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Purple_Yellow
                            });
                        }
                        else if(station1.station_name=="ประตูท่าแพ 1 (cool muang coffee)"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Purple_Yellow
                            });
                        }
                        else {
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: BS_R1P
                            });
                        }




                        markers.push(marker1);
                        info = new google.maps.InfoWindow();
                        google.maps.event.addListener(marker1, 'click', (function(marker1, i) {
                            return function() {
                                info.setContent(station1.station_name);
                                info.open(map, marker1);
                            }
                        })(marker1, i));
                    }

                    if(station1.station_id==null){

                        if(lat[count]!=null){
                            myTrip.push(new google.maps.LatLng(parseFloat(lat[count]),parseFloat(long[count])));
                            count++;

                        }

                    }

                });

                flightPath = new google.maps.Polyline({
                    path: myTrip,
                    strokeColor: R3L_color,
                    strokeOpacity: 1.0,
                    strokeWeight: strokeWeight
                });

                addLine();

            });

            // myTrip.push(new google.maps.LatLng(18.77117,98.96846));
            // myTrip.push(new google.maps.LatLng(28.360124,77.031429));

            // console.log(lat.length)


        }




        function addR3_Right() {
            var myTrip=new Array();
            var lat = new Array();
            var long = new Array();
            var check = null;
            var count = 0;
            console.log(line);
            if(line!=null){
            console.log("right");
                line.remove();
            }


            $.getJSON("json_station/cm_stations_r3_right.json", function(jsonCM1) {
                $.each(jsonCM1, function(i, station1) {

                    if(station1.station_id==null) {
                        lat[count] = station1.lat;
                        long[count] = station1.lng;
                        // var marker2 = new google.maps.Marker({
                        //     position: new google.maps.LatLng(station1.lat, station1.lng),
                        //     map: map,
                        //     title: station1.station_name,
                        // });
                    }
                    if(station1.station_id!=null){
                        if(station1.station_name=="Hillside plaza 1 (จุดจอดรถ One Nimman)"||
                            station1.station_name=="วิทยาลัยศรีธนาฯ (ฝั่งตรงข้าม)"||
                            station1.station_name=="Icon aquare 1 (หน้า KFC Icon aquare)"||
                            station1.station_name=="ประตูช้างเผือก 1 (หน้าโชว์รูม ฟอร์ด)"||
                            station1.station_name=="ช้างม่อย (เซ็นทรัลอะไหล่)"||
                            station1.station_name=="ตลาดวโรรส 1 (ธ.กรุงเทพ)"||
                            station1.station_name=="กาดสวนแก้ว 2 (เซเว่น 12 ห้วยแก้ว)"||
                            station1.station_name=="ตลาดต้นลำไย (ตลาดดอกไม้)"){
                        var marker1 = new google.maps.Marker({
                            position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                            map: map,
                            title: station1.station_name,
                            icon: Red_Green
                        });
                        }
                        else if(station1.station_name=="ถนนศรีภูมิ"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Purple
                            });
                        }
                        else if(station1.station_name=="ประตูท่าแพ 1 (cool muang coffee)"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Purple_Yellow
                            });
                        }
                        else {
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon:BS_R3R
                            });
                        }
                        // var marker2 = new google.maps.Marker({
                        //     position: new google.maps.LatLng(station1.point_lat, station1.point_lng),
                        //     map: map,
                        //     title: station1.station_name,
                        // });

                        markers.push(marker1);
                        info = new google.maps.InfoWindow();
                        google.maps.event.addListener(marker1, 'click', (function(marker1, i) {
                            return function() {
                                info.setContent(station1.station_name);
                                info.open(map, marker1);
                            }
                        })(marker1, i));
                    }


                    if(station1.station_id==null){

                        if(lat[count]!=null){
                            myTrip.push(new google.maps.LatLng(parseFloat(lat[count]),parseFloat(long[count])));
                            count++;

                        }

                    }

                });

                flightPath = new google.maps.Polyline({
                    path: myTrip,
                    strokeColor: R3R_color,
                    strokeOpacity: 1.0,
                    strokeWeight: strokeWeight
                });

                addLine();

            });


        }

        function addAll_Path() {
            var myTrip=new Array();
            var lat = new Array();
            var long = new Array();

            var count = 0;



            $.getJSON("json_station/cm_stations_r3_left.json", function(jsonCM1) {
                $.each(jsonCM1, function(i, station1) {

                    if(station1.station_id==null) {
                        lat[count] = station1.lat;
                        long[count] = station1.lng;
                    }
                    if(station1.station_id!=null){
                        if(station1.station_name=="Hillside plaza 2 (ธนาคาร UOB)"||
                            station1.station_name=="วิทยาลัยศรีธนา 1"||
                            station1.station_name=="กาดสวนแก้ว 1 (จุดจอดรถ)"||
                            station1.station_name=="โรงพยาบาลเชียงใหม่ราม"||
                            station1.station_name=="Icon aquare 2 (วัดราชมณเฑียน)"||
                            station1.station_name=="ประตูช้างเผือก 2 (วัดหม้อคำตวง)"||
                            station1.station_name=="วัดบุพพาราม"||
                            station1.station_name=="ถนนท่าแพ"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Purple_Yellow
                            });
                        }
                        else if(station1.station_name=="ประตูท่าแพ 1 (cool muang coffee)"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Purple_Yellow
                            });
                        }
                        else {
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: BS_R1P
                            });
                        }


                        markers.push(marker1);
                        info = new google.maps.InfoWindow();
                        google.maps.event.addListener(marker1, 'click', (function(marker1, i) {
                            return function() {
                                info.setContent(station1.station_name);
                                info.open(map, marker1);
                            }
                        })(marker1, i));
                    }

                    if(station1.station_id==null){

                        if(lat[count]!=null){
                            myTrip.push(new google.maps.LatLng(parseFloat(lat[count]),parseFloat(long[count])));
                            count++;

                        }

                    }

                });

                flightPath1 = new google.maps.Polyline({
                    path: myTrip,
                    strokeColor: R3L_color,
                    strokeOpacity: 1.0,
                    strokeWeight: strokeWeight
                });

                flightPath1.setMap(map);
                myTrip=null;
                myTrip=new Array();

            });

            $.getJSON("json_station/cm_stations_r3_right.json", function(jsonCM1) {
                $.each(jsonCM1, function(i, station1) {

                    if(station1.station_id==null) {
                        lat[count] = station1.lat;
                        long[count] = station1.lng;
                    }
                    if(station1.station_id!=null){
                        if(station1.station_name=="Hillside plaza 1 (จุดจอดรถ One Nimman)"||
                            station1.station_name=="วิทยาลัยศรีธนาฯ (ฝั่งตรงข้าม)"||
                            station1.station_name=="Icon aquare 1 (หน้า KFC Icon aquare)"||
                            station1.station_name=="ประตูช้างเผือก 1 (หน้าโชว์รูม ฟอร์ด)"||
                            station1.station_name=="ช้างม่อย (เซ็นทรัลอะไหล่)"||
                            station1.station_name=="ตลาดวโรรส 1 (ธ.กรุงเทพ)"||
                            station1.station_name=="กาดสวนแก้ว 2 (เซเว่น 12 ห้วยแก้ว)"||
                            station1.station_name=="ตลาดต้นลำไย (ตลาดดอกไม้)"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Green
                            });
                        }
                        else if(station1.station_name=="ถนนศรีภูมิ"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Purple
                            });
                        }
                        else if(station1.station_name=="ประตูท่าแพ 1 (cool muang coffee)"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Purple_Yellow
                            });
                        }
                        else {
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon:BS_R3R
                            });
                        }



                        markers.push(marker1);
                        info = new google.maps.InfoWindow();
                        google.maps.event.addListener(marker1, 'click', (function(marker1, i) {
                            return function() {
                                info.setContent(station1.station_name);
                                info.open(map, marker1);
                            }
                        })(marker1, i));
                    }

                    if(station1.station_id==null){

                        if(lat[count]!=null){
                            myTrip.push(new google.maps.LatLng(parseFloat(lat[count]),parseFloat(long[count])));
                            count++;

                        }

                    }

                });

                flightPath2 = new google.maps.Polyline({
                    path: myTrip,
                    strokeColor: R3R_color,
                    strokeOpacity: 1.0,
                    strokeWeight: strokeWeight
                });

                flightPath2.setMap(map);
                myTrip=null;
                myTrip=new Array();
            });


            $.getJSON("json_station/cm_stations_r1_g.json", function(jsonCM1) {
                $.each(jsonCM1, function(i, station1) {

                    if(station1.station_id==null) {
                        lat[count] = station1.lat;
                        long[count] = station1.lng;
                    }
                    if(station1.station_id!=null){
                        if(station1.station_name=="Hillside plaza 1 (จุดจอดรถ One Nimman)"||
                            station1.station_name=="วิทยาลัยศรีธนาฯ (ฝั่งตรงข้าม)"||
                            station1.station_name=="Icon aquare 1 (หน้า KFC Icon aquare)"||
                            station1.station_name=="ประตูช้างเผือก 1 (หน้าโชว์รูม ฟอร์ด)"||
                            station1.station_name=="ช้างม่อย (เซ็นทรัลอะไหล่)"||
                            station1.station_name=="ตลาดวโรรส 1 (ธ.กรุงเทพ)"||
                            station1.station_name=="กาดสวนแก้ว 2 (เซเว่น 12 ห้วยแก้ว)"||
                            station1.station_name=="ตลาดต้นลำไย (ตลาดดอกไม้)"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Green
                            });
                        }else {
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: BS_R1G
                            });
                        }



                        markers.push(marker1);
                        info = new google.maps.InfoWindow();
                        google.maps.event.addListener(marker1, 'click', (function(marker1, i) {
                            return function() {
                                info.setContent(station1.station_name);
                                info.open(map, marker1);
                            }
                        })(marker1, i));
                    }

                    if(station1.station_id==null){

                        if(lat[count]!=null){
                            myTrip.push(new google.maps.LatLng(parseFloat(lat[count]),parseFloat(long[count])));
                            count++;

                        }

                    }

                });

                flightPath3 = new google.maps.Polyline({
                    path: myTrip,
                    strokeColor: R1G_color,
                    strokeOpacity: 1.0,
                    strokeWeight: strokeWeight
                });

                flightPath3.setMap(map);
                myTrip=null;
                myTrip=new Array();
            });

            $.getJSON("json_station/cm_stations_r1_p.json", function(jsonCM1) {
                $.each(jsonCM1, function(i, station1) {

                    if(station1.station_id==null) {
                        lat[count] = station1.lat;
                        long[count] = station1.lng;
                    }
                    if(station1.station_id!=null){
                        if(station1.station_name=="Hillside plaza 2 (ธนาคาร UOB)"||
                            station1.station_name=="วิทยาลัยศรีธนา 1"||
                            station1.station_name=="กาดสวนแก้ว 1 (จุดจอดรถ)"||
                            station1.station_name=="โรงพยาบาลเชียงใหม่ราม"||
                            station1.station_name=="Icon aquare 2 (วัดราชมณเฑียน)"||
                            station1.station_name=="ประตูช้างเผือก 2 (วัดหม้อคำตวง)"||
                            station1.station_name=="วัดบุพพาราม"||
                            station1.station_name=="ถนนท่าแพ"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Purple_Yellow
                            });
                        }
                        else if(station1.station_name=="ถนนศรีภูมิ"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Purple
                            });
                        }
                        else if(station1.station_name=="ประตูท่าแพ 1 (cool muang coffee)"){
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: Red_Purple_Yellow
                            });
                        }
                        else {
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(station1.station_lat, station1.station_lng),
                                map: map,
                                title: station1.station_name,
                                icon: BS_R1P
                            });
                        }



                        markers.push(marker1);
                        info = new google.maps.InfoWindow();
                        google.maps.event.addListener(marker1, 'click', (function(marker1, i) {
                            return function() {
                                info.setContent(station1.station_name);
                                info.open(map, marker1);
                            }
                        })(marker1, i));
                    }

                    if(station1.station_id==null){

                        if(lat[count]!=null){
                            myTrip.push(new google.maps.LatLng(parseFloat(lat[count]),parseFloat(long[count])));
                            count++;

                        }

                    }

                });

                flightPath4 = new google.maps.Polyline({
                    path: myTrip,
                    strokeColor: R1B_color,
                    strokeOpacity: 1.0,
                    strokeWeight: strokeWeight
                });

                flightPath4.setMap(map);
                myTrip=null;
                myTrip=new Array();
            });


        }

        function addLine() {
            flightPath.setMap(map);
        }

        function removeLine() {
             if(flightPath!=null) {
                flightPath.setMap(null);
             }
            if(flightPath1!=null) {
                flightPath1.setMap(null);
            }
            if(flightPath2!=null) {
                flightPath2.setMap(null);
            }
            if(flightPath3!=null) {
                flightPath3.setMap(null);
            }
            if(flightPath4!=null) {
                flightPath4.setMap(null);
            }
        }

        function getInfo(carB1) {
            if(carB1.StatusLogInOut == 'I'){
                carB1.StatusLogInOut = 'Login';
            }
            else{
                carB1.StatusLogInOut = 'Logout';
            }

            if(carB1.CM_Engine == 1){
                carB1.CM_Engine = 'ปกติ';
            }
            else{
                carB1.CM_Engine = 'ดับเครื่องยนต์';
            }

            if(carB1.CM_Battery == 1){
                carB1.CM_Battery = 'ปกติ';
            }
            else{
                carB1.CM_Battery = 'ไม่ปกติ';
            }

            if(carB1.SignalFall == 0){
                carB1.SignalFall = 'สัญญาณปกติ ข้อมูลถูกต้อง';
            }
            else if(carB1.SignalFall == 1){
                carB1.SignalFall = 'สัญญาณขาดหาย';
            }

            else if(carB1.SignalFall == 2){
                carB1.SignalFall = 'ตำแหน่งคลาดเคลื่อน';
            }
            else if(carB1.SignalFall == 3){
                carB1.SignalFall = 'เฝ้าระวัง';
            }
            else if(carB1.SignalFall == 'F'){
                carB1.SignalFall = 'สัญญาณขาดหายเกิน 12 ชั่วโมง';
            }

            info.setContent('' +
                '<div id="content">' +
                '<h2 style="color: blue">' + carB1.Registerid + '</h2>' +
                '</div> <hr> ' +
                'สาย: '+ carB1.Detail + '<br>'+
                'ข้อมูลล่าสุด:' + carB1.Date +':' + carB1.Time +'<br>' +
                'ข้อมูลผู้ขับ: '+ carB1.DriverName + ' สถานะ: '+ carB1.StatusLogInOut + '<br> <hr>'+
                'เครื่องยนต์: '+ carB1.CM_Engine + '<br>'+
                'แบตเตอร์รี่: '+ carB1.CM_Battery + '<br>'+
                'น้ำมัน: '+ carB1.Fuel + '<br>'+
                'อุณหภูมิ: '+ '' + '<br>'+
                'เซ็นเซอร์ฝุ่นละออง: '+ carB1.SensorPM + '<br> <hr>'+
                'GSM: '+ '' + '<br>'+
                'GPS: '+ '' + '<br>'+
                'สถานะ: '+ carB1.SignalFall + '<br> <hr>'+
                'ตำแหน่ง: '+ '' + '<br>'+
                'พิกัด: ('+ carB1.LaGoogle +','+ carB1.LongGoogle +')<br> <hr>'+ carB1.Type);
        };

        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        function setMapOnCar(map) {
            for (var i = 0; i < carMark.length; i++) {
                carMark[i].setMap(map);
            }
        }


        function clearMarkers() {
            setMapOnAll(null);
        }

        function clearMarkCar() {
            setMapOnCar(null);
        }

        var Interval;
        var IntervalBegin = setInterval(function () {
            getCarlocation();
        }, 10000);

        function getCar(type) {
            clearInterval(IntervalBegin);
            clearMarkCar();
            if(Interval == null) {
                getCarlocation(type);
                clearInterval(Interval);
                Interval = setInterval(function () {
                    getCarlocation(type);
                }, 5000);
            }
            else{
                clearInterval(Interval);
                getCarlocation(type);
                Interval = setInterval(function () {
                    getCarlocation(type);
                }, 5000);
            }

        }

        function getCarlocation(type) {
            $.getJSON("CM_CAR/API", function(jsonBus1) {
                clearMarkCar();
                carMark = [];
                $.each(jsonBus1, function(i, carB1) {
                    if(carB1.Type == "minibus") {
                        var color = "#0d0c55";
                    }
                    if(carB1.Type == "redcar") {
                        var color = "#bb110a";
                    }
                    if(carB1.Type == "tuktuk") {
                        var color = "#055500";
                    }
                    if(carB1.Type == "bus") {

                        if(carB1.Color=="เขียว"){
                            var color = "#055500";
                        }
                        if(carB1.Color=="เหลือง"){
                            var color = '#ffff07';
                        }
                        if(carB1.Color=="แดง"){
                            var color = '#fe0404';
                        }
                        if(carB1.Color=="น้ำเงิน"){
                            var color = "#515aee";
                        }
                    }

                    if(carB1.Type == type) {
                        var markBusB1 = new google.maps.Marker({
                            position: new google.maps.LatLng(carB1.LaGoogle, carB1.LongGoogle),
                            map: map,
                            title: carB1.Registerid,
                            icon: {
                                path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                                scale: 5,
                                strokeColor: 'white',
                                strokeWeight: .01,
                                fillOpacity: 1,
                                fillColor: color,
                                // offset: '5%',
                                rotation: parseFloat(carB1.Direction)
                            }
                        });
                        carMark.push(markBusB1);
                        info = new google.maps.InfoWindow();
                        google.maps.event.addListener(markBusB1, 'click', (function (markBusB1, i) {
                            return function () {
                                getInfo(carB1);
                                info.open(map, markBusB1);
                            }
                        })(markBusB1, i));
                    }

                    if(type == null) {
                        if(carB1.Type == "minibus") {
                            var color = "#0d0c55";
                        }
                        if(carB1.Type == "redcar") {
                            var color = "#bb110a";
                        }
                        if(carB1.Type == "tuktuk") {
                            var color = "#055500";
                        }
                        if(carB1.Type == "bus") {

                            if(carB1.Color=="เขียว"){
                                var color = "#055500";
                            }
                            if(carB1.Color=="เหลือง"){
                                var color = '#ffff07';
                            }
                            if(carB1.Color=="แดง"){
                                var color = '#fe0404';
                            }
                            if(carB1.Color=="น้ำเงิน"){
                                var color = "#515aee";
                            }
                        }

                        //demo RTC3
                        var car_detail =carB1.Detail;
                        // var array = car_detail.split(',');
                        //if(array[0]=="R3") {
                        if(carB1.Type=="bus"||carB1.Type=="") {
                            var markBusB1 = new google.maps.Marker({
                                position: new google.maps.LatLng(carB1.LaGoogle, carB1.LongGoogle),
                                map: map,
                                title: carB1.Registerid,
                                icon: {
                                    path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                                    scale: 5,
                                    strokeColor: 'white',
                                    strokeWeight: .01,
                                    fillOpacity: 1,
                                    fillColor: color,
                                    // offset: '5%',
                                    rotation: parseFloat(carB1.Direction)
                                }
                            });

                            carMark.push(markBusB1);
                            info = new google.maps.InfoWindow();
                            google.maps.event.addListener(markBusB1, 'click', (function (markBusB1, i) {
                                return function () {
                                    getInfo(carB1);
                                    info.open(map, markBusB1);
                                }
                            })(markBusB1, i));
                        }
                    }
                });
            });
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCeIm4Qr_eDTBDnE55Q1DJbZ4qXZLYjss&callback=initMap"
            async defer>
    </script>

</body>
</html>