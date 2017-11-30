<!DOCTYPE html>
<html lang="en" dir="ltr">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="CSY">
		<meta name="keywords" content="web, news, northampton">
		<meta name="author" content="Jan Jaworski">

		<title>Northampton News - <?php echo $title ?></title>

		<!-- CSS -->
		<link rel="stylesheet" href="css/styles.min.css">

		<!-- Script -->
		<script src="js/script.js" charset="utf-8"></script>
	</head>

	<body>
		<header>
				<h1>Northampton News</h1>
		</header>

		<nav class="nav">
			<ul>
				<li><a href="index.php?title=home">Home</a></li>
				<li><a href="index.php?title=articles">Articles</a></li>
				<li>
					<a href="index.php?title=categories">Categories</a>
					<ul><?php loadCategories($database); ?></ul>
				</li>
				<li><a href="index.php?title=contact">Contact</a></li>
				<?php addLinks(); ?>
			</ul>
		</nav>

		<img src="img/banners/randombanner.php">

		<main>
			<?php echo $content; ?>
		</main>

		<footer>
			&copy; Northampton News 2017
		</footer>
	</body>

</html>
