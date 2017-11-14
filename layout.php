<!DOCTYPE html>
<html lang="en" dir="ltr">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Group project">
		<meta name="keywords" content="web">
		<meta name="author" content="Jan Jaworski">

		<title>Northampton News - <?php echo $title ?></title>

		<!-- CSS -->
		<link rel="stylesheet" href="css/styles.min.css">

		<!-- Script -->
	</head>

	<body>
		<header>
			<section>
				<h1>Northampton News</h1>
			</section>
		</header>

		<nav>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="articles.php">Latest Articles</a></li>
				<li><a href="categories.php">Select Category</a>
					<ul>
						<li><a href="#">Category 1</a></li>
						<li><a href="#">Category 2</a></li>
						<li><a href="#">Category 3</a></li>
					</ul>
				</li>
				<li><a href="contact.php">Contact us</a></li>
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
			</ul>
		</nav>

		<img src="img/banners/randombanner.php">

		<?php echo $content; ?>

		<footer>
			&copy; Northampton News 2017
		</footer>
	</body>

</html>
