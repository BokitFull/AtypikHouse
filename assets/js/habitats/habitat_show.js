import $ from 'jquery';

$("#form-reservation").on("submit", function() {
    if($("#nb_personnes").val() == "") {
        alert("Veuillez choisir un nombre de personne pour votre réservation.")
        return false;
    }
    if($("#date-picker").val() == "") {
        alert("Veuillez choisir une période pour votre réservation.")
        return false;
    }
});