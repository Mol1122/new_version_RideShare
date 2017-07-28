<?php

function generatePage($body, $title="Rideshare", $transitionName) {
    $page = <<<EOPAGE
<!DOCTYPE html>
<html lang="en">

<head >

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Group Project for CMSC389N">
    <meta name="author" content="Stefani Moore">

    <title>$title</title>


EOPAGE;

$page .= <<<EOPAGE
    <!--icon-->
    
    <link rel="shortcut icon" href="https://cdn2.iconfinder.com/data/icons/circle-icons-1/64/car-128.png" type="image/vnd.microsoft.icon" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!--<!-- Theme CSS -->
    <link href="css/styleMainPage.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Exo+2:200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Bubbler+One|Exo+2:200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Bubbler+One|Exo+2:200|Julius+Sans+One" rel="stylesheet">


</head>

<body id="page-top" class="index" onload="set();">
                    
                    <div class="page-scroll">
                        <a href="#portfolioModal1" id="sign" style="display:none;" class="portfolio-link" data-toggle="modal"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
                    </div>		
		
    <!-- Portfolio Modals -->
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true"  style="display: block; padding-left: 0px;">
        <div class="modal-content">
            <div id="closeX"class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>$transitionName</h2>
                            <hr class="star-primary">
                            <!--<img src="assets/login.png" class="img-responsive img-centered" heigh= '50%' width='50%'  alt="">-->
                                                        
                             <div class="row">
                                <div class="col-lg-8 col-lg-offset-2">
                                    <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                                    <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                                    $body
                                
								</div>
								
							
                            </div>                            
                           <br> <button type="button" id="closeB" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/freelancer.min.js"></script>

</body>

<script>
		function set(){
			console.log("in");
			$('#sign').hide();
			$('#sign').click();
			
		}
		
		$("#closeX").click(function () {
			window.location.replace("../../index.html");
		});
		
		$("#closeB").click(function () {
			window.location.replace("../../index.html");
		});
		
</script>

</html>

EOPAGE;

    return $page;
}


?>