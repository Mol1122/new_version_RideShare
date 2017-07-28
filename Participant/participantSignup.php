<?php
/* Both organization and participants use this sign up script */
require_once("reg_support.php");
require_once("dbLogin.php");

$body = <<<EOBODY
		
									<form  action="{$_SERVER['PHP_SELF']}" method="post">
                                        <div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                                <label >Name</label>
                                                <input type="text" class="form-control" placeholder="Participant Username"  name="user_name" id="user_name" required>
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
                                        <div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                                <label for="reg_email">Email Address</label>
                                                <input type="email" name="email" class="form-control" placeholder="Email Address" id="email" required>
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
										
										<div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                                <label for="reg_password2">Re-enter Password</label>
                                                <input type="password" name="password2" class="form-control" placeholder="Re-enter Password" id="password2" required>
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
										
										<br>
										
                                        
EOBODY;

$body .= <<<EOBODY
										
										 <div class="row">
                                            <div class="form-group col-xs-6">
                                                <button type="submit"  name="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-log-in">&nbsp; </span> Sign Up </button>
                                            </div>
											<div class="form-group col-xs-6">
                                                <button type="reset"  name="reset" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-erase">&nbsp; </span> Reset</button>
                                            </div>
                                        </div>
					 </form>
			
EOBODY;

if (isset($_POST["return_main"])) {
    header("Location: ../index.html");
}
else if (isset($_POST["submit"])) {
    $db = connectToDB($host, $user, $password, $database);
    /*if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }*/

    $user_name = trim($_POST["user_name"]);
    $email = trim($_POST["email"]);
    $user_password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
    $query = "SELECT * FROM eventUsers WHERE user_name=\"$user_name\" LIMIT 1;";
    $result2 = mysqli_query($db, $query);
    if (password_verify($_POST["password2"], $user_password) && $result2 && $result2->num_rows === 0) {
        $sqlQuery = "insert into eventUsers values(\"$user_name\", \"$email\", \"$user_password\", \"No\")";
        $result = mysqli_query($db, $sqlQuery);
        if ($result) {
            header("Location: signup_successful.php");
        }
        else {
            $body = "<h3>Sign Up Failed<h3>" .$body;
        }
    }
    else if ($result2 && $result2->num_rows > 0){
        $body = "<h3>This username is taken</h3>".$body;
    }
    else {
        $body = "<h3>Password doesn't matched<h3>" .$body;
    }

    /* Closing */
    mysqli_close($db);


}

$page = generatePage($body, "Participant Sign Up", "registration.js", "Participant Sign Up");
echo $page;
?>