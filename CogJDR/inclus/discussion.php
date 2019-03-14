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
            precedent = elm[0].innerText.length
            elm.load("./inclus/contenu_discussion.php");
            elm.on("load", function() {
                alert("heya");
                if (precedent < elm[0].innerText.length)
                    scrollDown(elm);
            })
        }, 1000);
        $.ajaxSetup({ cache: false });
    });
</script>

<ul id="discussion"><?=include "./inclus/contenu_discussion.php"?></ul>
<form id="form_envoie_message" action="./inclus/contenu_discussion.php">
    <input type="text" name="message_text" id="discussion_boite_message" placeholder="Entrez votre message !" autofocus>
    <input type="hidden" name="page_form" value="<?=$_SERVER['REQUEST_URI']?>">
    <input type="submit" value="Envoyer">
</form>
