<!DOCTYPE html>
<html lang="en">
        <head>
			<!--- Bootstrap CSS -->
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
			
		
			<link rel="stylesheet" type="text/css" href="css/style.css">
            <title>Project VI Homepage</title>
			<meta name="description" content="This is the design page"/>
            <meta name="robots" content="noindex nofollow" />
            <meta http-eqiv="author" content="Matt H" />
            <meta http-equiv="pragma" content="no-cache" />
        </head>
        <body onload="KeepTime()">
			<!-- Bootstrap JavaScript -->
			<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

		
			<script>
				function KeepTime() {
					var today = new Date();
					var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
					var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
					var dateTime = time+' '+date;
					console.log(dateTime);
					document.getElementById("datetime").innerHTML = dateTime;
				}
			</script>
            
			<header>
				<p class="headertitle">Project VI Homepage</p>
				Welcome to the homepage for Project VI, created by Jeff Scherer, Kevin MacIntosh, Matt Hengeveld, and Victor Palczewski.
			</header>
			
			<div class="links">
			
				<a href="about.html"><b>About</b></a>
				<a href="control.html"><b>Operate Elevator</b></a>
				<a href="gantt.html"><b>Project Schedule</b></a>
				<a href="designs.html"><b>Button Designs</b></a>
				<a href="logic.html"><b>Elevator Logic</b></a>
				<a href="proj_details.html"><b>Project Details</b></a>
				<a href="login.html"><b>Login Page</b></a>
				<input id="rqst_bttn" onclick="window.location.href = 'request_access.html';" onmouseover="this.src='images/RequestAccess_bttn_over.png'" onmouseout="this.src='images/RequestAccess_bttn_up.png'" type="image" id="image" alt="Request Access" src="images/RequestAccess_bttn_up.png">
				
			</div>
			
			<footer>
				<p id="datetime"></p>
				This page is part of Engineering Project VI. &copy Jeff S 2020
			</footer>
			
        </body>
</html>