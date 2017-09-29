<?php

function generatePage($body, $title="Rideshare", $transitionName) {
    $page = <<<EOPAGE

            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2 style="color:rgb(51, 51, 51);">$transitionName</h2>
                            <hr class="star-primary">
                            <!--<img src="assets/login.png" class="img-responsive img-centered" heigh= '50%' width='50%'  alt="">-->
                                                        
                             <div class="row">
                                <div class="col-lg-8 col-lg-offset-2">
                                    <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                                    <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                                    $body
                                
								</div>
								
							
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>


EOPAGE;

    return $page;
}

?>