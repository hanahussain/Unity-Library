<!--
Hana Hussain
09/29/23
staff.php
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
    <title>Unity Library (Event)</title>

    <!-- for title img -->
	<link rel="shortcut icon" type="image/icon" href="../assets/images/logo/ul 46.jpg"/>
       
    <!--font-awesome.min.css-->
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
		
	<!--linear icon css-->
	<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
		
	<!--animate.css-->
    <link rel="stylesheet" href="../assets/css/animate.css">
		
	<!--hover.css-->
    <link rel="stylesheet" href="../assets/css/hover-min.css">
		
	<!--vedio player css-->
    <link rel="stylesheet" href="../assets/css/magnific-popup.css">

	<!--owl.carousel.css-->
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
	<link href="../assets/css/owl.theme.default.min.css" rel="stylesheet"/>

    <!--bootstrap.min.css-->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
		
	<!-- bootsnav -->
	<link href="../assets/css/bootsnav.css" rel="stylesheet"/>	
        
    <!--style.css-->
    <link rel="stylesheet" href="../assets/css/style.css">
        
    <!--responsive.css-->
    <link rel="stylesheet" href="../assets/css/responsive.css">

	<!--font for navbar-->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC&display=swap" rel="stylesheet"> 


</head>

<body>
    <?php

        // Initialize variables requiring user input
        $name = $description = "";

        // Date in standard US format
        $date = "";

        // Don't want to display these numbers initially. Number attendees can be 0 but volunteers cannot
        $numberAttendees = isset($_POST['numberAttendees']) ? htmlspecialchars($_POST['numberAttendees']) : "";
        $numberVolunteers = isset($_POST['numberVolunteers']) ? htmlspecialchars($_POST['numberVolunteers']) : "";

		// Initially, none of user inputs meet requirements
		$nameOK = $descriptionOK = $dateOK = $numberAttendeesOK = $numberVolunteersOK = false;

        session_start();
        $eventList = array();
        if(isset($_SESSION['eventList'])) {
			$eventList = $_SESSION['eventList'];
			
		}

		// Initialize variable for error messages
        $message = "";

        // Check to see if the register button is pressed and sends a post request
        if(isset($_POST['addEvent'])){

			// Checking to make sure name has a value
			if(!empty($_POST['name'])) {
				$name = htmlspecialchars($_POST['name']);
                $nameOK = true;
                array_push($eventList, $name);
			} else {
				$message = $message . "<p class=\"error-message\">Please enter the event's name<br>";
				$nameOK = false;
			} // end title check

            // Checking to make sure description has a value
			if(isset($_POST['description'])) {
				$description = htmlspecialchars($_POST['description']);
                $descriptionOK = true;
			} else {
				$message = $message . "<p class=\"error-message\">Please enter the event's description<br>";
				$descriptionOK = false;
			} // end title check

            if(isset($_POST['date'])){
                $date = htmlspecialchars($_POST['date']);
            }

			// Checking to make sure numberAttendees has a value
			if(!empty($_POST['numberAttendees'])) {
				$numberAttendees = htmlspecialchars($_POST['numberAttendees']);
                $numberAttendeesOK = true;
			} else {
                if($numberAttendees == 0){
                    $numberAttendeesOK = true;
                } else {
                    $message = $message . "<p class=\"error-message\">Please enter number of members who will attend (0 or more)<br>";
                    $numberAttendeesOK = false;
                }
			} // end numberAttendees check

            // Checking to make sure numberVolunteers has a value
			if(!empty($_POST['numberVolunteers'])) {
				$numberVolunteers = htmlspecialchars($_POST['numberVolunteers']);
                if($numberVolunteers > 0){
                    $numberVolunteersOK = true;
                } else {
                    $numberVolunteersOK = false;
                    $message = $message . "<p class=\"error-message\"There must be at least one volunteer per event.<br>";
                }
			} else {
				$message = $message . "<p class=\"error-message\">Please enter number of volunteers who will attend (1 or more)<br>";
				$numberVolunteersOK = false;
			} // end numberVolunteers check
			

			// Checking to ensure all input fields are valid 
			if($nameOK && $descriptionOK && $numberAttendeesOK && $numberVolunteersOK){
				// Store information in session storage to save it
            	session_start();
            	$_SESSION['name'] = $name;
            	$_SESSION['description'] =  $description;
                $_SESSION['date'] =  $date;
				$_SESSION['numberAttendees'] = $numberAttendees;
				$_SESSION['numberVolunteers'] = $numberVolunteers;
				$_SESSION['eventList'] = $eventList;

            	if($role == "user"){
					// Redirect to member dashboard
					header('Location: ../member/member.php');
				} else {
					// Redirect to staff dashboard
					header('Location: eventResults.php');
				}
            	exit;
			}
        } // end register post
    ?>

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
							        <a class="navbar-brand" href="../index.html">
								        <img src="../assets/images/logo/ul 46.jpg" alt="logo">
							        </a>
							        <p class="unity-library">Unity Library</p>
						        </div>
					        </div><!--/.navbar-header -->

					        <!-- Collect the nav links, forms, and other content for toggling -->
					        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						        <ul class="nav navbar-nav navbar-right">
							        <li><a href="../index.html">Home</a></li>
							        <li><a href="../about.html">About</a></li>
							        <li><a href="service.html">Service</a></li>
							        <li><a href="../contact.html">Contact</a></li>
                                    <li><a href="register.php">Register</a></li>
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
                                                              
            <form action="event.php" method="post">
		    <!-- Creating input boxes based on web template styling -->
            <section class="service">
				<div class="container">
					<div class="service-details">
                        <div class="input-box">
                            <h2 class="user-registration">Add Event</h2>
                            <!-- Printing & Clearing Error Message -->
                            <?php 
				                print $message;
				                $message = "";
			                ?>
					        <div style="border-radius:10px; padding: 2px 20px" class="single-contact-box">
                                <div class="form-group">
                                    <input type="text" style="border-radius:10px; padding: 22px 10px" class="form-control" placeholder="Event Name*" name="name" value="<?php print htmlspecialchars($name);?>">
                                </div>
                                <div>
                                    <textarea id="description" name="description" rows="4" cols="0" style="border-radius:10px; padding-top: 10px; width: 100%;" class="form-control" placeholder="Event Description*" required><?php print isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="text" pattern="\d{2}/\d{2}/\d{4}" style="border-radius:10px; padding: 22px 10px; margin-top: 10px;" class="form-control" placeholder="Event Date (MM/DD/YYYY)*" name="date" value="<?php print htmlspecialchars($date);?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" pattern="^[0-9]+$" style="border-radius:10px; padding: 22px 10px; margin-top: 10px;" class="form-control" placeholder="Number of Attendees (0, 1, etc)*" name="numberAttendees" value="<?php print htmlspecialchars($numberAttendees); ?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" pattern="^[0-9]*$" style="border-radius:10px; padding: 22px 10px; margin-top: 10px;" class="form-control" placeholder="Number of Volunteers (1, 2, etc)*" name="numberVolunteers" value="<?php print htmlspecialchars($numberVolunteers); ?>">
                                </div>
                                <button type="submit" class="submit-button" value="addEvent" name="addEvent">Add Event</button>			
                            </div>
                        </div> <!-- input container box-->
						<div class="container"> <!-- new input container -->
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
										<a href="../index.html">
											<img src="../assets/images/logo/ul 46.jpg" alt="logo" />
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
										<li><a href="../index.html" >Home</a></li>
										<li><a href="../about.html">About</a></li>
										<li><a href="../services.html">Service</a></li>
										<li><a href="../contact.html">Contact us</a></li> 
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

		<script src="../assets/js/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        
        <!--modernizr.min.js-->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
		
		
		<!--bootstrap.min.js-->
        <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
		
		<!-- bootsnav js -->
		<script src="../assets/js/bootsnav.js"></script>
		
		<!-- for manu -->
		<script src="../assets/js/jquery.hc-sticky.min.js" type="text/javascript"></script>

		
		<!-- vedio player js -->
		<script src="../assets/js/jquery.magnific-popup.min.js"></script>


		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

        <!--owl.carousel.js-->
        <script type="text/javascript" src="../assets/js/owl.carousel.min.js"></script>
		
		<!-- counter js -->
		<script src="../assets/js/jquery.counterup.min.js"></script>
		<script src="../assets/js/waypoints.min.js"></script>
		
        <!--Custom JS-->
        <script type="text/javascript" src="../assets/js/jak-menusearch.js"></script>
        <script type="text/javascript" src="../assets/js/custom.js"></script>
		
        </body>
    </html>