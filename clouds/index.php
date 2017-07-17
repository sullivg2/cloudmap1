<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Data About Clouds</title>

        <!-- Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">-->
        <style>
            html,body{
                height: 100%;
                width: 100%;
            }
            #nav_id{
                height: 200px;
                width: 100%;
                background-color: #094A60;
            }
            #nav_id1{
                height: 60%;
                width: 100%;
            }
            #nav_id2{
                height: 40%;
                width: 100%;
            }
            #body_id{
                height: 75%;
                width: 100%;
                background-color: #318ba2;
            }
            #left_panel,#right_panel{
                height: 100%;
                color: white;
                padding: 20px;
            }
            .lab_yel{
                color: #ffc857;
            }
            #map {
                height: 60%;
                padding: 0;
                z-index: 1;
            }
            #map_model{
                position: absolute;
                top: 50px;
                right: 150px;
                z-index: 2;
                width: 350px;
                height: 300px;
                background-color: white;
                opacity: 0.8;
                color: black;
                text-align: center;
            }
            #labelC{
                height: inherit;
                width: inherit;
                overflow: scroll;
            }
            #list{
                height: 40%;
                overflow-y: scroll;
                background-color: white;
                color: black;
                padding: 0;
            }
        </style>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <?php
        $host = "localhost";
        $username = "root";
        $password = "admin";
        $database = "clouds";

        $con = mysqli_connect($host, $username, $password, $database);
        //Check connection
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        ?>
    </head>
    <body>
        <div id="nav_id">
            <nav class="navbar" style="background-color: #094A60; height: 148px;  border-radius: 0px; margin-bottom: 0px;">
                <div class="container-fluid">

                    <div class="navbar-header">
                        <div class="col-sm-12" style="color: white; margin-top: 25px; font: bold; font-family: sans-serif;">
                            <h1>marcolopolo</h1><h4> &nbsp; Data about Clouds</h4>
                        </div>
                    </div>

                    <div class="collapse navbar-collapse navbar-right">
                        <ul class="nav navbar-nav" style="color: white; text-decoration: none;">
                            <li class="active"><a href="#"  style="color: white; text-decoration: none;"> &nbsp; <h2>Cloud Map</h2> &nbsp; </a></li>
                            <li><a href="#"  style="color: white; text-decoration: none;"> &nbsp; <h2>Feature2</h2> &nbsp; </a></li>
                            <li><a href="#"  style="color: white; text-decoration: none;"> &nbsp; <h2>Feature2</h2> &nbsp; </a></li>
                            <li><a href="#" style="color: white; text-decoration: none;"> &nbsp; <h2>Blog</h2> &nbsp; </a></li>
                            <li><a href="#" style="color: white; text-decoration: none;"> &nbsp; <h2><span class="glyphicon glyphicon-user" aria-hidden="true"></span></h2> &nbsp; </a></li>
                        </ul>
                    </div>
                </div> 
            </nav>
            <nav class="navbar" style="background-color: #177E89; height: 52px; border-radius: 0px; margin-bottom: 0px;">
                <div class="container-fluid">
                    <div class="col-lg-12" style="padding-top: 7px;">
                        <div class="col-sm-5 pull-right">
                            <div class="input-group">
                                <input id="address" type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" disabled="disabled"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                </span>
                            </div> 
                        </div>  
                    </div> 
                </div> 
            </nav>
        </div>
        <div id="body_id">
            <div id="left_panel" class="col-sm-3">
                <div class="form-group">
                    <select id="loc_select" onchange="updateMap(1)" autocomplete="autocomplete" style="color: black; font-size: 18px; height: 34px;">
                        <option value="-1" selected="selected">All Locations</option>
                        <option value="-2" disabled="disabled"> -- -- </option>
                        <option value="-2" disabled="disabled"> -- -- </option>

                        <?php
                        $sql = "SELECT Location AS loc FROM `cloud` GROUP BY Location";
                        $result = mysqli_query($con, $sql);
                        if ($result) {
                            while ($row = mysqli_fetch_array($result)) {
                                $loc = utf8_encode($row["loc"]);
                                echo '<option>' . $loc . ' </option>';
                            }
                        }
                        mysqli_close($con);
                        ?>
                    </select>
                </div>
                <div class="checkbox" style="margin: 0;">
                    <h3 style="margin: 0; margin-bottom: 2px;"> Required Features </h3>
                </div>
                <div class="checkbox" style="margin: 0;">
                    <label> <input type="checkbox" id="cmpt" onchange="updateMap(2)"> Compute </label>
                </div>
                <div class="checkbox" style="margin: 0;">
                    <label> <input type="checkbox"  id="ostrg" onchange="updateMap(3)"> Object Storage </label>
                </div>
                <div class="checkbox" style="margin: 0;">
                    <label> <input type="checkbox"  id="bstrg" onchange="updateMap(4)"> Block Storage </label>
                </div>
                <div class="checkbox" style="margin: 0;">
                    <label> <input type="checkbox"  id="cdn" onchange="updateMap(5)"> CDN </label>
                </div>
                <div class="checkbox" style="margin: 0;">
                    <label> <input type="checkbox"  id="atosclng" onchange="updateMap(6)"> Autoscalling </label>
                </div>
                <div class="checkbox" style="margin: 0;">
                    <label> <input type="checkbox"  id="srvrls" onchange="updateMap(7)"> Serverless </label>
                </div>
                <div class="form-group">
                    <h3 style="margin-bottom: 2px;">Avg. Customer Review</h3>
                    <h3 style="margin: 0;"><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span></h3>
                    <h3 style="margin: 0;"><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span></h3>
                    <h3 style="margin: 0;"><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span></h3>
                    <h3 style="margin: 0;"><span class="glyphicon glyphicon-star lab_yel"></span></h3>
                </div>
            </div>
            <div id="right_panel" class="col-sm-9">
                <div id="map" class="col-sm-12"></div>
                <div id="map_model">
                    <div id="labelC" class="container-fluid">
                        <h3>Microsoft Azure</h3>
                        <h3 style="margin: 0;"><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star"></span></h3>
                        <div class="col-sm-12" style="text-align: left;"><h4><b>Region:</b> US-East-1</h4></div>
                        <div class="col-sm-6" style="text-align: left;">Features:</div><div class="col-sm-6" style="text-align: left;">Features:</div>

                    </div>
                </div>
                <div id="list" class="col-sm-12">
                    <table id="showdataT" class="table table-striped">
                        <header><h3>Search Results</h3></header> 
                        <thead> <tr> <th>Provider</th> <th>Region</th> <th>Location</th> <th>Ratting</th></tr> </thead> 
                        <tbody id="showdataC"> 
                            <tr id="1"> 
                                <th scope="row">Microsoft Azure</th> 
                                <td>N. Virginia</td> <td>us-east-1</td> 
                                <td><h3 style="margin: 0;"><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star"></span></h3></td> 
                            </tr>
                            <tr>
                                <th scope="row">Amazon Web Services</th>
                                <td>N. Virginia</td> <td>us-east-1</td>
                                <td><h3 style="margin: 0;"><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star"></span></h3></td> 
                            </tr>
                            <tr> <th scope="row">Rackspace</th> 
                                <td>N. Virginia</td> <td>Virginia</td> 
                                <td><h3 style="margin: 0;"><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span></h3></td>  
                            </tr> 
                        </tbody>
                    </table>
                </div>
                <script>
                    var map;
                    var markers = [];
                    var infowindow = [];
                    function initMap() {
                        var myLatLng = {lat: 58.230016, lng: -109.933763};

                        map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 2,
                            center: myLatLng
                        });

                        // Create the search box and link it to the UI element.
                        var input = document.getElementById('address');
                        var searchBox = new google.maps.places.SearchBox(input);

                        searchBox.addListener('places_changed', function () {
                            var places = searchBox.getPlaces();
                            if (places.length == 0) {
                                return;
                            }
                            // For each place, get the icon, name and location.
                            var bounds = new google.maps.LatLngBounds();
                            places.forEach(function (place) {
                                if (!place.geometry) {
                                    console.log("Returned place contains no geometry");
                                    return;
                                }

                                var icon = {
                                    url: place.icon,
                                    size: new google.maps.Size(71, 71),
                                    origin: new google.maps.Point(0, 0),
                                    anchor: new google.maps.Point(17, 34),
                                    scaledSize: new google.maps.Size(25, 25)
                                };

                                // Create a marker for each place.
                                markers.push(new google.maps.Marker({
                                    map: map,
                                    icon: icon,
                                    title: place.name,
                                    position: place.geometry.location
                                }));
                                if (place.geometry.viewport) {
                                    // Only geocodes have viewport.
                                    bounds.union(place.geometry.viewport);
                                } else {
                                    bounds.extend(place.geometry.location);
                                }
                            });
                            map.fitBounds(bounds);
                        });

//                        var geocoder = new google.maps.Geocoder();
//
//                        document.getElementById('address').addEventListener('click', function () {
//                            geocodeAddress(geocoder, map);
//                        });

//                        var myLatLngC = {lat: 58.230016, lng: -109.933763};
//                        var marker = new google.maps.Marker({
//                            position: myLatLngC,
//                            map: map,
//                            title: 'Hello World!'
//                        });
                    }
                    $(document).ready(function () {
                        $("#map_model").hide();
                        $.ajax({
                            url: "getData.php"
                        })
                                .done(function (data) {
                                    showData(data);
                                });
                    });

                    function updateMap(no) {
                        var slct = $("#loc_select").val();
                        var cmpt = document.getElementById("cmpt").checked;
                        var ostrg = document.getElementById("ostrg").checked;
                        var bstrg = document.getElementById("bstrg").checked;
                        var cdn = document.getElementById("cdn").checked;
                        var atosclng = document.getElementById("atosclng").checked;
                        var srvrls = document.getElementById("srvrls").checked;

                        var str = "getData.php?SearchUp=1&loc=" + slct + "&cmpt=" + cmpt + "&os=" + ostrg + "&bs=" + bstrg + "&cdn=" + cdn + "&as=" + atosclng + "&sl=" + srvrls;

                        $.ajax({
                            url: str
                        })
                                .done(function (data) {
                                    console.log(str);
                                    showData(data);
                                });

                    }

                    function showData(data) {
                        clearMap();
                        var resp = data;
                        try {
                            var resp = JSON.parse(data);
                        } catch (e) {
                            console.log(e);
                        }
                        var bounds = new google.maps.LatLngBounds();

                        var str = "";
                        $.each(resp["data"], function (key, val) {
                            var myMark = new google.maps.LatLng(val.lat, val.lon);
                            bounds.extend(myMark);
                            markers[val.id] = new google.maps.Marker({
                                position: myMark,
                                map: map,
                                title: val.com
                            });
                            var contentString = '<div id="content"><div id="siteNotice"></div>' +
                                    '<h3 id="firstHeading" class="firstHeading" style="color: black;">' + val.com + '</h3>' +
                                    '<div id="bodyContent"></div></div>';
                            infowindow[val.id] = new google.maps.InfoWindow({
                                content: contentString
                            });
                            markers[val.id].addListener('click', function () {
                                infowindow[val.id].open(map, markers[val.id]);
                                loadcomp(val.id);
                            });

                            /////////////////////
                            str += '<tr id="' + val.id + '"  onclick="loadcomp(' + val.id + ')"><th scope="row">' + val.com + '</th><td>' + val.loc + '</td> <td>' + val.reg + '</td>  \
                                                        <td><h3 style="margin: 0;"><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star"></span></h3></td> \
                                                   </tr>';

                            ////////////////////
                        });
                        var Table = document.getElementById("showdataC");
                        Table.innerHTML = "";
                        $("#showdataC").html(str);
                        map.fitBounds(bounds);
                    }


                    function clearMap() {
                        // Clear out the old markers.
                        markers.forEach(function (marker) {
                            marker.setMap(null);
                        });
                        markers = [];
                    }
                    function loadcomp(id) {
                        //console.log(id);
                        $("tbody > tr").removeClass("success");
                        $("tbody > #" + id).addClass("success");
                        map.setCenter(markers[id].getPosition());
                        infowindow[id].open(map, markers[id]);

                        $.ajax({
                            url: "getData.php?id=" + id
                        })
                                .done(function (data) {
                                    var resp = data;
                                    try {
                                        resp = JSON.parse(data).data;
                                    } catch (e) {
                                        console.log(e);
                                    }
                                    //console.log(resp[0]);
                                    var strC = "<h3>" + resp[0]["Company"] + "</h3>";
                                    strC += '<h3 style="margin: 0;"><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star lab_yel"></span><span class="glyphicon glyphicon-star"></span></h3>';
                                    strC += '<div class="col-sm-12" style="text-align: left;"><h4><b>Region:</b> ' + resp[0]["Region"] + '</h4></div>';
                                    $.each(resp[0], function (key, val) {
                                        if (isNaN(key)) {
                                            if (key != 'id' && key != 'Company' && key != 'Lat' && key != 'Lon' && key != 'Region') {
                                                if (val != "" && val != 'Unknown') {
                                                    var kKey = key.split('_').join(' ');
                                                    strC += '<div class="col-sm-12" style="text-align: left;"><b>' + kKey + '</b>:' + val + '</div>';

                                                }
                                            }
                                        }
                                    });
                                    //console.log(strC);
                                    $("#map_model").show();
                                    $("#labelC").html(strC);

                                });

                    }
                    function geocodeAddress(geocoder, resultsMap) {
                        var address = document.getElementById('address').value;
                        geocoder.geocode({'address': address}, function (results, status) {
                            if (status === 'OK') {
                                resultsMap.setCenter(results[0].geometry.location);
                                var marker = new google.maps.Marker({
                                    map: resultsMap,
                                    position: results[0].geometry.location
                                });
                            } else {
                                alert('Geocode was not successful for the following reason: ' + status);
                            }
                        });
                    }
                </script>
                <script async defer
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRY1iXXZT1q5zw4hr0Ih_ikJI-pAhLh7k&libraries=places&callback=initMap">
                </script>
            </div>
        </div>

        <script>
//            var markers = [];
//            var infowindow = [];
//            var str;
//            $(document).ready(function () {
//                $.ajax({
//                    url: "getData.php"
//                })
//                        .done(function (data) {
////                            var resp = JSON.parse(data);
////                            console.log(resp);
////                            var bounds = new google.maps.LatLngBounds();
////                                    $.each(resp["data"], function (key, val) {
////                                        var myLatLng = {lat: val.lat, lng: val.lon};
////                                        var myPlace = new google.maps.LatLng(val.lat, val.lon);
////                                        bounds.extend(myPlace);
////                                        markers[val.id] = new google.maps.Marker({
////                                            position: myPlace,
////                                            map: map,
////                                            title: val.com
////                                        });
////                                        var contentString = '<div id="content">' +
////                                                '<div id="siteNotice"></div>' +
////                                                '<h3 id="firstHeading" class="firstHeading" style="color: black;">' + val.com + '</h3>' +
////                                                '<div id="bodyContent"></div></div>';
////                                        infowindow[val.id] = new google.maps.InfoWindow({
////                                            content: contentString
////                                        });
////                                        markers[val.id].addListener('click', function () {
////                                            infowindow[val.id].open(map, markers[val.id]);
////                                            loadcomp(val.id);
////                                        });
////
////                                        /////////////////////
////                                        str += '<tr id="' + val.id + '"  onclick="loadcomp(' + val.id + ')"><th scope="row">' + val.com + '</th><td>' + val.loc + '</td> <td>' + val.reg + '</td>  \
//                                                        < td > < h3 style = "margin: 0;" > < span class = "glyphicon glyphicon-star lab_yel" > < /span><span class="glyphicon glyphicon-star lab_yel"></span > < span class = "glyphicon glyphicon-star lab_yel" > < /span><span class="glyphicon glyphicon-star lab_yel"></span > < span class = "glyphicon glyphicon-star" > < /span></h3 > < /td> \
////                                                   </tr>';
////
////                                        ////////////////////
////                                    });
////                            map.fitBounds(bounds);
////                            $("#showdataC").html(str);
//                        });
//            });

//            function loadcomp(id) {
//                console.log(id);
//                map.setCenter(markers[id].getPosition());
//                infowindow[id].open(map, markers[id]);
//            }
        </script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>