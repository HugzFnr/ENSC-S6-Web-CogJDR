
            <footer class="footer sticky-bottom">
                <div class="container text-center">
                    <hr>
                    <p class="text-center"><b>Cog' JDR</b><em> &mdash; un projet initié par Célestin Grenier et Hugo Fournier dans le cadre du projet web S6 à l'ENSC.</em></p>
                </div>
            </footer>

        </div><!-- page -->

        <?php
            if (!empty($__liste_equipes)) { ?>
                    </div>
                    <!-- /#page-content-wrapper -->
                </div>
                <!-- FIN liste des équipes -->

                <script>
                    $("#menu-toggle").click(function(e) {
                        e.preventDefault();
                        $("#wrapper").toggleClass("toggled");
                    });

                    
                    $(window).scroll(function() {
                        $("#sidebar-wrapper").css("padding-top", "" + $(window).scrollTop() + "px");
                    });
                </script><?php
            }
        ?>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
