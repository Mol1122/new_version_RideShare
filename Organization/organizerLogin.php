<?php
require_once("reg_support.php");
require_once("dbLogin.php");

$body = "";

if (isset($_POST["return_main"])) {
    header("Location: ../index.html"); exit();
} else if (isset($_POST["submit"])) {
    $name = trim($_POST["name"]);
    $password= trim($_POST["password"]);
    $organizer_choice = $_POST["organizer_choice"];

    $db_connection = new mysqli($host, "root", "password", $database);
    if ($db_connection->connect_error) {
        $body .= "<h3>Connection to the database error<h3><br />";
        die($db_connection->connect_error);
    } else {
        $query = "select * from eventUsers where user_name=\"$name\"";
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
                <form action="organizerSignup.php">
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
                    $_SESSION['organization'] = $name;
                    $_SESSION['username'] = $name;
                    if ($organizer_choice == "Look Up Event") { //not yet implemented!!!!
                        if($_POST["submit"]){
                            header("Location: ../index.html"); exit();
                        }
                        else{
                            header("Location: ../index.html"); exit();
                        }
                    } else if ($organizer_choice == "Edit") { //not yet implemented!!!!
                        header("Location: ../Organization/event_edit_select.php");
                        exit();
                    } else if ($organizer_choice == "New Event") {
                        header("Location: create_event.php");
                        exit();
                    } else {
                        $body .= "Fail";
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

$body .= <<<EOBODY
		
									<form  action="{$_SERVER['PHP_SELF']}" method="post">
									    <div class="row control-group">
                                        <div class="form-group col-xs-12 floating-label-form-group controls">
                                            <label>Log in as:</label>
                                            <div class=col-xs-4 floating-label-form-group controls">
                                            <input type="radio" name="organizer_choice" class="form-control" value="Look Up Event" id="look_up_event" required > Look Up Event
                                        </div>
                                        <div class=col-xs-4 floating-label-form-group controls">
                                        <input type="radio" name="organizer_choice" class="form-control" value="Edit" id="edit" required > Edit
                                    </div>
                                    <div class=col-xs-4 floating-label-form-group controls">
                                    <input type="radio" name="organizer_choice" class="form-control" value="New Event" id="new_event" required > New Event
                                    </div>
                                        </div>
                                        </div>
                                        <div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                                <label >Name</label>
                                                <input type="text" class="form-control" placeholder="Organization Name"  name="name" id="name" required>
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
                    		
										<div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
											
												<p id="passMsg"></p>
                                                <label for="reg_password">Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="Password" id="password" required>
                                               
                                            </div>
                                        </div>							
										<br>
										
                                        
EOBODY;

$body .= <<<EOBODY
										
										 <div class="row">
                                            <div class="form-group col-xs-6">
                                                <button type="submit"  name="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-log-in">&nbsp; </span> Go </button>
                                            </div>
											<div class="form-group col-xs-6">
                                                <button type="reset"  name="reset" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-erase">&nbsp; </span> Reset</button>
                                            </div>
                                        </div>
					 </form>
			
EOBODY;


    mysqli_close($db);



//$body .= $bottom;
$page = generatePage($body, "Event Log In", "registration.js", "Event Log In");
echo $page;
?>