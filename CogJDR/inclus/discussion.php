<script>
    $(document).ready(function () {
        setInterval(() => $("#discussion").load("./inclus/contenu_discussion.php"), 2000);
        $.ajaxSetup({ cache: false });
    });
    
    function SubForm() {
        $.ajax({
            url:'./',
            type:'post',
            data:$('#myForm').serialize(),
            success:function(){
                alert("worked");
            }
        });
    }
</script>

<div id="discussion">Merci de patienter...</div>
<input type="text" name="message" id="discussion_boite_message" hint="Entrez votre message !" action="SubForm()">
