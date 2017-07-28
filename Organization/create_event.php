<?php 

session_start();
if (!isset($_SESSION['organization']) || empty($_SESSION['organization'])){
    header("Location: ../index.html");
    exit();
}

?>
<html lang="en">

<head >
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <style>
        .btn-add, .btn-remove {
            margin-left:10px;
            height: 32px;
        }
        .controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input,#pac-input2,#organization,#event_title,#time,#website{
            text-align: left;
            font-weight: bold;
            width: 1200px;
            color: #303030;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 500px;

        }

        .options{
            text-align: left;
            font-weight: bold;
            width: 450px;
            color: #303030;
            margin-top: 18px;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        .pac-container {
            font-family: Roboto;
        }

        #type-selector {
            color: #fff;
            background-color: #4d90fe;
            padding: 5px 11px 0px 11px;
        }

        #type-selector label{
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }
        #date,#date2,#size {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: auto;
        }


    </style>


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ride share research project">
    <meta name="author" content="Xi Chen">
    <title>New Event</title>
    <style>
        #target {
            width: 345px;
        }
    </style>

</head>
<!--icon-->

<link rel="shortcut icon" href="https://cdn2.iconfinder.com/data/icons/circle-icons-1/64/car-128.png" type="image/vnd.microsoft.icon" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Bootstrap Core CSS -->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!--<!-- Theme CSS -->
<link href="../css/styleMainPage.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Exo+2:200" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bubbler+One|Exo+2:200" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bubbler+One|Exo+2:200|Julius+Sans+One" rel="stylesheet">


</head>

<body id="page-top" class="index" onload="set();">

<div class="page-scroll">
    <a href="#portfolioModal1" id="sign" style=" display: none;" class="portfolio-link" data-toggle="modal"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
</div>


<!--title -->
<div class="container">
    <div class="row justify-content-md-center">
        <br><br></b>
        <div class="col col-md-4">
            &nbsp;
        </div>
        <div class="col-4">
            <h1> &nbsp &nbsp &nbsp &nbspNew Event</h1><br>
            <hr class="star-primary">
        </div>
        <div class="col col-md-4">
            &nbsp;
        </div>
    </div>
</div>

<!--map-->
<div id="map" style="width:100%;height:500px ;margin: 0px">
</div>
<br><br></rb>


<div class="container" style="width: 80%;">
    <form id="form"  class = "form-horizontal" style="margin-left: 220px;" action="event_process.php" method="post" onsubmit="return check();">
        <h3>Organization: <?php echo $_SESSION['organization'];?></h3>
        <br>
        <h4> Event Title </h4>
        <input type="text" class="controls" placeholder="Event Title"  name="event_title" id="event_title" required><br /><br />
        <h4> Event Location </h4>
        <input id="pac-input" name="dep" class="controls" type="text" placeholder="Event Location" required><br /><br />

        <div class="dynamic-add">
            <h4> Add Pickup Locations </h4>
            <div class="entry ">
                <input class="autocomplete controls options" id="loc1" name="fields[]" type="text" placeholder="Pickup Location" required />
                    <button class="btn btn-success btn-add" type="button">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                <br /><br />
            </div>
        </div>

        <h4> Event Time </h4>
        <input type="datetime-local" class="controls" id="time" name="time" required><br /> <br />
        <h4> Event Website </h4>
        <input type="text" name="website" class="controls" placeholder="Website" id="website"><br /><br /><br />
        <input type="checkbox" style = "margin-right: 5px;" name="priv" value="priv"> Make my event private: users won't be able to join without the event key. You can see your event key when you look up your event under "Look Up Event."<br/><br><br>
        <input hidden type="text" name="L1" id="L1">
        <input hidden type="text" name="L2" id="L2">

        <div class="row">
            <div class="form-group col-xs-6">
                <button type="submit" id="submit" name="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-search"> </span> Create Event </button>
            </div>
            <div class="form-group col-xs-6">
                <button type="reset"  name="reset" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-erase">&nbsp; </span> Reset</button>
            </div>
        </div>

        <div class="row justify-content-md-center" style="margin-left: 14px;">
            <br><br></br>
            <div class="col-md-4">&nbsp;</div>
            <div class="col-4">
                <button type="button" id="closeB" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
            <div class="col col-md-4">&nbsp</div>
        </div>
    </form>
</div>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="../js/jqBootstrapValidation.js"></script>

<!-- Theme JavaScript -->
<script src="../js/freelancer.min.js"></script>

<script>
var num = 1;
var numLimit = 100;
$(function()
{
    if (num <= numLimit){
    $(document).on('click', '.btn-add', function(e)
    {   
        num++;
            e.preventDefault();

            var controlForm = $('.dynamic-add'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);

            newEntry.find('input').val('');
            newEntry.find('input').attr('id', 'loc'+ num);
            var autocomplete = new google.maps.places.Autocomplete(document.getElementById('loc'+num));
            google.maps.event.addListener(autocomplete, 'place_changed', function () {});
            controlForm.find('.entry:last .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="glyphicon glyphicon-minus"></span>');
        }).on('click', '.btn-remove', function(e)
        {
            num--;
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
        });
    }

        
});
</script>
<script type="text/javascript">
window.onload = function(){
function initialize() {

    var acInputs = document.getElementsByClassName("autocomplete");

    for (var i = 0; i < acInputs.length; i++) {

        var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
        });
    }
}

initialize();  
}

</script>

<script>
    function set(){
        console.log("in");
    }

    $("#closeX").click(function () {
        window.location.replace("../index.html");
    });

    $("#closeB").click(function () {
        window.location.replace("../index.html");
    });

    var markers = [];
    var markers2 = [];

    document.getElementById("form").onsubmit=function check() {
        var message="";
        var start=document.getElementById("date").value.split('T');
        var end=document.getElementById("date2").value.split('T');
        if(start[0]!=end[0]){
            message+="Wrong end time.\n";
        }
        else if(start[1]>end[1]){
            message+="Wrong end time.\n";
        }
        else if(markers.length===0||markers2.length===0){
            message+="Wrong place.\n";
        }
        if (message !== "") {
            alert(message);
            return false;
        } else {
            var valuesProvided = "Do you want to submit this information?\n";
            if (window.confirm(valuesProvided))
                return true;
            else
                return false;
        }
    };
    function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 37.1, lng: -95.7},
            zoom: 10
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
            }, function() {});
        }

        var input = document.getElementById('pac-input');
        var input2 = document.getElementById('pac-input2');
        var date= document.getElementById("date");
        var date2= document.getElementById("date2");
        var size=document.getElementById("size");
        var submit= document.getElementById("submit");
        var searchBox = new google.maps.places.SearchBox(input);
        var searchBox2 = new google.maps.places.SearchBox(input2);

        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();
            if (places.length === 0) {
                return;
            }
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                markers.push(new google.maps.Marker({
                    map: map,
                    label:"Dep",
                    title: place.name,
                    position: place.geometry.location
                }));
                document.getElementById("L1").value=markers[0].position;
                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

        searchBox2.addListener('places_changed', function() {
            var places = searchBox2.getPlaces();
            if (places.length === 0) {
                return;
            }

            markers2.forEach(function(marker) {
                marker.setMap(null);
            });
            markers2 = [];

            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };


                markers2.push(new google.maps.Marker({
                    map: map,
                    label: "Des",
                    title: place.name,
                    position: place.geometry.location
                }));
                document.getElementById("L2").value=markers2[0].position;
                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }


</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC4rck9rZxndKVt85FYnunfSnW00SCoco&libraries=places&callback=initAutocomplete"
        async defer></script>

</body>
</html>