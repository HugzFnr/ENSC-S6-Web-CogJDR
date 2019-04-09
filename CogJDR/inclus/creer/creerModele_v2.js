var master = $("#form_tot");

function validNb(val, min, max) { return min <= val && val <= max; }
function µ(id) { return $("#" + id).val(); } // nouveau module JS ?!?

generated = [null, null, [], [], []]; // track des cartes générées pour chaque liste
count = []; // compte du nombre de cate a remplire pour chaque liste
current = [null, null, 0, 0, 0]; // carte actuellement visée pour chaque liste

var validations = [
        function() { // Paramètres généraux
            if (µ("titre_modele") && validNb(µ("nb_equipes"), 1, 99) && validNb(µ("nb_roles"), 1, 99) && validNb(µ("nb_actions"), 1, 99)) {
                if (0 < count.length)
                    for (var i = 2; i < 4; i++) {
                        for (var j = 0; j < count[i]; j++)
                            generated[i][j] = false;

                        if (1 < count[1])
                            $("#menu" + i).children().slice(1, count[i]).remove();
                    }

                count[2] = µ("nb_equipes");
                count[3] = µ("nb_roles");
                count[4] = µ("nb_actions");

                $("#equipe_total0").html(count[2]);
                $("#role_total0").html(count[3]);
                $("#action_total0").html(count[4]);

                return true;
            }
            return false;
        },
        function(k) { // Equipes
            return µ("nom_equipe" + k) && validNb(µ("taille_equipe" + k), -1, 99);
        },
        function(k) { // Rôles
            return µ("nom_role" + k) && µ("desc_role" + k);
        },
        function(k) { // Actions
            return µ("titre_action" + k) && µ("horaire_action" + k) && µ("desc_action" + k) && µ("effet_action" + k);
        },
        function() { // Final
            return µ("desc_modele") && µ("fichier_regles") && µ("img_logo");
        }
    ];

function change(from, to, positive)  {
    var prev = $("#menu" + from);
    var next = $("#menu" + to);

    prev.removeClass("actif");
    prev.find("input, textarea, select, button").attr("readonly", true);
    prev.effect("highlight", { color: positive ? "#00c72b" : "#6b00a8" }, 1300);

    next.removeClass("invisible");
    next.find("input, textarea, select, button").attr("readonly", false);
    next.addClass("actif");
}

function onplace(num, from, to) {
    var menu = $("#menu" + num);

    var prev = menu.find("#num" + from);
    var next = menu.find("#num" + to);

    prev.hide();
    next.show();
}

$(".etape-suivante").click(function(e) {
        e.preventDefault();
        var id = e.target.id;
        var num = id.charAt("button".length);

        if (validations[num - 1]())
            change(num++, num, true);
        else
            alert("Veuillez renseigner correctement les champs.");
    });

$(".etape-precedente").click(function(e) {
        e.preventDefault();
        var id = e.target.id;
        var num = id.charAt("button".length);

        change(num--, num, false);
    });

$(".etape-liste-suivante").click(function(e) {
        e.preventDefault();
        var id = e.target.id;
        var num = id.charAt("button".length);

        // si c'est le dernier élement de la liste, process comme une case normale
        if (current[num] + 1 == count[num]) {
            if (validations[num - 1](current[num]))
                change(num++, num, true);
            else
                alert("Veuillez renseigner correctement les champs.");
            return;
        }

        // sinon, traitement avec génération du form
        if (validations[num - 1](current[num])) {
            if (!generated[num][current[num]]) {
                $("#menu" + num).children().last().before(forms(num, current[num] + 1, current[num] < count[num]));
                alert("adding shit");
                generated[num][current[num]] = true;
            }
            onplace(num, current[num]++, current[num]);
        } else
            alert("Veuillez renseigner correctement les champs.");
    });

$(".etape-liste-precedente").click(function(e) {
        e.preventDefault();
        var id = e.target.id;
        var num = id.charAt("button".length);
        
        // si c'st le premier élement de la liste, process comme une case normale
        if (current[num] == 0) {
            change(num--, num, false);
            return;
        }

        //$("#liste" + num).last().remove();
        //generated[num + current[num]] = false;
        onplace(num, current[num]--, current[num]);
    });



// monster
function forms(num, index, islast) {
    return [
            '\n<div id="num' + index + '">' +
            '\n    <h3 class="text-center"> Créer l\'équipe  <b class="rouge" id="equipe_actuel' + index + '">' + (index + 1) + '</b>/<b id="equipe_total' + index + '">' + count[num] + '</b> </h3>' +
            '\n    <div class="form-group">' +
            '\n        <div class="col-sm-10 offset-sm-1">' +
            '\n            <label for="nom_equipe' + index + '"> <p>Nom de l\'équipe</p> </label>' +
            '\n            <input type="text" name="nom_equipe' + index + '" class="form-control" id="nom_equipe' + index + '" placeholder="Un nom fédérateur !" required autofocus>' +
            '\n        </div>' +
            '\n    </div>' +
            '\n' +
            '\n    <div class="form-group">' +
            '\n        <div class="col-sm-10 offset-sm-1">' +
            '\n            <label for="taille_equipe' + index + '"> <p>Taille maximale de l\'équipe (-1 = &infin;)</p> </label>' +
            '\n            <input type="number" value="1" min="-1" max="99" name="taille_equipe' + index + '"  class="form-control" id="taille_equipe' + index + '" required>' +
            '\n        </div>' +
            '\n    </div>' +
            '\n' +
            '\n    <div class="form-group">' +
            '\n        <div class="col-sm-10 offset-sm-1">' +
            '\n            <label for="discussion' + index + '"> <p>Discussion autorisée</p> </label>' +
            '\n            <select name="discussion' + index + '" class="form-control" id="discussion' + index + '" required>' +
            '\n                <option value=true> Oui </option>' +
            '\n                <option value=false> Non </option>' +
            '\n            </select>' +
            '\n        </div>' +
            '\n    </div>' +
            '\n</div>',

            '\n<div id="num' + index + '">' +
            '\n    <h3 class="text-center"> Créer le rôle <b class="rouge" id="role_actuel' + index + '"> ' + (index + 1) + ' </b>/<b id="role_total"> ' + count[index] + ' </b> </h3>' +
            '\n    <div class="form-group">' +
            '\n        <div class="col-sm-10 offset-sm-1">' +
            '\n            <label for="nom_role' + index + '"> <p>Nom du rôle</p> </label>' +
            '\n            <input type="text" name="nom_role' + index + '" class="form-control" id="nom_role' + index + '" placeholder="Pas \'loup-garou\' stp " required autofocus>' +
            '\n        </div>' +
            '\n    </div>' +
            '\n' +
            '\n    <div class="form-group">' +
            '\n        <div class="col-sm-10 offset-sm-1">' +
            '\n            <label for="img_role' + index + '"> <p>Image du rôle</p> </label>' +
            '\n            <input type="file" name="img_role' + index + '" accept=".jpg,.png,.jpeg,.gif" class="form-control" id="img_role' + index + '">' +
            '\n        </div>' +
            '\n    </div>' +
            '\n' +
            '\n    <div class="form-group">' +
            '\n        <div class="col-sm-10 offset-sm-1">' +
            '\n            <label for="desc_role' + index + '"> <p>Description du rôle</p> </label>' +
            '\n            <textarea name="desc_role' + index + '" class="form-control" id="desc_role' + index + '" placeholder="Décris donc qui est ce personnage !" required></textarea>                            ' +
            '\n        </div>' +
            '\n    </div>' +
            '\n</div>'
        ][num - 2];
}
