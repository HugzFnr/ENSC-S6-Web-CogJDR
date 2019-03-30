<script>
    $(document).ready(function () {
        // fonction utilisée pour défiler la liste des message tout en bas
        scrollDown = function(elm) {
            //elm.animate({ scrollTop: elm.prop("scrollHeight") - elm.prop("clientHeight")}, 1000);
            elm.scrollTop(elm.prop("scrollHeight") - elm.prop("clientHeight"));
        }

        var elm = $("#discussion");
        elm.load("./inclus/discussion/contenu_discussion.php");
        scrollDown(elm);

        // ajout une réactualisation des messages toutes les secondes
        setInterval(function() {
                var elm = $("#discussion");
                precedent = elm[0].innerText.length;
                var shouldScroll = elm[0].scrollHeight - 10 < elm.scrollTop() + elm.innerHeight();
                elm.load("./inclus/discussion/contenu_discussion.php", function() {
                    if (shouldScroll)
                        scrollDown(elm);
                })
            }, 1000);
        $.ajaxSetup({ cache: false });
    });
</script>

<button class="btn btn-primary position-fixed" style="bottom: 0px; left: 0px;" id="cacher_discussion_hors">Montrer la discussion</button>

<div class="fixed-bottom discussion-flottant card" id="discussion_conteneur">
    <article class="card-body">
        <ul id="discussion"><?php include "./inclus/discussion/contenu_discussion.php" ?></ul>
        <form id="form_envoie_message">
            <table class="w-100">
                <tr>
                    <button type="submit" class="invisible position-absolute"></button>
                    <td><button class="btn btn-primary w-100" id="cacher_discussion_dans">Cacher</button></td>
                    <td><input type="text" class="form-control w-100" name="message_text" id="discussion_boite_message" placeholder="Entrez votre message !" autocomplete="off">
                    <input type="hidden" name="page_form" value="<?=$_SERVER['REQUEST_URI']?>"></td>
                    <td><input class="btn btn-primary w-100" type="submit" value="Envoyer"></td>
                </tr>
            </table>
        </form>
    </article>
</div>

<script>
    // attrape l'envoi du message pour ne pas réactualiser la page
    $("#form_envoie_message").submit(function(e) {
        e.preventDefault();
        if ($("#discussion_boite_message").val() != "")
            $("#discussion").load("./inclus/discussion/contenu_discussion.php", $("#form_envoie_message").serializeArray(), function() {
                    // à cause d'un bug dû au rechargement partiel, cet évenement ce détache à chaque fois...
                    $("#menu-toggle").click(function(e_) {
                        e_.preventDefault();
                        $("#wrapper").toggleClass("toggled");
                    });
                });
        // vide la zone de text
        document.getElementById("form_envoie_message").reset();
    });
    
    // utilisée pour montrer / cacher la discussion
    toggeler = function(e) {
        e.preventDefault();
        $("#discussion_conteneur").toggleClass("invisible");
    }

    $("#cacher_discussion_dans").click(toggeler);
    $("#cacher_discussion_hors").click(toggeler);
</script>
