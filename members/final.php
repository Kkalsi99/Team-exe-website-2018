<html lang="en" class="no-js">
	<head>
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,800,500,600' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/set2.css" />
		<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.2.0/css/font-awesome.min.css" />

	</head>
	<body>
		<div class="container">
		<center>
		<h1>Final Year - Team .EXE</h1>
		
		</center>
			
			<div class="content">
				<div class="grid">
<?php

	  include_once('../dbconnect.php');
	  $qr=mysqli_query($link,"SELECT * FROM final_year order by id asc");
      $i=0;
      while($roa = mysqli_fetch_array($qr))
      {
        $i++;
        $f=$roa['fname'];
        $l=$roa['lname'];
        $img=$roa['pic'];     
      ?>
					<figure class="effect-selena">
						<img src="<?php echo $img; ?>" alt="<?php echo $f; echo $l; ?>"/>
						<figcaption>
							<h2><?php echo "$f "; ?><span><?php echo $l; ?></span></h2>
							
						</figcaption>			
					</figure>
					<?php
							}
					?>

				</div>
			</div>
		</div>
		<script>
			[].slice.call( document.querySelectorAll('a[href="#"') ).forEach( function(el) {
				el.addEventListener( 'click', function(ev) { ev.preventDefault(); } );
			} );
		</script>
	</body>
</html>
