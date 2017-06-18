<?php
/**
 * Created by PhpStorm.
 * User: jx
 * Date: 2017/4/30
 * Time: 17:45
 */
require_once ("../db/dbLogin.php");
require_once ("../support.php");
if(!isset($_COOKIE["login"]))
    header("location:../loginCheck.php");
$body = "";
$email=$_COOKIE["login"];
$db_connection = new mysqli($host, $user, $password, $database);
if ($db_connection->connect_error) {
    $body .= "Connection to the database error<br />";
    die($db_connection->connect_error);
} else {
    $query = "select * from drivers where email=\"$email\"";
    $result = $db_connection->query($query);
    if (!$result) {
        $body .= "query failed<br />";
        die("Select Failed: ".$db_connection->error);
    } else {
        $num_rows = $result->num_rows;
        if ($num_rows === 0) {
            $body.= "<h3>No ride information<h3><br>";
        } else {
            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
             
                $query2="select * from riders where driver={$row["id"]} ORDER BY start_time DESC";
                $result2 = $db_connection->query($query2);
                $num_rows2 = $result2->num_rows;
                $colorDriver = "rgba(0,0,0, .2)";
			   $body .= <<<EOBODY
					
					<div class="row control-group btn-outline" style="padding: 20px;text-align: left;color:black;border-radius: 10px; border:1px; border-color:black; background-color:{$colorDriver};">
						<h3>Ride information:</h3>
						<p><strong>Departure: </strong> {$row["origin"]}</p>
                        <p><strong>Destination: </strong> {$row["destination"]} </p><br>
						<h4>Riders Joinned:</h4>
					
EOBODY;
			   $bodyInner = "";
                for ($row_index2 = 0; $row_index2 < $num_rows2; $row_index2++){
                    $result2->data_seek($row_index2);
                    $colorRider = "rgba(55,204,176, .2)";
					$row2 = $result2->fetch_array(MYSQLI_ASSOC);
					
					if($row_index2 % 2 === 0){
                          $colorRider = "rgba(55,204,176, .7)";
					 }
					
					$bodyInner .= <<<EOBODY
					
					<div class="row control-group btn-outline" style="padding: 20px;text-align: left;color:black;border-radius: 10px; border:1px; border-color:black; background-color:{$colorRider};">
						<h4><strong>Rider Email</strong>: {$row2['email']}</h4>
                        <p><strong>Time: </strong> {$row2["start_time"]}</p>
					</div><br>
						
EOBODY;


                }
				
				if($bodyInner === ""){
					$bodyInner .="<p><strong>No Riders Joined</strong></p>";
				}
					
				$bodyInner .="</div><br>";
				$body .= $bodyInner;
            }
        }
    }
}
$body.=<<<EOBODY

				<br><br><form action="../index.html">
										<div class="row control-group">
                                            <div class="form-group col-xs-12">
                                                <button type="submit" name="failedLg" class="btn btn-success btn-lg">Back to Main Menu</button>
                                            </div>
                                        </div>
				</form><br>
EOBODY;

$page=generatePage($body,"Driver info", "Driver History");
echo $page;
?>