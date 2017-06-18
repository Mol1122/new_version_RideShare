<?php
    require_once("../db/dbLogin.php");
    require_once("../support.php");
    if(!isset($_COOKIE["login"]))
        header("location:loginCheck.php");
    $body = "";
    $email = $_COOKIE["login"];

    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        $body .= "Connection to the database error<br />";
        die($db_connection->connect_error);
    } else {
        $query = "select * from riders where email=\"$email\" ORDER BY start_time DESC";
        $result = $db_connection->query($query);
        if (!$result) {
            $body .= "query failed<br />";
            die("Select Failed: ".$db_connection->error);
        } else {
            $num_rows = $result->num_rows;
            if ($num_rows === 0) {
                $body.= "<h3>No ride information!<h3><br>";
            } else {
                for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                    $result->data_seek($row_index);
                    $row = $result->fetch_array(MYSQLI_ASSOC);                  
                    $query2="select * from drivers where id={$row["driver"]}";
                    $result2 = $db_connection->query($query2);
                    $result2->data_seek(0);
                    $row2 = $result2->fetch_array(MYSQLI_ASSOC);
                    $query3 = "select * from users where email = \"{$row2["email"]}\"";
                    $result3 = $db_connection ->query($query3);
                    $result3->data_seek(0);
                    $row3 = $result3->fetch_array(MYSQLI_ASSOC);
					$color = "rgba(55,204,176, .2)";
                    
					if($row_index % 2 === 0){
                          $color = "rgba(55,204,176, .7)";
					 }
					
					$body .= <<<EOBODY
					
					<div class="row control-group btn-outline" style="padding: 20px;text-align: left;color:black;border-radius: 10px; border:1px; border-color:black; background-color:{$color};">

						<h4><strong>Driver Email</strong>: {$row3['email']}</h4>
                        <h4><strong>Driver Name</strong>: {$row3['name']}</h4><br>
						<p><strong>Departure: </strong> {$row["origin"]}</p>
                        <p><strong>Destination: </strong> {$row["destination"]} </p>
                        <p><strong>Time: </strong> {$row["start_time"]}</p>
						</div><br>
EOBODY;

                }
            }
        }
    }
$body.=<<<EOBODY

<form action="../index.html">
										<div class="row control-group">
                                            <div class="form-group col-xs-12">
                                                <button type="submit" name="failedLg" class="btn btn-success btn-lg">Back to Main Menu</button>
                                            </div>
                                        </div>
				</form><br>
EOBODY;
$page=generatePage($body,"Rider Information", "Rider History");
echo $page;
?>