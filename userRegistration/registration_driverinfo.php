<?php
	require_once("reg_support.php");
	require_once("../db/dbLogin.php");
	
	$nameValue = rawurldecode($_GET['name']);
	$scriptname = "registration_driverinfo.php?name=" .$nameValue;
	$body = <<<EOT
		<h3> Almost there! You are one step away from completion!</h3>
		
		<form action="{$scriptname}" method="post">	
		
									<img src="assets\car.png" alt="User Avatar" style="width:200px;height:200px;"</img></br>
									<h4>Are you a driver?</h4>
	
										<div class="row control-group" >
                                            <div class="form-group col-xs-6">											
                                                <input type="radio"  name="isdriver" value="Yes" class="btn btn-success btn-lg" onchange="processYes(this)" required ><h4> Yes</h4>									
											
                                            </div>
											<div class="form-group col-xs-6">												
                                                <input type="radio"  name="isdriver" value="No" class="btn btn-success btn-lg" onchange="processNo(this)" required><h4> No</h4>									
                                            </div>
											<script>
												function processYes(evt){
													if(evt.checked){
														document.getElementById("carmodel").required = true;
													}
												}
												
												function processNo(evt){
													if(evt.checked){
														document.getElementById("carmodel").required = false;
													}
												}
											</script>
                                        </div>
										
										<div class="row control-group">										
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
											<h4>If Yes, please provide the information below:</h4>
                                                <label for="carmodel">Vehicle Model</label>
                                                <input type="text" class="form-control" placeholder="Vehicle Model"  name="carmodel" id="carmodel">
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
										
										<div class="row control-group">										
                                            <divclass="form-group col-xs-12 floating-label-form-group controls">
												<br><h4>Years of Experience:</h4>
                                                <input  type="number" style="margin-left:200px;max-width:100px;border-style: inset;"class="form-control" min='0' placeholder="Years of Experience:"  name="drivingexp" id="drivingexp" value='0'defaul>
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
										
																				
										<div class="row control-group">
                                            <div class="form-group col-xs-12">
                                                <input type="submit" name="submit" value= "Finish Application" class="btn btn-success btn-lg">
                                            </div>
                                        </div>

										
		</form>
EOT;

	if (isset($_POST['submit'])) {
		$db = connectToDB($host, $user, $password, $database);
		
		$isdriverValue = $_POST["isdriver"];
		$carmodelValue = $_POST["carmodel"];
		$drivingexpValue = $_POST["drivingexp"];
		
		$sqlQuery = sprintf("update $table set isdriver='%s', carmodel='%s', drivingexp=%s where name='%s'", $isdriverValue, $carmodelValue, $drivingexpValue, $nameValue); 
		$result = mysqli_query($db, $sqlQuery);
		echo $sqlQuery;
		if ($result) {
			header('Location: registration_successful.php?name=' .$nameValue);
		}
		else {
			$body .= "Info Update failed, please try again later.";
		}
	}

	$page = generatePage($body, "User Registration Avatar", "", "Driver Information");
	echo $page;

?>	