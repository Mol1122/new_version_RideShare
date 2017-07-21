<?php

	require_once("event_support.php");
	require_once("../db/dbLogin.php");

	$body = <<<EOBODY
		
									<form  action="{$_SERVER['PHP_SELF']}" method="post">
                                        <div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" placeholder="Name"  name="reg_name" id="reg_name" required>
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
                                        <div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                                <label for="reg_email">Email Address</label>
                                                <input type="email" name="reg_email" class="form-control" placeholder="Email Address" id="reg_email" required>
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
										
										
										
										<div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                                <label for="reg_username">Username</label>
                                                <input type="text" name="reg_username" class="form-control" placeholder="Username" id="reg_username" required>
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
										
										<div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
											
												<p id="passMsg"></p>
                                                <label for="reg_password">Password</label>
                                                <input type="password" name="reg_password" class="form-control" placeholder="Password" id="reg_password"
												onfocus="passCheck1(this);"  
												onchange="passCheck1(this);" required>
                                               
                                            </div>
                                        </div>
										
										<div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                                <label for="reg_password2">Re-enter Password</label>
                                                <input type="password" name="reg_password2" class="form-control" placeholder="Re-enter Password" id="reg_password2"
												onfocus="passCheck2(this);"  
												onchange="passCheck2(this);"
												required>
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
										
										
										
                                        <div class="row control-group">
											<br><p>Phone Number</p>
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                            	<input type="tel" placeholder="123"  id="reg_phone1" name="reg_phone1" maxlength='3' required style="width: 3em" />
												— <input type="tel"  placeholder="456"  id="reg_phone2" name="reg_phone2"  maxlength='3' required style="width: 3em" />
												— <input type="tel" placeholder="7890"  id="reg_phone3" name="reg_phone3"  maxlength='4' required style="width: 4em" /><br><br>
                                            </div>
                                        </div>

                                        <div class="row control-group">
											<br><p>Most frequent-used address (optional):</p>
                                            <div class="form-group col-xs-12 floating-label-form-group controls">											
                                                <label for="reg_address_street">Street</label>
                                                <input type="text" class="form-control" placeholder="Street"  name="reg_address_street" id="reg_address_street">
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
										
										<div class="row control-group">
											<div class="form-group col-xs-12 floating-label-form-group controls">											
                                                <label for="reg_address_city">City</label>
                                                <input type="text" class="form-control" placeholder="City"  name="reg_address_city" id="reg_address_city">
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
										
										<script>
											function passCheck1 (pass1) {												
												var pass2 =  document.getElementById("reg_password2");
												if(pass1.value !== pass2.value && (pass2.value !== "" && pass1.value !== ""))	{
														console.log(pass2.value);
														document.getElementById("passMsg").innerHTML = "<h4>Passwords Don't Match.</h4>";
														$(pass2).val('');
												} else {
														document.getElementById("passMsg").innerHTML = "";
												}						
											}
											
											function passCheck2 (pass2) {	
													var pass1 =  document.getElementById("reg_password");
													if(pass1.value !== pass2.value && (pass1.value !== "" && pass2.value !== "")){
														document.getElementById("passMsg").innerHTML = "<h4>Passwords Don't Match.</h4>";
														$(pass2).val('');
													} else {
														document.getElementById("passMsg").innerHTML = "";
													}
											}
											
										</script>
                                        
EOBODY;
	$body .= generateStates();
			//<strong>State: </strong><input type="text" name="reg_address_state" id="reg_address_state" style="width: 2em"/>
	$body .= <<<EOBODY
	
											<div class="form-group col-xs-6 floating-label-form-group controls">											
                                                <label for="reg_address_zip">Zipcode</label>
                                                <input type="text" class="form-control" placeholder="Zipcode"  name="reg_address_zip" id="reg_address_zip">
                                                <p class="help-block text-danger"></p>
                                            </div>
										</div>
										
										<div class="row control-group">
											<div class="form-group col-xs-12 floating-label-form-group controls">											
                                                <label for="eula">City</label>
                                                <input type="checkbox" class="form-control" placeholder="City"  name="eula" id="eula" required>
												<p>By checking this you agree to the <a href="EULA.html">Terms and Conditions</a>.<br><br></p>
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
										
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
		
			$nameValue = trim($_POST["reg_name"]);
			$emailValue = trim($_POST["reg_email"]);
			$usernameValue = trim($_POST["reg_username"]);
			$passwordValue = password_hash(trim($_POST["reg_password"]), PASSWORD_DEFAULT);
			$phone1Value = trim($_POST["reg_phone1"]);
			$phone2Value = trim($_POST["reg_phone2"]);
			$phone3Value = trim($_POST["reg_phone3"]);
			$phoneValue = $phone1Value .$phone2Value .$phone3Value;
			$streetValue = trim($_POST["reg_address_street"]);
			$cityValue = trim($_POST["reg_address_city"]);
			$stateValue = trim($_POST["reg_address_state"]);
			$zipValue = trim($_POST["reg_address_zip"]);
			$addressValue = $streetValue ." " .$cityValue ." " .$stateValue ." " .$zipValue;
			
			/* Checking if the username or email already exists */
			//$sqlQuery = "SELECT " .$usernameValue ." from " .$table ." where username=" .$usernameValue;
			$sqlQuery = sprintf("SELECT username from $table where username='%s'", $usernameValue);
			$result = mysqli_query($db, $sqlQuery);
			if ($result) {
				$numberOfRows = mysqli_num_rows($result);
				if ($numberOfRows != 0) {
					$body = "<h4>This username has already been registered!</h2>" .$body;
				}
			}
			
			$sqlQuery = sprintf("SELECT email from $table where email='%s'", $emailValue);
			$result = mysqli_query($db, $sqlQuery);
			if ($result) {
				$numberOfRows = mysqli_num_rows($result);
				if ($numberOfRows != 0) {
					$body = "<h4>This email has already been registered!</h2>" .$body;
				}
			}

			$sqlQuery = sprintf("insert into $table (name, email, username, password, phone, address, avatar, isdriver, carmodel, drivingexp)
								values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", 
			$nameValue, $emailValue, $usernameValue, $passwordValue, $phoneValue, $addressValue, null, false, null, 0);
			
			$result = mysqli_query($db, $sqlQuery);
			if ($result) {
				header('Location: registration_avatar.php?name=' .$nameValue);
			} else { 				   
				$body = "<h3>Registration Failed<h3>" .$body;
			}
				
			/* Closing */
			mysqli_close($db);
		
	
		}

	$page = generatePage($body, "User Registration", "registration.js", "Sign Up");
	echo $page;	
?>	