<!-- liste des équipes -->
<div class="d-flex toggled" id="wrapper">
	<!-- Sidebar -->
	<div class="bg-light border-right" id="sidebar-wrapper">
		<div class="sidebar-heading">Liste des discussions</div>
		<div class="list-group list-group-flush">
            <?php
                if ($_SESSION['indice_jdr_suivi'] < 0)
                    foreach ($_SESSION['liste_donnees_jdr'] as $k => $v)
                        if ($v['id_jdr'] == $_REQUEST['id'])
                            $_SESSION['indice_jdr_suivi'] = $k;

                if ($_SESSION['indice_jdr_suivi'] < 0)
                    exit;

                if ($donnees_jdr = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']]) foreach ($donnees_jdr['liste_equipe'] as $v) { ?>
                    <a href="#TODO" class="list-group-item list-group-item-action bg-light"><?=$v['titre_equipe']?></a><?php
                }
            ?>
		</div>
	</div>
	<!-- /#sidebar-wrapper -->

	<!-- Page Content -->
	<div id="page-content-wrapper">
        <button id="menu-toggle"><span class="navbar-toggler-icon">Oof</span></button>
        <h1 class="text-center">JDR : <?=$modele['titre']?></h1>
        
        <img class="img_banniere" src="<?=$modele['img_banniere']?>" alt="Oof">

		<div class="container-fluid">
			<p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens.
				When toggled using the button below, the menu will change.</p>
			<p>Make sure to keep all page content within the
				<code>#page-content-wrapper</code>. The top navbar is optional, and just for demonstration. Just create an element with the
				<code>#menu-toggle</code> ID which will toggle the menu when clicked.</p>
		</div>
	</div>
	<!-- /#page-content-wrapper -->
</div>

<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
<!-- FIN liste des équipes -->