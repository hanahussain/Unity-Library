<!--
Hana Hussain
09/26/23
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
    <title>Unity Library (Book)</title>

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
        $title = $author = $genre = $ageRange = $tags = ""; //genre & ageRange

        $numberCopies = 0;

		// Initializing arrays. tagsList has all the tags for this book, while booksList tracks all the books we've made,
		// just until we get databases set up
		$tagsList = [];

		// only keeping booksList for project 1 purposes where we don't have databases
		session_start();
		$booksList = array();
		if(isset($_SESSION['booksList'])) {
			$booksList = $_SESSION['booksList'];
		}
		

		// Initially, none of user inputs meet requirements
		$titleOK = $authorOK = $genreOK = $tagsOK = $numberCopiesOK = false;

		// Initialize variable for error messages
        $message = "";

        // Check to see if the register button is pressed and sends a post request
        if(isset($_POST['addBook'])){

			// Checking to make sure title has a value
			if(!empty($_POST['title'])) {
				$title = htmlspecialchars($_POST['title']);
                $titleOK = true;
				// Appending this book title to the end of booksList
				array_push($booksList, $title);
				
			} else {
				$message = $message . "<p class=\"error-message\">Please enter the book's title<br>";
				$titleOK = false;
			} // end title check

			// Checking to make sure author has a value
			if(!empty($_POST['author'])) {
				$author = htmlspecialchars($_POST['author']);
                $authorOK = true;
			} else {
				$message = $message . "<p class=\"error-message\">Please enter the book's author</p>";
				$authorOK = false;
			} // end author check

			// Saving ageRange selection
			if(isset($_POST['ageRange'])) {
				$ageRange = $_POST['ageRange'];
				$_SESSION['ageRange'] = $ageRange;
			}

			// Checking to make sure numberCopies has a value
			if(!empty($_POST['numberCopies'])) {
				$numberCopies = htmlspecialchars($_POST['numberCopies']);
                $numberCopiesOK = true;
			} else {
				$message = $message . "<p class=\"error-message\">Please enter amount of book copies in stock (1 or more)<br>";
				$numberCopiesOK = false;
			} // end numberCopies check

			// Saving genre selection
			if(isset($_POST['genre'])) {
				$genre = $_POST['genre'];
				$_SESSION['genre'] = $genre;
			}

			if (!empty($_POST['tags'])) {
				$tags = htmlspecialchars($_POST['tags']);
				// Regular expression to match comma-separated tags of one word each
				$tagPattern = '/^[A-Za-z0-9]+(, [A-Za-z0-9]+)*$/';
				if (preg_match($tagPattern, $tags)) {
					// Setting the array appropriately with comma & space delimited tags
					$tagsList = explode(', ', $tags);
					$tagsOK = true;
				} else {
					$message = $message . "<p class=\"error-message\">Please enter the tags in list format: Item1, Item2, Etc<br>";
					$tagsOK = false;
				}
			} else {
				$message = $message . "<p class=\"error-message\">Please enter at least one tag<br>";
				$tagsOK = false;
			}
			

			// Checking to ensure all input fields are valid 
			if($titleOK && $authorOK && $numberCopiesOK && $tagsOK){
				// Store information in session storage to save it
            	session_start();
            	$_SESSION['title'] = $title;
            	$_SESSION['author'] =  $author;
				$_SESSION['numberCopies'] = $numberCopies;
				$_SESSION['tagsList'] = $tagsList;
				$_SESSION['ageRange'] = $ageRange;
				$_SESSION['genre'] = $genre;
				$_SESSION['booksList'] = $booksList;
				$_SESSION['role'] = $role;
            	if($role == "user"){
					// Redirect to member dashboard
					header('Location: ../member/member.php');
				} else {
					// Redirect to staff dashboard
					header('Location: bookResults.php');
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
                                                              
            <form action="book.php" method="post">
		    <!-- Creating input boxes based on web template styling -->
            <section class="service">
				<div class="container">
					<div class="service-details">
                        <div class="input-box">
                            <h2 class="user-registration">Add Book</h2>
                            <!-- Printing & Clearing Error Message -->
                            <?php 
				                print $message;
				                $message = "";
			                ?>
					        <div style="border-radius:10px; padding: 2px 20px" class="single-contact-box">
                                <div class="form-group">
                                    <input type="text" style="border-radius:10px; padding: 22px 10px" class="form-control" placeholder="Title*" name="title" value="<?php print htmlspecialchars($title);?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" style="border-radius:10px; padding: 22px 10px" class="form-control" placeholder="Author*" name="author" value="<?php print htmlspecialchars($author);?>">
                                </div>
                                <label for="dropdown">Select the book's age range:</label>
                                <select id="dropdown" name="ageRange" style="width: 110px; padding: 5px; border-radius: 10px" required>
									<option value="" disabled selected>Age Range*</option>
                                    <option value="youth" <?php print ($ageRange == 'youth') ? 'selected' : ''; ?>>Youth</option>
                                    <option value="teen" <?php print ($ageRange == 'teen') ? 'selected' : ''; ?>>Teen</option>
                                    <option value="adult" <?php print ($ageRange == 'adult') ? 'selected' : ''; ?>>Adult</option>
                                </select>
                                <div class="form-group">
                                    <input type="text" pattern="^[0-9]*$" style="border-radius:10px; padding: 22px 10px; margin-top: 10px;" class="form-control" placeholder="Number of Copies Available (1, 2, etc)*" name="numberCopies" <?php if ($numberCopies > 0) print 'value="' . htmlspecialchars($numberCopies) . '"'; ?>>
                                </div>
								<div>
									<label for="dropdown">Select the book's genre:</label>
									<select id="dropdown" name="genre" style="width: 100px; padding: 5px; border-radius: 10px" required>
										<option value="" disabled selected>Genre*</option>
										<option value="fantasy" <?php print ($genre == 'fantasy') ? 'selected' : ''; ?>>Nonfiction</option>
										<option value="nonfiction" <?php print ($genre == 'nonfiction') ? 'selected' : ''; ?>>Fantasy</option>
										<option value="mystery" <?php print ($genre == 'mystery') ? 'selected' : ''; ?>>Mystery</option>
										<option value="romance" <?php print ($genre == 'romance') ? 'selected' : ''; ?>>Romance</option>
										<option value="comingOfAge" <?php print ($genre == 'comingOfAge') ? 'selected' : ''; ?>>Coming of Age</option>
										<option value="scienceFiction" <?php print ($genre == 'scienceFiction') ? 'selected' : ''; ?>>Science Fiction</option>
										<option value="memoir" <?php print ($genre == 'memoir') ? 'selected' : ''; ?>>Memoir</option>
										<option value="dystopian" <?php print ($genre == 'dystopian') ? 'selected' : ''; ?>>Dystopian</option>
									</select>
								</div>
                                <div class="form-group">
                                    <input type="text" style="border-radius:10px; padding: 22px 10px; margin-top: 10px;" class="form-control" placeholder="Tags (Item1, Item2, etc)*" name="tags" value="<?php print htmlspecialchars($tags);?>">
                                </div>
                                <button type="submit" class="submit-button" value="addBook" name="addBook">Add Book</button>			
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