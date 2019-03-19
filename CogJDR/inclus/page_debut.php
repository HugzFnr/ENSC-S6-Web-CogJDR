<?php require_once "./inclus/session.php" ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>CogJDR<?=isset($sous_titre) ? " - $sous_titre" : " !"?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
	 crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" media="screen" href="./css/discussion.css">

	<!--script src="http://code.jquery.com/jquery-latest.min.js"></script-->
</head>

<body>
	<div class="container">

		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="#">Cog' JDR</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
			 aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Parties jouées
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="#">Partie 0</a>
							<a class="dropdown-item" href="#">Partie 1</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Rejoindre une partie</a>
						</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Parties masterisées
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="#">Partie 0</a>
							<a class="dropdown-item" href="#">Partie 1</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Créer une partie</a>
						</div>
					</li>
				</ul>
				<form class="form-inline my-2 my-lg-0">
					<input class="form-control mr-sm-2" type="search" placeholder="Code d'invitation" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rejoindre</button>
				</form>
			</div>
		</nav>

		<h1>Yo!</h1>
		<hr>