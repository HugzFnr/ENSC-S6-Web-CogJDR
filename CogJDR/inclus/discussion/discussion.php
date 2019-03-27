<script>
    $(document).ready(function () {
        scrollDown = function(elm) {
            //elm.animate({ scrollTop: elm.prop("scrollHeight") - elm.prop("clientHeight")}, 1000);
            elm.scrollTop(elm.prop("scrollHeight") - elm.prop("clientHeight"));
        }

        var elm = $("#discussion");
        elm.load("./inclus/discussion/contenu_discussion.php");
        scrollDown(elm);

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

<ul id="discussion"><?php include "./inclus/discussion/contenu_discussion.php" ?></ul>
<form id="form_envoie_message">
    <table class="w-100">
        <tr>
            <td><input type="text" class="form-control w-100" name="message_text" id="discussion_boite_message" placeholder="Entrez votre message !" autocomplete="off">
            <input type="hidden" name="page_form" value="<?=$_SERVER['REQUEST_URI']?>"></td>
            <td><input class="btn btn-primary w-100" type="submit" value="Envoyer"></td>
        </tr>
    </table>
</form>

<script>
    $("#form_envoie_message").submit(function (e) {
        e.preventDefault();
        $("#discussion").load("./inclus/discussion/contenu_discussion.php", $("#form_envoie_message").serializeArray(), function() {
            $("#menu-toggle").click(function(e_) {
                e_.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
        });
        document.getElementById("form_envoie_message").reset();
    });
</script>
