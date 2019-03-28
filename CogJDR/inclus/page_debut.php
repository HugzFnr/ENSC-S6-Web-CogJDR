<?php
	require_once "./inclus/session.php";

	/**
	 * Variables qui peuvent être précisées avant l'inclusion de ce fichier :
	 *
	 * 	- $__sous_titre
	 * 		est ajouter à la suite du titre de l'onglet
	 *
	 * 	- $__css_necessaires
	 * 		liste de nom de fichier css (sans l'extension) à inclure dans la page
	 *
	 * 	- $__liste_equipes
	 * 		affiche, si précisée, la liste des équipes dans la sidenav en `<a $v['href']>$v['text']</a>`
	 */
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Cog' JDR<?=isset($__sous_titre) ? " &mdash; $__sous_titre" : " !"?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" media="screen" href="./css/global.css">
	<!--<link rel="stylesheet" type="text/css" media="screen" href="./css/discussion.css">
	<link rel="stylesheet" type="text/css" media="screen" href="./css/jdr.css">-->
	<?php
		if (!empty($__css_necessaires)) foreach ($__css_necessaires as $v) { ?>
			<link rel="stylesheet" type="text/css" media="screen" href="./css/<?=$v?>.css"><?php
		}
	?>

	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>

<body>
	<?php
		if (!empty($__liste_equipes)) { ?>
			<!-- liste des équipes -->
			<div class="d-flex" id="wrapper">
				<!-- Sidebar -->
				<div class="bg-light" id="sidebar-wrapper">
					<div class="sidebar-heading">Liste des équipes</div>
					<div class="list-group list-group-flush">
						<?php
							foreach ($__liste_equipes as $v) { ?>
								<a href="<?=$v['href']?>" class="id_discussion list-group-item list-group-item-action <?=$v['activ'] ? "active" : "bg-light"?>"><?=$v['text']?></a><?php
							}
						?>
					</div>
				</div>
				<script>
					$(".id_discussion").click( function(e) {
						if (e.target.getAttribute("href") != "./equipe.php") {
							e.preventDefault();
							$("#discussion").load(
								"./inclus/discussion/contenu_discussion.php",
								{ change_id_equipe: e.target.getAttribute("href") },
								() => scrollDown($("#discussion"))
							);
							document.getElementById("form_envoie_message").reset();

							$(".id_discussion").addClass("bg-light");
							$(".id_discussion").removeClass("active");
							e.target.classList.add("active");
							e.target.classList.remove("bg-light");
						}
					});
				</script>
				<!-- /#sidebar-wrapper -->

				<!-- Page Content -->
				<div id="page-content-wrapper"><?php
		}
	?>

	<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
		<div class="container">
			<!-- boutton de collapse sidenav -->
			<?php
				if (!empty($__liste_equipes)) { ?>
					<button class="navbar-toggler" type="button" id="menu-toggle">
						<span class="navbar-toggler-icon"></span>
					</button><?php
				}
			?>

			<a class="navbar-brand" href="./#"><?php if (!empty($__liste_equipes)) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>Cog' JDR</a>

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
										<a class="dropdown-item" href="./jdr.php"><em>Pas de parties en cours</em></a><?php
									} else foreach ($liste_jouees as $v) { ?>
										<a class="dropdown-item" href="./jdr.php?id=<?=$v['id_jdr']?>"><?=$v['titre_jdr']?></a><?php
									}
								?>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="./jdr.php">Rejoindre une partie</a>
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
										<a class="dropdown-item" href="./creer.php"><em>Pas de parties en cours</em></a><?php
									} else foreach ($liste_masterisees as $v) { ?>
										<a class="dropdown-item" href="./jdr.php?id=<?=$v['id_jdr']?>"><?=$v['titre_jdr']?></a><?php
									}
								?>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="./creer.php">Créer une partie</a>
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
											<img class="img" src="./images/compte/<?=$_SESSION['img']?>" alt="Oof">
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
												<td><button type="submit" name="action" value="creer" formaction="./" class="btn btn-primary btn-block">Créer le compte</button></td>
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

	<div class="container-fluid page">
		<?php
			if (isset($_SESSION['erreur'])) { ?>
				<h2><?=$_SESSION['erreur']?></h2>
				<hr><?php
				unset($_SESSION['erreur']);
			}
		?>
