<?php
	require_once("reg_support.php");
	require_once("../db/dbLogin.php");
	
	$nameValue = $_GET['name'];
	$filename = rawurlencode($_GET['name']);
	$scriptname = "registration_avatar.php?name=" .$nameValue;
	$transionName = "<h1> Welcome to Rideshare, " .$nameValue ."!</h1>";
	$body = <<<EOT
	<p>Choose your profile picture...</p>
		
		<form action="{$scriptname}" method="post" enctype="multipart/form-data">

		
		
			<img id="user_avatar"src="user_avatar\default.png" alt="User Avatar" style="width:200px;height:200px;"</img></br>
			
			<p>Select image to upload:<p><br>			
										<div class="row control-group" >
											<p>(Only support jpg/jpeg/png format, < 200kb)<p>
                                            <div class="form-group col-xs-12" style="text-align:center; padding-left:60px;">												
                                                <input type="file" onchange="readURL(this);" name="avatar" id="avatar" class="btn btn-success btn-lg">
                                            </div>
                                        </div>
										
										<div class="row control-group">
                                            <div class="form-group col-xs-12">
                                                <input type="submit" name="submit" value= "Upload Picture" class="btn btn-success btn-lg">
                                            </div>
                                        </div>

										<input type="hidden" name="name" value={$filename}>
		</form>
		
				<form action="$scriptname" method="post" enctype="multipart/form-data">
										<div class="row control-group">
                                            <div class="form-group col-xs-12">
                                                <button type="submit" name="skip"class="btn btn-success btn-lg">Skip Step</button>
                                            </div>
                                        </div>
										<input type="hidden" name="name" value={$filename}>
				</form>
EOT;
	
	if(isset($_POST['skip'])) {
		header('Location: registration_driverinfo.php?name=' .$nameValue); 
	}
	if (isset($_POST['submit'])) {
		$nameValue = $_POST["name"];
		$validextensions = array("jpeg", "jpg", "png");
		
		$imagename = $_FILES["avatar"]["name"];
		$imagetmpname = $_FILES["avatar"]["tmp_name"];
		$imagetype = $_FILES["avatar"]["type"];
		$imagesize = $_FILES["avatar"]["size"];
		
		$temporary = explode(".", $imagename);
		$file_extension = end($temporary);
		
		if ((($imagetype == "image/png") || ($imagetype == "image/jpg") || ($imagetype == "image/jpeg")
		) && ($imagesize < 200000)//Approx. 100kb files can be uploaded.
		&& in_array($file_extension, $validextensions)) {
			$db = connectToDB($host, $user, $password, $database);
			$file_content = file_get_contents($imagetmpname);
			$file_content = mysqli_real_escape_string($db, $file_content) or die("Error: cannot read file");
			

			
			move_uploaded_file($imagetmpname, "user_avatar/" . $nameValue);

			
			$sqlQuery = sprintf("update $table set avatar='%s' where name='%s'", $file_content, rawurldecode($nameValue)); 
			$result = mysqli_query($db, $sqlQuery);
			if ($result) {
				header('Location: registration_driverinfo.php?name=' .$nameValue);
			}
			else {
				$body = "Image Upload failed, please try again." .$body;
			}
		}
		else {
			$body = "<h3>File does not meet the requirements! Please try again.</h3>" .$body;
		}
	}

	$page = generatePage($body, "User Registration Avatar", "registration_avatar.js", $transionName);
	echo $page;

?>	