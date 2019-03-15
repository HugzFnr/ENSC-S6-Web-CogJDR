<script>
    $(document).ready(function () {
        scrollDown = function(elm) {
            //elm.animate({ scrollTop: elm.prop("scrollHeight") - elm.prop("clientHeight")}, 1000);
            elm.scrollTop(elm.prop("scrollHeight") - elm.prop("clientHeight"));
        }

        var elm = $("#discussion");
        elm.load("./inclus/contenu_discussion.php");
        scrollDown(elm);

        setInterval(function() {
            var elm = $("#discussion");
            precedent = elm[0].innerText.length;
            var shouldScroll = elm[0].scrollHeight - 10 < elm.scrollTop() + elm.innerHeight();
            elm.load("./inclus/contenu_discussion.php", function() {
                if (shouldScroll)
                    scrollDown(elm);
            })
        }, 1000);
        $.ajaxSetup({ cache: false });
    });
</script>

<ul id="discussion"><?php include "./inclus/contenu_discussion.php" ?></ul>
<form id="form_envoie_message" action="./inclus/contenu_discussion.php">
    <input type="text" name="message_text" id="discussion_boite_message" placeholder="Entrez votre message !" autofocus>
    <input type="hidden" name="page_form" value="<?=$_SERVER['REQUEST_URI']?>">
    <input type="submit" value="Envoyer">
</form>
