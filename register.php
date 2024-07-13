<!--
Hana Hussain
09/21/23
register.php
-->

<!doctype html>
<html class="no-js" lang="en">

<head>
    <!--INCLUDING CSS FROM WEB TEMPLATE-->
    <!-- META DATA -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
    <!--font-family-->
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
		
	<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
		
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
		
    <!-- TITLE OF SITE -->
    <title>Unity Library (Registration)</title>

    <!-- for title img -->
	<link rel="shortcut icon" type="image/icon" href="assets/images/logo/ul 46.jpg"/>
       
    <!--font-awesome.min.css-->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
	<!--linear icon css-->
	<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
		
	<!--animate.css-->
    <link rel="stylesheet" href="assets/css/animate.css">
		
	<!--hover.css-->
    <link rel="stylesheet" href="assets/css/hover-min.css">
		
	<!--vedio player css-->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">

	<!--owl.carousel.css-->
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
	<link href="assets/css/owl.theme.default.min.css" rel="stylesheet"/>

    <!--bootstrap.min.css-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
	<!-- bootsnav -->
	<link href="assets/css/bootsnav.css" rel="stylesheet"/>	
        
    <!--style.css-->
    <link rel="stylesheet" href="assets/css/style.css">
        
    <!--responsive.css-->
    <link rel="stylesheet" href="assets/css/responsive.css">

	<!--font for navbar-->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC&display=swap" rel="stylesheet"> 

</head>

<body>
    <?php
		require('util/password.php');

		// Initialize variable for error messages
        $message = $accessCode = $isChecked = "";

		// Initialize variables needing user input
		$first = $last = $email = $confirmEmail = $password = $confirmPassword = "";

		// Initially, none of user inputs meet requirements
		$firstOK = $lastOK = $emailOK = $confirmEmailOK = $passwordOK = $confirmPasswordOK = false;

		// Assuming majority of users are admins, say this box validation is correct by default
		$adminOK = true;

		// Default role to be a member and we can change if necessary
		$role = "member";

        // Check to see if the register button is pressed and sends a post request
        if(isset($_POST['register'])){

			// Checking to make sure first name has a value
			if(!empty($_POST['first'])) {
				$first = htmlspecialchars($_POST['first']);
                $firstOK = true;
			} else {
				$message = $message . "<p class=\"error-message\">Please enter a first name<br>";
				$firstOK = false;
			} // end first name check

			// Checking to make sure last name has a value
			if(!empty($_POST['last'])) {
				$last = htmlspecialchars($_POST['last']);
                $lastOK = true;
			} else {
				$message = $message . "<p class=\"error-message\">Please enter a last name</p>";
				$lastOK = false;
			} // end last name check

			// Checking for email requirements
			if(!empty($_POST['email']) && !empty($_POST['confirmEmail'])) {
				$email = htmlspecialchars($_POST['email']);
				$confirmEmail = htmlspecialchars($_POST['confirmEmail']);
				// Checking to ensure emails are valid emails
				$emailOK = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                $confirmEmailOK = filter_input(INPUT_POST, 'confirmEmail', FILTER_VALIDATE_EMAIL);
				if(!$emailOK || !$confirmEmailOK){
					$message = $message . "<p class=\"error-message\">Email must be in valid email format</p>";
				}
				// Checking to ensure emails are the same
				if($email == $confirmEmail){
					$emailOK = $confirmEmailOK = true;
				} else {
					$message = $message . "<p class=\"error-message\">Emails must match</p>";
				}
			} else {
				// Saving either email in case user typed in one email box but not the other
				$email = htmlspecialchars($_POST['email']);
				$confirmEmail = htmlspecialchars($_POST['confirmEmail']);

				$message = $message . "<p class=\"error-message\">Please enter email in email fields</p>";
				$emailOK = $confirmEmailOK = false;
			} // end email requirements checking

			// Checking for password requirements
			if(!empty($_POST['password']) || !empty($_POST['confirmPassword'])) {
				$password = htmlspecialchars($_POST['password']);
				$confirmPassword = htmlspecialchars($_POST['confirmPassword']);
				// Checking to ensure password is "strong" via requirements
				if(verifyPassword($password)){
                    $passwordOK = true;
                } else {
                    $message .= "<p class=\"error-message\">Password must contain 1 letter, 1 digit, and be 10 characters long.</p>";
                }
				// Checking to ensure passwords are the same
				if($password == $confirmPassword){
					$passwordOK = $confirmPasswordOK = true;
				} else {
					$message .= "<p class=\"error-message\">Passwords must match</p>";
					$passwordOK = $confirmPasswordOK = false;
				}
			} else {
				$message .= "<p class=\"error-message\">Please enter password in password fields</p>";
				$password = $passwordOK = false;
			} // end password requirements checking


			// Checking for admin requirments
			if(isset($_POST['adminBox'])) { // Checking if checkbox is ticked
				$isChecked = isset($_POST['adminBox']) ? 'checked' : '';
				if(!empty($_POST['accessCode'])) {
					$accessCode = htmlspecialchars($_POST['accessCode']);
					if($accessCode != "54321") {
						$adminOK = false;
						$message = $message . "<p class=\"error-message\">Please enter correct admin access code to register as staff member</p>";
					} else {
						$adminOK = true;
						$role = "staff";
					}
				} else {
					$message = $message . "<p class=\"error-message\">Please enter admin access code, or uncheck the checkbox</p>";
					$adminOK = false;
				}
			} 

			// Checking to ensure all input fields are valid 
			if($firstOK && $lastOK && $emailOK && $confirmEmailOK && $passwordOK && $confirmPasswordOK && $adminOK){
				// Store information in session storage to save it
            	session_start();
            	$_SESSION['first'] = $first;
            	$_SESSION['last'] =  $last;
				$_SESSION['email'] = $email;
				$_SESSION['role'] = $role;
            	header('Location: registrationResults.php?role='.$role);
            	exit;
			}
        } // end register post
    ?>

	<script>
		document.addEventListener('DOMContentLoaded', function() { //wrapping js code in this to ensure the html is loaded first
		// JavaScript code to show/hide content when the checkbox is checked/unchecked
		const checkbox = document.getElementById('adminBox');
		const revealedContent = document.getElementById('revealedContent');
		
		// Check is the checkbox is checked after registration button is clicked to persist showing it (in case of error message)
		if (checkbox.checked) {
      		revealedContent.style.display = 'block'; // Show the content
    	}

		checkbox.addEventListener('change', function() {
			console.log("Checkbox state changed:", checkbox.checked);
			if (checkbox.checked) {
				revealedContent.style.display = 'block'; // Show the content
		    } else {
				revealedContent.style.display = 'none';  // Hide the content
			}
			});
		});
	</script>

    <!DOCTYPE html>
        <html>
        <body>       
	        <!--menu start-->
	        <section id="menu">
		        <div class="container">
			        <div class="menubar">
				        <nav class="navbar navbar-default">
					
					        <!-- Brand and toggle get grouped for better mobile display -->
					        <div class="navbar-header">
						        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							        <span class="sr-only">Toggle navigation</span>
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span>
						        </button>
						        <div class="logoo">
							        <a class="navbar-brand" href="index.html">
								        <img src="assets/images/logo/ul 46.jpg" alt="logo">
							        </a>
							        <p class="unity-library">Unity Library</p>
						        </div>
					        </div><!--/.navbar-header -->

					        <!-- Collect the nav links, forms, and other content for toggling -->
					        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						        <ul class="nav navbar-nav navbar-right">
							        <li><a href="index.html">Home</a></li>
							        <li><a href="about.html">About</a></li>
							        <li><a href="service.html">Service</a></li>
							        <li><a href="contact.html">Contact</a></li>
                                    <li class="active"><a href="register.php">Register</a></li>
							        <li class="search">
								        <form action="">
									        <input type="text" name="search" placeholder="Search....">
									        <a href="#">
										        <span class="lnr lnr-magnifier"></span>
									        </a>
								        </form>
							        </li>
						        </ul><!-- / ul -->
					        </div><!-- /.navbar-collapse -->
				        </nav><!--/nav -->
			        </div><!--/.menubar -->
		        </div><!-- /.container -->

	        </section><!--/#menu-->
	        <!--menu end-->
                                                              
            <form action="register.php" method="post">
		    <!-- Creating input boxes based on web template styling -->
            <section class="service">
				<div class="container">
					<div class="service-details">
                        <div class="input-box">
                            <h2 class="user-registration">Member Registration</h2>
                            <!-- Printing & Clearing Error Message -->
                            <?php 
				                print $message;
				                $message = "";
			                ?>
					        <div style="border-radius:10px; padding: 2px 20px" class="single-contact-box">
                                <div class="form-group">
                                    <input type="text" style="border-radius:10px; padding: 22px 10px" class="form-control" placeholder="First Name*" name="first" value="<?php print htmlspecialchars($first);?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" style="border-radius:10px; padding: 22px 10px" class="form-control" placeholder="Last Name*" name="last" value="<?php print htmlspecialchars($last);?>">
                                </div>
                                <div class="email-row"> <!-- Email row -->
									<div class="form-group">
											<input type="email" style="border-radius:10px; padding: 22px 10px; margin-right: 80px" class="form-control" placeholder="Email*" id="email-input" name="email" value="<?php print htmlspecialchars($email); ?>">
									</div><!--/.form-group-->
									<div class="form-group">
										<input type="email" style="border-radius:10px; padding: 22px 10px; margin-left: 17px; margin-right: 80px" class="form-control" placeholder="Confirm Email*" id="confirm-email-input" name="confirmEmail" value="<?php print htmlspecialchars($confirmEmail); ?>">
									</div><!--/.form-group-->
								</div><!--/.row-->
                                <div class="email-row"> <!-- Password Row -->
									<div class="form-group">
											<input type="password" style="border-radius:10px; padding: 22px 10px; margin-right: 80px" class="form-control" placeholder="Password*" id="password-input" name="password" value="<?php print htmlspecialchars($password); ?>">
									</div><!--/.form-group-->
									<div class="form-group">
										<input type="password" style="border-radius:10px; padding: 22px 10px; margin-left: 17px; margin-right: 80px" class="form-control" placeholder="Confirm Password*" id="confirm-password-input" name="confirmPassword" value="<?php print htmlspecialchars($confirmPassword); ?>">
									</div><!--/.form-group-->
								</div><!--/.row-->
								<div>
									<input type="checkbox" class="admin-checkbox" id="adminBox" name="adminBox" <?= $isChecked ?>>
									<label for="adminBox" style="font-weight: 100">Staff? Click here</label>
									<div id="revealedContent" style="display: none;">
										<p style="font-size: 13px;">Enter 5 digit access code to register as a staff member:</p>
										<input type ="password" style="border-radius:10px; padding: 22px 10px; margin-bottom: 20px; margin-top: 5px; width: 50%;" class="form-control" placeholder="Access Code*" name="accessCode" value="<?php print htmlspecialchars($accessCode); ?>">
									</div>
								</div>
                                <button type="submit" class="submit-button" value="register" name="register">Register</button>			
                            </div>
							
                            
                        </div> <!-- input container box-->
                    </div> <!--Service details-->
                </div>
            </section>


		<!--hm-footer start-->
		<section class="hm-footer">
			<div class="container">
				<div class="hm-footer-details">
					<div class="row">
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="hm-footer-widget">
								<div class="hm-foot-title ">
									<div class="logo">
										<a href="index.html">
											<img src="assets/images/logo/ul 46.jpg" alt="logo" />
										</a>
									</div><!-- /.logo-->
								</div><!--/.hm-foot-title-->
								<div class="hm-foot-para">
									<p>
										Lorem ipsum dolor sit amt conetur adcing elit. Sed do eiusod tempor utslr. Ut laboris nisi ut aute irure dolor in rein velit esse.
									</p>
								</div><!--/.hm-foot-para-->
								<div class="hm-foot-icon">
									<ul>
										<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li><!--/li-->
										<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li><!--/li-->
										<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li><!--/li-->
										<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li><!--/li-->
									</ul><!--/ul-->
								</div><!--/.hm-foot-icon-->
							</div><!--/.hm-footer-widget-->
						</div><!--/.col-->
						<div class=" col-md-2 col-sm-6 col-xs-12">
							<div class="hm-footer-widget">
								<div class="hm-foot-title">
									<h4>Useful Links</h4>
								</div><!--/.hm-foot-title-->
								<div class="footer-menu ">	  
									<ul class="">
										<li><a href="index.html" >Home</a></li>
										<li><a href="about.html">About</a></li>
										<li><a href="services.html">Service</a></li>
										<li><a href="contact.html">Contact us</a></li> 
									</ul>
								</div><!-- /.footer-menu-->
							</div><!--/.hm-footer-widget-->
						</div><!--/.col-->
						<div class=" col-md-3 col-sm-6 col-xs-12">
							<div class="hm-footer-widget">
								<div class="hm-foot-title">
									<h4>from the news</h4>
								</div><!--/.hm-foot-title-->
								<div class="hm-para-news">
									<a href="blog_single.html">
										The Pros and Cons of Starting an Online Business.
									</a>
									<span>12th June 2017</span>
								</div><!--/.hm-para-news-->
								<div class="footer-line">
									<div class="border-bottom"></div>
								</div>
								<div class="hm-para-news">
									<a href="blog_single.html">
										The Pros and Cons of Starting an Online Business.
									</a>
									<span>12th June 2017</span>
								</div><!--/.hm-para-news-->
							</div><!--/.hm-footer-widget-->
						</div><!--/.col-->
						<div class=" col-md-3 col-sm-6  col-xs-12">
							<div class="hm-footer-widget">
								<div class="hm-foot-title">
									<h4> Our Newsletter</h4>
								</div><!--/.hm-foot-title-->
								<div class="hm-foot-para">
									<p class="para-news">
										Subscribe to our newsletter to get the latest News and offers..
									</p>
								</div><!--/.hm-foot-para-->
								<div class="hm-foot-email">
									<div class="foot-email-box">
										<input type="text" class="form-control" placeholder="Email Address">
									</div><!--/.foot-email-box-->
									<div class="foot-email-subscribe">
										<button type="button" >go</button>
									</div><!--/.foot-email-icon-->
								</div><!--/.hm-foot-email-->
							</div><!--/.hm-footer-widget-->
						</div><!--/.col-->
					</div><!--/.row-->
				</div><!--/.hm-footer-details-->
			</div><!--/.container-->

		</section><!--/.hm-footer-details-->
		<!--hm-footer end-->
		
		<!-- footer-copyright start -->
		<footer class="footer-copyright">
			<div class="container">
				<div class="row">
					<div class="col-sm-7">
						<div class="foot-copyright pull-left">
							<p>
								&copy; All Rights Reserved. Designed and Developed by
							 	<a href="https://www.themesine.com">ThemeSINE</a>
							</p>
						</div><!--/.foot-copyright-->
					</div><!--/.col-->
					<div class="col-sm-5">
						<div class="foot-menu pull-right
						">	  
							<ul>
								<li ><a href="#">legal</a></li>
								<li ><a href="#">sitemap</a></li>
								<li ><a href="#">privacy policy</a></li>
							</ul>
						</div><!-- /.foot-menu-->
					</div><!--/.col-->
				</div><!--/.row-->
				<div id="scroll-Top">
					<i class="fa fa-angle-double-up return-to-top" id="scroll-top" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back to Top" aria-hidden="true"></i>
				</div><!--/.scroll-Top-->
			</div><!-- /.container-->

		</footer><!-- /.footer-copyright-->
		<!-- footer-copyright end -->



		<!-- jaquery link -->

		<script src="assets/js/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        
        <!--modernizr.min.js-->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
		
		
		<!--bootstrap.min.js-->
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
		
		<!-- bootsnav js -->
		<script src="assets/js/bootsnav.js"></script>
		
		<!-- for manu -->
		<script src="assets/js/jquery.hc-sticky.min.js" type="text/javascript"></script>

		
		<!-- vedio player js -->
		<script src="assets/js/jquery.magnific-popup.min.js"></script>


		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

        <!--owl.carousel.js-->
        <script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
		
		<!-- counter js -->
		<script src="assets/js/jquery.counterup.min.js"></script>
		<script src="assets/js/waypoints.min.js"></script>
		
        <!--Custom JS-->
        <script type="text/javascript" src="assets/js/jak-menusearch.js"></script>
        <script type="text/javascript" src="assets/js/custom.js"></script>
		
        </body>
    </html>