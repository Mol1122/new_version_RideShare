<?php
require_once("../db/dbLogin.php");
require_once("../support.php");

$body="";
$bottom = "";
$transionName = "Login ";
if (isset($_POST["submit"])) {
    $email = trim($_POST["email"]);
    $user_password= trim($_POST["password"]);
    $driver_or_rider = $_POST["driver_or_rider"];

    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        $bottom .= "<h3>Connection to the database error<h3><br />";
        die($db_connection->connect_error);
    } else {
        $query = "select * from users where email=\"$email\"";
        $result = $db_connection->query($query);
        if (!$result) {
            $bottom .= "query failed<br />";
            die("Search Failed: ".$db_connection->error);
        } else {
            $num_rows = $result->num_rows;
            if ($num_rows === 0) {
                $transionName .= "Failed :(";
                $bottom.= "<h3>You need to make an account before using our system</h3><br><br>";
                $bottom .= <<<EOBOY
                <form action="../userRegistration/registration.php">
										<div class="row control-group">
                                            <div class="form-group col-xs-12">
                                                <button type="submit" name="skip"class="btn btn-success btn-lg">Create Account</button>
                                            </div>
                                        </div>
				</form>
EOBOY;

            } else {
                $result->data_seek(0);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $queryPassword = $row["password"];
                if (password_verify($user_password, $queryPassword)) {
                    setcookie("login", $email, 0);
                    if ($driver_or_rider == "Driver") {
                        if($_POST["start"])
                            header("location: inSession/driver.html");
                        else
                            header("location: driver_info.php");
                    } else if ($driver_or_rider == "Rider") {
                        if($_POST["start"])
                            header("location: inSession/rider.html");
                        else
                            header("location: rider_info.php");
                    } else {
                        $bottom .= "Fail";
                    }
                } else { //invalid password
					$transionName .= "Failed :(";
                    $bottom .= <<<EO
					
					 <form action="../index.html#portfolio">
					 <h3>Invalid Password!<h3>
										<div class="row control-group">
                                            <div class="form-group col-xs-12">
                                                <button type="submit" name="failedLg" class="btn btn-success btn-lg">Try Again</button>
                                            </div>
                                        </div>
				</form>
EO;
                }
            }
        }
    }
} 
  


$body = $bottom;
$page=generatePage($body,"Login", $transionName);
echo $page;
?>