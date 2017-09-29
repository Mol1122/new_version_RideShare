<?php
require_once("reg_support.php");
require_once("dbLogin.php");

$body = "";

if (isset($_POST["return_main"])) {
    header("Location: ../index.html"); exit();
} else if (isset($_POST["submit"])) {
    $name = trim($_POST["name"]);
    $password= trim($_POST["password"]);

    $db_connection = new mysqli($host, "root", "password", $database);
    if ($db_connection->connect_error) {
        $body .= "<h3>Connection to the database error<h3><br />";
        die($db_connection->connect_error);
    } else {
        $query = "select * from eventUsers where user_name=\"$name\" OR email=\"$name\";";
        $result = $db_connection->query($query);
        if (!$result) {
            $body .= "query failed<br />";
            die("Search Failed: ".$db_connection->error);
        } else {
            $num_rows = $result->num_rows;
            if ($num_rows === 0) {
                $transionName .= "Failed :(";
                $body.= "<h3>You need to make an account before using our system</h3><br><br>";
                $body.= <<<EOBOY
                <form action="Organization/organizerSignup.php">
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
                if (password_verify($password, $queryPassword)) {
                    session_start();
                    session_unset();
                    $_SESSION['username'] = $row["user_name"];
                    if ($row['is_organizer'] == 'Yes'){
                        $_SESSION['o_or_p'] = 'o';
                        header('Location: ' . "Organization/login_page.php", true, 303);
                    }
                    else{
                        $_SESSION['o_or_p'] = 'p';
                        header('Location: ' . "Participant/login_page.php", true, 303);
                    }
                    
                } else { //invalid password
                    $transionName .= "Failed :(";
                    $body .= <<<EO
					
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



//$body .= $bottom;
$page = generatePage($body, "Organizer Log In", "registration.js", "Organizer Log In");
echo $page;
?>