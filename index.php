<!DOCTYPE html>
	<!--[if IE 8]> 				 
	<html class="no-js lt-ie9" lang="en" > <![endif]-->
	<!--[if gt IE 8]><!--> 
<html class="no-js" lang="en" > 
	<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>FeeMagesBasicSS</title>
	<link rel="stylesheet" href="css/todos.css" />
	<link rel="stylesheet" href="css/foundation.css" />
		
	<script src="lib/custom.modernizr.js"></script>
   	
   	<!-- load the jQuery -->
	<script src="lib/jquery.js"></script>  
</head>

<body>
 	<div class="row">
		<div class="large-12 columns">
			<h2 class="heading-main">RSS Orbit!!</h2>
		</div>
 	</div>
	
	<div class="row">
		<div class="large-8 columns">
			<div class="row">
				<div class="large-6 columns">
					<div id="myapp">
						<div class="sidebar">
							<header>
							<p>Add Subscriptions <b style="color:red"> + </b> </p>
							<p>
								<form action="index.php" method="GET">
								<input type="text" name="name" id="new-data" placeholder="Enter feed or website url here!" autofocus/>
								<input type="submit" value="Subscribe" name="submit" class="blue awesome" id="submit"/>
								</form>
							</p>
							</header>								
						</div>
					
						<div class="sidebar-urls">
							<pre><b>Feed URLS</b></pre>
					 		<section id="main">
	 			 				<label id="toggle-all"></label>
	  							<ul id="todo-list"></ul>
				 			</section>
							<footer>
							</footer>					
						</div>
					</div>
				</div>
				
						<div class="contentfeed">
							<?php
								include_once("scripts/feed.php");
								if(isset($_GET['name']) && !empty($_GET['name'])) {
									$url = $_GET['name'];	
									$location = fix_url($url);
									$html = file_get_contents($location);
									$webfile = webfile($html);
									$xmlfile = xmlfile($html);							
									echo "<b>From:</b><a href='".$location."'>".  $url ."</a><button class='orange awesome'>GET PDF</button>";	
							
									if($xmlfile){
										parsing($location);
									} elseif($webfile) {
										$feedurl = getRSSLocation($html, $location);	
										parsing($feedurl);
									}else{ 
										echo "unable to parse";
										}				
								}
							?>
					</div>	
				</div>
			</div>
		</div>

		<script src="lib/backbonejs/underscore.js"></script>
		<script src="lib/backbonejs/backbone.js"></script>
		<script src="lib/backbonejs/backbone.localStorage.js"></script>
		<!--<script src="todos.js"></script>-->		
		<script src="js/model/model.js"></script>
		<script src="js/collection/collection.js"></script>
		<script src="js/view/itemView.js"></script>
		<script src="js/view/appView.js"></script>
		<script src="js/app.js"></script>
  
<!-- Templates -->
	<script type="text/template" id="item-template">
		<div class="view">
		  <label><%- title %></label>
		  <a class="destroy"></a>
		</div>
		<input class="edit" type="text" value="<%- title %>" />
	</script>
	<script type="text/template" id="stats-template">
		<div class="todo-count">  <span><button class="blue awesome" id="clear-completed">Clear All</button></span></div>
	</script>

<!--script for zepto or jquery. its just recommended by foundation framework hence used-->
	<script>
	 	document.write('<script src=/lib/'
		+ ('__proto__' in {} ? 'zepto' : 'jquery')
		+ '.js><\/script>');
	</script>

<!--include foundationjs lib-->
	<script type="text/javascript" src="lib/foundationjs/foundation.js"></script>

<!--script for slide show foundation.orbit-->
	<script type="text/javascript" src="lib/foundationjs/foundation.orbit.js"></script>

<!--invoking the foundation script. this is main script for invoking all the .js present in the js/ of the foundation framework-->
	<script>
		$(document).foundation();
	</script>

	</body>
</html>
