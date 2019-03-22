<?php require_once "./inclus/session.php" ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Cog' JDR<?=isset($sous_titre) ? " - $sous_titre" : " !"?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	
	<!--<link rel="stylesheet" type="text/css" media="screen" href="./css/global.css">
	<link rel="stylesheet" type="text/css" media="screen" href="./css/discussion.css">
	<link rel="stylesheet" type="text/css" media="screen" href="./css/jdr.css">-->
	<?php
		$css_necessaires[] = "global";
		foreach ($css_necessaires as $v) { ?>
			<link rel="stylesheet" type="text/css" media="screen" href="./css/<?=$v?>.css"><?php
		}
	?>

	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>

<body>
	<div class="">

		<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
			<div class="container">
				<a class="navbar-brand" href="./#">Cog' JDR</a>

				<!-- horloge -->
				<div class="cercle">
					<p id="heure">Bonjour!</p>
					<script type="text/javascript">
						setInterval(() => document.getElementById('heure').innerHTML = new Date().toLocaleTimeString(), 1000);
					</script>
				</div>

				<div class="navbar-nav mr-auto"></div>

				<!-- boutton de collapse -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<!-- ens des élm qui collapse -->
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<?php if (isset($_SESSION['id'])) { ?>
						<!-- les 2 listes de JRD -->
						<ul class="navbar-nav mr-auto">
							<?php
								$liste_jouees = [];
								$liste_masterisees = [];

								if (!empty($_SESSION['liste_donnees_jdr']))
									foreach ($_SESSION['liste_donnees_jdr'] as $v) {
										if ($v['est_mj'])
											$liste_masterisees[] = $v;
										else
											$liste_jouees[] = $v;
									}
							?>
							<!-- liste des jouées -->
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown_jouees" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Parties jouées
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown_jouees">
									<?php
										if (empty($liste_jouees)) { ?>
											<a class="dropdown-item" href="#Rejoindre"><em>Pas de parties en cours</em></a><?php
										} else foreach ($liste_jouees as $v) { ?>
											<a class="dropdown-item" href="./jdr.php?id=<?=$v['id_jdr']?>"><?=$v['titre_jdr']?></a><?php
										}
									?>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">Rejoindre une partie</a>
								</div>
							</li>
							<!-- liste des masterisées -->
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown_masterisees" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Parties masterisées
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown_masterisees">
									<?php
										if (empty($liste_masterisees)) { ?>
											<a class="dropdown-item" href="#Creer"><em>Pas de parties en cours</em></a><?php
										} else foreach ($liste_masterisees as $v) { ?>
											<a class="dropdown-item" href="./jdr.php?id=<?=$v['id_jdr']?>"><?=$v['titre_jdr']?></a><?php
										}
									?>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="./creer.php"> Créer une partie</a>
								</div>
							</li>
						</ul>
						<!-- FIN les 2 listes de JRD -->
					<?php } else { ?>
						<ul class="navbar-nav mr-auto">
							<li class="nav-item">
								<a class="nav-link disabled" href="#">Connectez-vous pour rejoindre des jeux rigolos !</a>
							</li>
						</ul>
					<?php } ?>

					<!-- gestion compte -->
					<table class="float-right">
						<tr>
							<?php 
								if (isset($_SESSION['id'])) { ?>
									<td><p class="text-success text-center">Bienvenue, <a class="nav-link" href="./compte.php?id=<?=$_SESSION['id']?>"><?=$_SESSION['email']?></a></p></td>
									<td>
										<div class="dropdown">
											<a class="dropdown-toggle" href="#" id="navbarDropdown_compte" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<img class="img" src="<?=$_SESSION['img']?>" alt="Oof">
											</a>
											<div class="dropdown-menu" aria-labelledby="navbarDropdown_compte">
												<a class="dropdown-item" href="./compte.php?action=deconnecter&redirection_succes=<?=rawurlencode($_SERVER['REQUEST_URI'])?>">Se Déconnecter</a>
											</div>
										</div>
									</td><?php
								} else { ?>
									<td>
										<form action="./compte.php" method="get">
											<input type="hidden" name="redirection_echec" value="./#">
											<input type="hidden" name="redirection_succes" value="./#">
											<table class="w-100">
												<tr>
													<td><input type="text" name="email" class="form-control" id="debut_email" placeholder="E-mail"></td>
													<td><button type="submit" name="action" value="connecter" class="btn btn-primary btn-block" autofocus>Connexion</button></td>
												</tr>
												<tr>
													<td><input type="password" name="mdp" class="form-control" id="debut_mdp" placeholder="Mot de passe"></td>
													<td><button type="submit" name="action" value="creer" formaction="./inscription.php" class="btn btn-primary btn-block">Créer le compte</button></td>
												</tr>
											</table>
										</form>
									</td><?php
								}
							?>
						</tr>
					</table>
					<!-- FIN gestion compte -->
				</div>
				<!-- FIN ens des élm qui collapse -->
			</div>
		</nav>

		<?php
			if (isset($_SESSION['erreur'])) { ?>
				<h2><?=$_SESSION['erreur']?></h2>
				<hr><?php
				unset($_SESSION['erreur']);
			}
		?>
