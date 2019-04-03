var master = $("#form_tot");

function validNb(val, min, max) { return min <= val && val <= max; }
function µ(id) { return $("#" + id).val(); }

generated = [];
count = [];
current = [];
current[2] = 0;
current[3] = 0;
current[4] = 0;

var validations = [
        function() { // Paramètres généraux
            if (µ("titre_modele") && validNb(µ("nb_equipes"), 1, 99) && validNb(µ("nb_roles"), 1, 99) && validNb(µ("nb_actions"), 1, 99)) {
                count[2] = µ("nb_equipes");
                count[3] = µ("nb_roles");
                count[4] = µ("nb_actions");

                for (var i = 2; i < 4; i++)
                    for (var j = 0; j < count[i]; j++) {
                        generated[i + j] = false;
                        $("#menu" + i).slice(1).remove();
                    }

                return true;
            }
            return false;
        },
        function() { // Equipes
            return µ("nom_equipe") && validNb(µ("taille_equipe"), -1, 99);
        },
        function() { // Rôles
            return µ("nom_role") && µ("desc_role");
        },
        function() { // Actions
            return µ("titre_action") && µ("horaire_action") && µ("desc_action") && µ("desc_action");
        },
        function() { // Final
            return µ("desc_modele") && µ("fichier_regles") && µ("img_logo");
        }
    ];

//import {forms} from "./creerModeleForms.js";
function forms(index, islast) {
    return '<p id="num-' + index + '>coucou</p>\n';
}

function change(from, to, positive)  {
    var prev = $("#menu" + from);
    var next = $("#menu" + to);

    prev.removeClass("actif");
    prev.find("input, textarea, select, button").attr("disabled", true);
    prev.effect("highlight", { color: positive ? "#00c72b" : "#6b00a8" }, 1300);

    next.removeClass("invisible");
    next.addClass("actif");
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

        if (validations[num - 1]()) {
            if (!generated[num + current[num]]) {
                alert("adding to liste" + num + "; " + forms(num - 1, current[num] < count[num]));
                $("#liste" + num).append(forms(num - 1, current[num] < count[num]));
                generated[num + current[num]++] = true;
            }
            change(num, num, true);
        } else
            alert("Veuillez renseigner correctement les champs.");
    });

$(".etape-liste-precedente").click(function(e) {
        e.preventDefault();
        var id = e.target.id;
        var num = id.charAt("button".length);

        $("#liste" + num).last().remove();
        generated[num + current[num]--] = false;
        change(num, num, false);
    });
