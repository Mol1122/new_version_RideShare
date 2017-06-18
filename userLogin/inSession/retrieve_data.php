<?php
    require_once("support.php");
    require_once("../../db/dbLogin.php");
    
    $transitionName;
    $body = "";

    if(!isset($_COOKIE["login"])) {
        header("location:../userLogin/loginCheck.php");
    }

    if (isset($_POST["submit"])) {
        $db_connection = new mysqli($host, $user, $password, $database);
        if ($db_connection->connect_error) {
            $transitionName = "Sorry, our servers Down :(";
            $body .= "Connection to the database error<br />";
            die($db_connection->connect_error);
        } else {
            $dep=$_POST["dep"];
            $des=$_POST["des"];
            $L1=substr($_POST["L1"],1,strlen($_POST["L1"])-2);
            $L2=substr($_POST["L2"],1,strlen($_POST["L2"])-2);
            $L1a=explode(",",$L1);
            $L2a=explode(",",$L2);
            $origin_lat = $L1a[0];
            $origin_lng =$L1a[1] ;
            $destination_lat= $L2a[0];
            $destination_lng= $L2a[1];
            $prefer_depart_time = $_POST["start"];
            $prefer_depart_time = str_replace("T"," ",$prefer_depart_time);
            //$body .= $prefer_depart_time."<br />";
            $query = "select * from drivers where start_time <= \"$prefer_depart_time\" and end_time >= \"$prefer_depart_time\" and size > 0;";
            $result = $db_connection->query($query);
            if (!$result) {
                $transitionName = "Sorry, our servers Down :(";
                $body .= "query failed<br />";
                die("Select Failed: ".$db_connection->error);
            } else {
                $num_rows = $result->num_rows;
                if ($num_rows === 0) {
                     $transitionName = "No Rides Found";
                     $body .=  "<h3> There are no Matching Drivers Avaliable<h3>";
                } else {
                    $transitionName = "Choose your Ride!";
                    $driverInfoStr = "";
                    for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                        $result->data_seek($row_index);
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                        if ($row_index == $num_rows - 1) {
                            $driverInfoStr .= "{$row['email']}|{$row['latitude_o']}|{$row['longitude_o']}|{$row['latitude_d']}|{$row['longitude_d']}|{$row['origin']}|{$row['destination']}|{$row['start_time']}|{$row['end_time']}|{$row['size']}|{$row['id']}";
                        } else {
                            $driverInfoStr .= "{$row['email']}|{$row['latitude_o']}|{$row['longitude_o']}|{$row['latitude_d']}|{$row['longitude_d']}|{$row['origin']}|{$row['destination']}|{$row['start_time']}|{$row['end_time']}|{$row['size']}|{$row['id']}*";
                        }
                    }
                    $body .=<<< BODY
                            <input type = "hidden" id = "driverInfoStr" value = "$driverInfoStr" />                          
                            <form method='post' action='submit_choice.php'>
                                <div id="form"></div>
                             </form>
                            <script>
                                function initMap() {
                                    var driverInfoStr = document.getElementById("driverInfoStr").value;
                                   /* var arr = new Array(); */
                                    var arr_carpool = new Array();
                                    var driverArray = driverInfoStr.split("*");
                                    for (var idx = 0; idx < driverArray.length; idx++) {
                                        var temp = driverArray[idx].split("|");
                                     //   arr[idx] = [temp[0], temp[1], temp[2], temp[3], temp[4],temp[5],temp[6],temp[7],temp[8],temp[9],temp[10]];
                                        arr_carpool[idx] = [temp[0], temp[1], temp[2], temp[3], temp[4],temp[5],temp[6],temp[7],temp[8],temp[9],temp[10]];
                                        var driver_o= new google.maps.LatLng(temp[1],temp[2]);
                                        var rider_o= new google.maps.LatLng($origin_lat,$origin_lng);
                                        var driver_d= new google.maps.LatLng(temp[3],temp[4]);
                                        var rider_d= new google.maps.LatLng($destination_lat,$destination_lng);
                                        var dis_o=google.maps.geometry.spherical.computeDistanceBetween(driver_o,rider_o);
                                        var dis_d=google.maps.geometry.spherical.computeDistanceBetween(driver_d,rider_d);
                                    //    arr[idx].push(dis_o+dis_d);
                                        /* This is for carpool */
                                        var dis_between_driver_o_driver_d = google.maps.geometry.spherical.computeDistanceBetween(driver_o,driver_d);
                                        var dis_between_rider_o_driver_d = google.maps.geometry.spherical.computeDistanceBetween(rider_o,driver_d);
                                        if (dis_o <= dis_between_driver_o_driver_d) {                         
                                            var ratio = (dis_o+dis_between_rider_o_driver_d) / dis_between_driver_o_driver_d;
                                            if (ratio <= 1.5 && rider_d == rider_o) {
                                                //arr_carpool.push(dis_o);
                                                //arr_carpool.push(dis_between_rider_o_driver_d);
                                                //arr_carpool.push(dis_between_driver_o_driver_d);
                                                arr_carpool[idx].push(ratio);
                                            } else {
                                                arr_carpool[idx].push(Number.POSITIVE_INFINITY);
                                            }
                                        } else {
                                            arr_carpool[idx].push(Number.POSITIVE_INFINITY);
                                        }              
                                    }
                                  //  arr.sort(function (first,second){return first[first.length-1]-second[first.length-1];});
                                    /* This is for carpool */
                                    arr_carpool.sort(function (first,second){return first[first.length-1]-second[first.length-1];});
                                    /* only take the nearest 3 results */
                                    var length=arr_carpool.length>3?3:arr_carpool.length;
                                    var string="";
                                    for(var i=0;i<length;i++){
                                        let color = "rgba(55,204,176, .2)";
                                        if(i % 2 === 0){
                                            color = "rgba(55,204,176, .7)";
                                            
                                        }
                                        if (arr_carpool[i][11] > 1.5) {
                                            break;
                                        }
                                        string +=`<div class="row control-group btn-outline" style=\"padding: 20px;text-align: left;color:black;border-radius: 10px; border:1px; border-color:black; background-color:\${color};\">`;
                                      /*  string +=`<h4><input type='radio' name='choice' value='\${arr[i][10]}' required><strong> Email</strong>: \${arr[i][0]}</h4>`;   */
                                        string +=`<h4><input type='radio' name='choice' value='\${arr_carpool[i][10]}' required><strong> Email</strong>: \${arr_carpool[i][0]}</h4>`;
                                      /*  string += `<p><strong>Departure: </strong>\${arr[i][5]}</p>`;  */
                                        string += `<p><strong>Departure: </strong>\${arr_carpool[i][5]}</p>`;
                                      /*  string += `<p><strong>Destination: </strong>\${arr[i][6]}</p>`;   */
                                        string += `<p><strong>Destination: </strong>\${arr_carpool[i][6]}</p>`;
                                      /*  string += `<p><strong>Number of Seats: </strong>\${arr[i][9]}</p>`;  */
                                        string += `<p><strong>Number of Seats: </strong>\${arr_carpool[i][9]}</p>`;
                                        string +=`</div><br>`;
                                    }
                                    if (string == "") {
                                        string += "<h3> There are no Matching Drivers Avaliable<h3>";
                                        
                                    } else {
                                        string+=`<input type='hidden' name='dep' value='$dep'>`;
                                        string+=`<input type='hidden' name='des' value='$des'>`;
                                        string+=`<input type='hidden' name='time' value='$prefer_depart_time'>`;
                                    
                                
                                        string += " <div class='row' style='padding-left:37%;text-align: center;'> ";
                                        //string += " <div class='form-group col-xs-2'>&nbsp;";
                                        //string += "</div>";
                                        string += "<div class='form-group col-xs-2'>";
                                        string +="<button class='btn btn-success btn-lg' type='submit' name='submit'><span class='glyphicon glyphicon-erase' &nbsp\; </span> Submit</button>";
                                        string += "</div>";
                                        //string += " <div class='form-group col-xs-2'>&nbsp\;";
                                        //string += "</div>";
                                        string += "</div>";
                                    }
                                    
                                    document.getElementById("form").innerHTML=string;
                                    
                                }
                        </script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC4rck9rZxndKVt85FYnunfSnW00SCoco&libraries=geometry&callback=initMap">
</script>
                            
BODY;
                }
            }
        }
    }
   
    $page = generatePage($body, "matching", $transitionName);
    echo $page;
?>