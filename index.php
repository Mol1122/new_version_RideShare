<?php
session_start();
if ((isset($_SESSION['username']) && !empty($_SESSION['username']))) {
    if (isset($_SESSION['o_or_p']) && !empty($_SESSION['o_or_p'])){
        if ($_SESSION['o_or_p'] == 'o'){
            header('Location: ' . "Organization/login_page.php", true, 303);
            exit();
        }
        else{
            header('Location: ' . "Participant/login_page.php", true, 303);
            exit();
        }
        
    }
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ride share research project">
    <meta name="author" content="Xi Chen">

    <title>UMCP RideShare</title>
    
    <!--icon-->
    
    <link rel="shortcut icon" href="https://cdn2.iconfinder.com/data/icons/circle-icons-1/64/car-128.png" type="image/vnd.microsoft.icon" />


    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!--<!-- Theme CSS -->
    <link href="css/styleMainPage.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Bubbler+One|Exo+2:200|Julius+Sans+One" rel="stylesheet">


</head>

<body id="page-top" class="index">
<div id="skipnav"><a href="#maincontent">Skip to main content</a></div>

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">UMD RideShare</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    
                    <li class="page-scroll">
                        <a href="#about">About</a>
                    </li>

                    <li class="page-scroll">
                        <a href="#reg" class="portfolio-link" data-toggle="modal"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
                    </li>
                     <li class="page-scroll">
                        <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal"><span class="glyphicon glyphicon-log-in"></span> Login</a>
                     </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <!--main button --> 
        <div class="container">
               <div class="row">

                        <div class="col-6 col-md-4 btn btn-lg btn-outline" style="padding-bottom: 40px; background-color: rgba(0,0,0,.8); border: 0px;">
                              
                                <!--<a href="#portfolio"> <img class='icon' src="assets/car.png" ></a>-->
                                      
                                <a href="#portfolioModal2">
                                  <h2 style="color:#37CCB0;">Participants</h2>
                                  <button>
                                Join an Event <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></a>
                        </div>
                        <div class="col-6 col-md-4"></div>
                        <div class="col-6 col-md-4 btn btn-lg btn-outline" style="padding-bottom: 40px; background-color: rgba(0,0,0,.8); border: 0px;">

                                <!--<a href="#portfolio"> <img class='icon' src="assets/car.png" ></a>-->

                                <a href="#portfolioModal2">
                                    <h2 style="color:#37CCB0;">Organizations</h2>
                                    <button>
                                        <a href = "#event" style="color: black; ">Set Up an Event <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></button></a>
                        </div>

                </div>
        </div>
    </header>


<!-- Organizer look up and Individual join in button -->
<section id="event">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Organizer | Participant </h2>
                <hr class="star-primary">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 portfolio-item">
                <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">
                    <div class="caption">
                        <div class="caption-content">
                            <i class="fa fa-search-plus fa-3x"></i>
                        </div>
                    </div>
                    <img src="assets/signup.png" class="img-responsive" alt="Cabin">
                </a>
            </div>
            <!-- event popup is better -->
            <div class="col-sm-6 portfolio-item">
                <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">
                    <div class="caption">
                        <div class="caption-content">
                            <i class="fa fa-search-plus fa-3x"></i>
                        </div>
                    </div>
                    <img src="assets/login.png" class="img-responsive" alt="Slice of cake">
                </a>
            </div>
        </div>
    </div>
</section>



     <!-- About Section -->
    <section class="success" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>About RideShare</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
                    <h3>For Event Participants:</h3><br>
                    <p>Going to an event but don't want to go alone or pay for the costs of the trip alone? If your event is signed up with RideShare, RideShare at UMD helps you find carpool mates attending the same event completely free. </p>
                    <br></p>Sign up for your event now! You may be able to share a ride with someone!</p><br>
                </div>
                <div class="col-lg-4">
                    <h3>For Event Organizers:</h3><br>
                    <p>Hosting an event with people coming from all over? RideShare at UMD helps you set locations such as airports, where users can sign up to be picked up, or carpool together if you don't provide transportation! </p>
                   <br></p>Sign up now and set up your event!</p><br>
                </div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <br><h6>(RiderShare is not responsible for any payment transactions regarding riders)</h6>
                    <a href="userRegistration/registration.php" class="btn btn-lg btn-outline">                       
                        <i class="glyphicon glyphicon-user"></i> Create an Account
                    </a>
                </div>
            </div>
        </div>
    </section>

  


    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>Location</h3>
                        <p>University of Maryland
                            <br>College Park, MD
                            <br>(301) 405-1000</p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Around the Web</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">Facebook</span><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">Google Plus</span><i class="fa fa-fw fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">Twitter</span><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">Linked In</span><i class="fa fa-fw fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">Dribble</span><i class="fa fa-fw fa-dribbble"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>About RideShare</h3>
                        <p>RideShare is a free to use application created for CMSC389N Spring 2017 at UMD.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; Ride Share 2017
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

    <!-- Portfolio Modals -->
<!-- popup script-->
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Login</h2>
                            <hr class="star-primary">
                        
                             <div class="row">
                                <div class="col-lg-8 col-lg-offset-2">
                                    <form action = "loginUser.php" method = "post">
                                                                   
                                        <div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                                <label for="name">Username or Email</label>
                                                <input type="name" name="name" class="form-control" placeholder="Username or Email" id="name" required>
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>
                                        
                                        <div class="row control-group">
                                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                                <label for="password">Password</label>
                                                <input type="password" name = "password" class="form-control" placeholder="Password" id="password" required>
                                                <p class="help-block text-danger"></p>
                                            </div>
                                        </div>

                                        <div style="margin-top: 2em"class="row control-group">
                                            <a href="#reg" class="portfolio-link" data-toggle="modal"><span class="glyphicon glyphicon-user"></span> New to RideShare? Sign Up Here!</a>
                                        </div>
                                        <br>
                                        <div id="success"></div>
                                        <div class="row">
                                            <div class="form-group col-xs-12">
                                                <button name="submit" value="submit" data-toggle="modal" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-log-in">&nbsp; </span> Login</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--Registration choice -->
<div class="portfolio-modal modal fade" id="reg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <h2>Sign Up</h2>
                        <hr class="star-primary">
                        <!--<img src="assets/signup.png" heigth='100px' width='500px' class="img-responsive img-centered" alt="">-->

                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2">
                                <a href="Organization/organizerSignup.php">
                                  <button style="padding:2em" class="btn btn-default">Sign Up as an Organizer <i class="glyphicon glyphicon-user"></i></span></button></a>
                                <a href="Participant/participantSignup.php">
                                  <button style="padding:2em" class="btn btn-default">Sign Up as an Participant <i class="glyphicon glyphicon-user"></i></span></button></a>
                            </div>
                        </div>
            </div>
            <div class="row" style="margin:2em">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- popup organizer script-->
<div class="portfolio-modal modal fade" id="organizer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <h2>Organizer</h2>
                        <hr class="star-primary">
                        <!--<img src="assets/signup.png" heigth='100px' width='500px' class="img-responsive img-centered" alt="">-->

                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2">
                                <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                                <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                                <form action = "Organization/organizer_choice.php" method = "post">
                                    <div class="row control-group">
                                        <div class="form-group col-xs-12 floating-label-form-group controls">
                                            <label>I want to</label>
                                            <div class=col-xs-6 floating-label-form-group controls">
                                            <input type="radio" name="signup_or_login" class="form-control" value="Sign Up" id="signup" required > Sign Up
                                        </div>
                                        <div class=col-xs-6 floating-label-form-group controls">
                                        <input type="radio" name="signup_or_login" class="form-control" value="Log In" id="login" required > Log In
                                    </div>
                                </div>
                        </div>

                        <br>
                        <div id="organizer_success"></div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button name="submit" value="submit" data-toggle="modal" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-log-in">&nbsp; </span> Go</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- popup participant script-->
<div class="portfolio-modal modal fade" id="participant" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <h2>Participant</h2>
                        <hr class="star-primary">
                        <!--<img src="assets/signup.png" heigth='100px' width='500px' class="img-responsive img-centered" alt="">-->

                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2">
                                <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                                <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                                <form action = "Participant/participant_choice.php" method = "post">
                                    <div class="row control-group">
                                        <div class="form-group col-xs-12 floating-label-form-group controls">
                                            <label>I want to</label>
                                            <div class=col-xs-6 floating-label-form-group controls">
                                            <input type="radio" name="signup_or_login" class="form-control" value="Sign Up" id="signup" required > Sign Up
                                        </div>
                                        <div class=col-xs-6 floating-label-form-group controls">
                                        <input type="radio" name="signup_or_login" class="form-control" value="Log In" id="login" required > Log In
                                    </div>
                                </div>
                        </div>

                        <br>
                        <div id="participant_success"></div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button name="submit" value="submit" data-toggle="modal" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-log-in">&nbsp; </span> Go</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
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

</html>
