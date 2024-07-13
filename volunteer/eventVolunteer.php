<!--
Hana Hussain
09/29/23
eventVolunteer.php
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
    <title>Unity Library (Volunteer for Event)</title>

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
		// only keeping booksList for project 1 purposes where we don't have databases
		session_start();
		$eventList = array();
		if(isset($_SESSION['eventList'])) {
			$eventList = $_SESSION['eventList'];
		}

        $event = "";
		$hours = 0;

		$hoursOK = false;

		// Initialize variable for error messages
        $message = "";

        // Check to see if the register button is pressed and sends a post request
        if(isset($_POST['eventVolunteer'])){

			// Saving book selection
			if(isset($_POST['event'])) {
				$event = $_POST['event'];
			}

			// Checking to make sure hours has a value
			if(!empty($_POST['hours'])) {
				$hours = htmlspecialchars($_POST['hours']);
                $hoursOK = true;
			} else {
				$message = $message . "<p class=\"error-message\">Please enter amount of hours you want to volunteer for this event (More than 0)<br>";
				$hoursOK = false;
			} // end hours check

			if($hoursOK){
            	session_start();
				$_SESSION['event'] = $event;
				$_SESSION['hours'] = $hours;
				header('Location: eventVolunteerResults.php');
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
                                                              
            <form action="eventVolunteer.php" method="post">
		    <!-- Creating input boxes based on web template styling -->
            <section class="service">
				<div class="container">
					<div class="service-details">
                        <div style="width:380px" class="input-box">
                            <h2 class="user-registration">Volunteer for Event</h2>
							<?php
								print $message;
								$message = "";	
							?>
							    <div>
									<label for="dropdown" style="margin-left:20px">Select event to volunteer for:</label>
									<select id="dropdown" name="event" style="width: 200px; padding: 5px; border-radius: 10px; margin-left: 20px;" required>
										<option value="" disabled selected>Event Selection*</option>
										<?php
                                            // Loop through the $booksList array and create options
                                            foreach ($eventList as $eventie) {
                                                $value = htmlspecialchars($eventie); // Sanitize the book name if needed
                                                $selected = ($event == $eventie) ? 'selected' : ''; // Check if it's the selected option
                                                print '<option value="' . $value . '" ' . $selected . '>' . $eventie . '</option>';
                                            }
                                        ?>
									</select>
									<div class="form-group">
                                    	<input type="text" pattern="^\d+(\.\d{1,2})?$" style="border-radius:10px; padding: 22px 10px; margin-top: 15px; margin-left:19px; width: 90%;" class="form-control" placeholder="Number of Hours to Volunteer at Event (0.5, 1, etc)*" name="hours" <?php if ($hours > 0) print 'value="' . htmlspecialchars($hours) . '"'; ?>>
                                	</div>
								</div>
                                <button type="submit" style="margin-top: 0px; margin-left: 17px; margin-right: 15px; margin-bottom: -15px; width: 345px;" class="submit-button" value="eventVolunteer" name="eventVolunteer">Volunteer for Event</button>			
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