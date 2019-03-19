<?php require_once "./inclus/session.php" ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>CogJDR<?=isset($sous_titre) ? " - $sous_titre" : " !"?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" media="screen" href="./css/global.css">
	<link rel="stylesheet" type="text/css" media="screen" href="./css/discussion.css">

	<!--script src="http://code.jquery.com/jquery-latest.min.js"></script-->
</head>

<body>
	<div class="container">

		<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">
			<div class="container">
				<a class="navbar-brand" href="#">Cog' JDR</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
				aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- listes de JRD -->
					<ul class="navbar-nav mr-auto">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Parties jouées
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<?php
									if (empty($_SESSION['liste_donnees_jdr'])) { ?>
										<a class="dropdown-item" href="#">Pas de parties en cours</a><?php
									} else foreach ($_SESSION['liste_donnees_jdr'] as $v) { ?>
										<a class="dropdown-item" href="./jdr.php&id=<?=$v['id_jdr']?>"><?=$v['titre_jdr']?></a><?php
									}
								?>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Rejoindre une partie</a>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Parties masterisées
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<?php
									if (empty($_SESSION['liste_donnees_jdr'])) { ?>
										<a class="dropdown-item" href="#">Pas de parties en cours</a><?php
									} else foreach ($_SESSION['liste_donnees_jdr'] as $v) { ?>
										<a class="dropdown-item" href="./jdr.php&id=<?=$v['id_jdr']?>"><?=$v['titre_jdr']?></a><?php
									}
								?>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Créer une partie</a>
							</div>
						</li>
					</ul>

					<!-- horloge -->
					<div class="cercle">
						<p id="heure">Bonjour!</p>
						<script type="text/javascript">
							setInterval(() => document.getElementById('heure').innerHTML = new Date().toLocaleTimeString(), 1000);
						</script>
					</div>

					<!-- compte -->
					<?php 
						if (isset($_SESSION['id'])) { ?>
							<p class="text-success text-center">Bienvenue, <a class="nav-link" href="./compte.php&id=<?=$_SESSION['id']?>"><?=$_SESSION['email']?></a></p>
							<img class="img" src="<?=$_SESSION['img']?>" alt="Oof"><?php
						} else { ?>
							<form action="./compte.php" method="get">
								<input type="hidden" name="redirection_echec" value="./#">
								<input type="hidden" name="redirection_succes" value="./#">
								<table>
									<tr>
										<td><input type="text" name="email" class="form-control" id="debut_email" placeholder="E-mail"></td>
										<td><button type="submit" name="action" value="connecter" class="btn btn-primary btn-block">Connection</button></td>
									</tr>
									<tr>
										<td><input type="password" name="mdp" class="form-control" id="debut_mdp" placeholder="Mot de passe"></td>
										<td><button type="submit" name="action" value="creer" formaction="./inscription.php" class="btn btn-primary btn-block">Créer le compte</button></td>
									</tr>
								</table>
							</form><?php
						}
					?>
				</div>
			</div>
		</nav>

		<?php
			if (isset($_SESSION['erreur'])) { ?>
				<h2><?=$_SESSION['erreur']?></h2>
				<hr><?php
				unset($_SESSION['erreur']);
			}
		?>
