<?php
	include('php/pagesetup.php');
	
	// chart variables
	$floorReqs = [0, 0, 0];
	$floorCalls = [0, 0, 0];
	$callsathour = [0, 0, 0, 0, 0, 0];
	$fifo_total = 0;
	$fifoCount = [0, 0, 0, 0, 0];
	
	try {
		$db = new PDO(
			'mysql:host=127.0.0.1;port=3306;dbname=elevator',     //Data source name
			'webuser',                                                 //Username
			'12345678'                                                      //Password
		);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "connection successful";
	} catch(PDOException $e) {
		//echo "Connection failed: " . $e->getMessage();
	}

	//Return arrays with keys that are the name of the fields
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	$query = "SELECT COUNT(IF(requestedFloor = 1, 1, NULL)) 'floor1', COUNT(IF(requestedFloor = 2, 1, NULL)) 'floor2', COUNT(IF(requestedFloor = 3, 1, NULL)) 'floor3' FROM elevatorInfo;";
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	$floorReqs[0] = $result[0]['floor1'];
	$floorReqs[1] = $result[0]['floor2'];
	$floorReqs[2] = $result[0]['floor3'];
	
	$query = "SELECT COUNT(IF(calledFloor = 1, 1, NULL)) 'floor1', COUNT(IF(calledFloor = 2, 1, NULL)) 'floor2', COUNT(IF(calledFloor = 3, 1, NULL)) 'floor3' FROM elevatorInfo;";
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	$floorCalls[0] = $result[0]['floor1'];
	$floorCalls[1] = $result[0]['floor2'];
	$floorCalls[2] = $result[0]['floor3'];
	
	$query = "SELECT COUNT(IF(status = 0, 1, NULL)) 'fifo0', COUNT(IF(status = 1, 1, NULL)) 'fifo1', COUNT(IF(status = 2, 1, NULL)) 'fifo2', COUNT(IF(status = 3, 1, NULL)) 'fifo3', COUNT(IF(status = 4, 1, NULL)) 'fifo4', COUNT(IF(status < 4, 1, NULL)) 'total' FROM elevatorInfo;";
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	$fifoCount[0] = $result[0]['fifo0'] + 1;
	$fifoCount[1] = $result[0]['fifo1'] + 1;
	$fifoCount[2] = $result[0]['fifo2'] + 1;
	$fifoCount[3] = $result[0]['fifo3'] + 1;
	$fifoCount[4] = $result[0]['fifo4'] + 1;
	$fifo_total =  $result[0]['total'] + 1;

	for ($i = 0; $i < 6; $i++) {
		$query = "SELECT COUNT(IF(time > DATE_SUB(NOW(), INTERVAL ". ($i + 1) ." HOUR) AND time < DATE_SUB(NOW(), INTERVAL ". $i ." HOUR), 1, NULL)) 'count' FROM elevatorInfo;";
		$statement = $db->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		
		$callsathour[$i] = $result[0]['count'];
	}
		
?>
<!DOCTYPE html>
<html lang="en">
        <head>

			<link rel="stylesheet" type="text/css" href="css/style.css">
			<link rel="stylesheet" type="text/css" href="css/userheader.css">
			
            <title>Elevator Control</title>
			<meta name="description" content="This is the design page"/>
            <meta name="robots" content="noindex nofollow" />
            <meta http-eqiv="author" content="Matt H" />
            <meta http-equiv="pragma" content="no-cache" />

			<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

        </head>
        <body>

			<div id="userheader">
			
				<?php
					
					if ($_SESSION["status"] == 'active') {
						echo '<div id="userheaderbttn"><a href="php/wipesession.php">LOGOUT</a></div>';
						echo '<div id="userheadername">';
						echo $_SESSION['username'];
						echo '</div>';
						if ($_SESSION["admin"]) {
							echo '<div id="userheaderadmin">ADMIN</div>';
						}
					} else {
						echo '<div id="userheaderbttn"><a href="login.php">LOGIN</a></div>';
					}						
				?>
				
			</div>
            
			<header>
				<p class="headertitle">STATS</p>
			</header>
			
			<nav>
				<a class="navbttn" href="index.php">HOME</a>
				<a class="navbttn" href="about.php">ABOUT</a>
				<a class="navbttn" href="control.php">ELEVATOR CONTROL</a>
			</nav>
			
			<main>
				
				<div class="chartscontainer">
					
					<div class="chart">
						<div class="charttitle">Floor Requests (All Time)</div>
						<canvas id="floorreqpiechart"></canvas>
					</div>
					
					
					<div class="chart">
						<div class="charttitle">Floor Calls (All Time)</div>
						<canvas id="floorcallpiechart"></canvas>
					</div>
					
					
					<div class="chart">
						<div class="charttitle">Calls in the Past 6 Hours</div>
						<canvas id="floorcathour"></canvas>
					</div>
					
					<div class="chart">
						<div class="charttitle">Elevator Queue Length (%)</div>
						<canvas id="fifoper"></canvas>
					</div>
				</div>
				
            </main>
			
			<footer>
				This page is part of Engineering Project VI. &copy Victor P, Matt H 2020<?php //echo 'test' ?>
			</footer>
			
			<script>
			
				var ctx1 = document.getElementById('floorreqpiechart');	
				var ctx2 = document.getElementById('floorcallpiechart');	
				var ctx3 = document.getElementById('floorcathour');
				var ctx4 = document.getElementById('fifoper');

				var myFloorRequestChart = new Chart(ctx1, {
					type: 'doughnut',
					data: {
						labels: ['Floor 1', 'Floor 2', 'Floor 3'],
						datasets: [{
							label: 'Floor requests',
							data: [<?php echo $floorReqs[0] . "," . $floorReqs[1] . "," . $floorReqs[2] ?>],
							backgroundColor: [
								'rgba(30,150,255, 0.5)',
								'rgba(53, 105, 184, 0.5)',
								'rgba(74, 187, 232, 0.5)'
							],
							borderColor: [
								'rgba(30,150,255, 1)',
								'rgba(53, 105, 184, 1)',
								'rgba(74, 187, 232, 1)'
							],
							borderWidth: 1
						}]
					},
					options:  {
						legend: {
							display: true,
							position: 'bottom'
						}
					}
				});		

				var myFloorRCallChart = new Chart(ctx2, {
					type: 'doughnut',
					data: {
						labels: ['Floor 1', 'Floor 2', 'Floor 3'],
						datasets: [{
							label: 'Floor calls',
							data: [<?php echo $floorCalls[0] . "," . $floorCalls[1] . "," . $floorCalls[2] ?>],
							backgroundColor: [
								'rgba(30,150,255, 0.5)',
								'rgba(53, 105, 184, 0.5)',
								'rgba(74, 187, 232, 0.5)'
							],
							borderColor: [
								'rgba(30,150,255, 1)',
								'rgba(53, 105, 184, 1)',
								'rgba(74, 187, 232, 1)'
							],
							borderWidth: 1
						}]
					},
					options:  {
						legend: {
							display: true,
							position: 'bottom'
						}
					}
				});

				var myBarChart = new Chart(ctx3, {
					type: 'bar',
					data: {
						labels: ['5-6 hours ago', '4-5 hours ago', '3-4 hours ago', '2-3 hours ago', '1-2 hours ago', '<1 hours ago'],
						datasets: [{
							label: 'Number of calls',
							data: [<?php echo $callsathour[5] . "," . $callsathour[4] . "," . $callsathour[3] . "," . $callsathour[2] . "," . $callsathour[1] . "," . $callsathour[0] ?>],
							backgroundColor: [
								'rgba(30,150,255, 0.5)',
								'rgba(30,150,255, 0.5)',
								'rgba(30,150,255, 0.5)',
								'rgba(30,150,255, 0.5)',
								'rgba(30,150,255, 0.5)',
								'rgba(30,150,255, 0.5)'
							],
							borderColor: [
								'rgba(30,150,255, 1)',
								'rgba(30,150,255, 1)',
								'rgba(30,150,255, 1)',
								'rgba(30,150,255, 1)',
								'rgba(30,150,255, 1)',
								'rgba(30,150,255, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						legend: {
							display: false,
						},
						scales: {
						  xAxes: [{
							display: true,
							gridLines: {
							  display: true,
							  color: 'rgba(80,80,80,1)'
							}
						  }],
						  yAxes: [{
							display: true,
							gridLines: {
							  display: true,
							  color: 'rgba(80,80,80,1)'
							}
						  }]
						}
					}
				});			

				var myBarChart2 = new Chart(ctx4, {
					type: 'bar',
					data: {
						labels: ['0 Queued', '1 Queued', '2 Queued', '3 Queued', '4 Queued'],
						datasets: [{
							label: '% of calls',
							data: [<?php echo round($fifoCount[0]*100/$fifo_total, 2) . "," . round($fifoCount[1]*100/$fifo_total, 2) . "," . round($fifoCount[2]*100/$fifo_total, 2) . "," . round($fifoCount[3]*100/$fifo_total, 2) . "," . round($fifoCount[4]*100/$fifo_total, 2) ?>],
							backgroundColor: [
								'rgba(30,150,255, 0.5)',
								'rgba(30,150,255, 0.5)',
								'rgba(30,150,255, 0.5)',
								'rgba(30,150,255, 0.5)',
								'rgba(30,150,255, 0.5)',
								'rgba(30,150,255, 0.5)'
							],
							borderColor: [
								'rgba(30,150,255, 1)',
								'rgba(30,150,255, 1)',
								'rgba(30,150,255, 1)',
								'rgba(30,150,255, 1)',
								'rgba(30,150,255, 1)',
								'rgba(30,150,255, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						legend: {
							display: false,
						},
						scales: {
						  xAxes: [{
							display: true,
							gridLines: {
							  display: true,
							  color: 'rgba(80,80,80,1)'
							}
						  }],
						  yAxes: [{
							display: true,
							gridLines: {
							  display: true,
							  color: 'rgba(80,80,80,1)'
							}
						  }]
						}
					}
				});							
			  
				//window.onload = websock_init(websock);
			</script>
        </body>
</html>