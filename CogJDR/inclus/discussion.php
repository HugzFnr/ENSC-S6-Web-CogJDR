<script>
    $(document).ready(function () {
        setInterval(() => $("#discussion").load("./inclus/contenu_discussion.php"), 2000);
        $.ajaxSetup({ cache: false });
    });
    
    /*$('#form_envoie_message').submit(function(e) {
        e.preventDefault();
        alert("coucou");
        /*alert("prevented");
        $.post('./inclus/contenu_discussion.php', $(this).serialize(), function(data) {
            alert(data);
        });*
    });*/

</script>

<div id="discussion">...</div>
<form id="form_envoie_message" action="./inclus/contenu_discussion.php">
    <input type="text" name="message_text" id="discussion_boite_message" placeholder="Entrez votre message !" autofocus>
    <input type="hidden" name="page_form" value="<?=$_SERVER['REQUEST_URI']?>">
    <input type="submit" value="Envoyer">
</form>
