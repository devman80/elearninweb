
function supprimeData(url, formData, urlretour){
    //envoi de data
    $.ajax({
        type: 'POST',
        url: url,
        cache: false,
        data: formData,
        success: function(response) {
            console.log('La requête a réussi :', response);
            alert(response.data);
            window.location.href = urlretour;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('La requête a échoué :', textStatus, errorThrown);
        }
    });


}
  function afficheModal(links) {
      // Boucler à travers les liens

      for (var i = 0; i < links.length; i++) {
          // Ajouter un gestionnaire d'événements "click" à chaque lien
          links[i].addEventListener('click', function (event) {
              // Empêcher le comportement par défaut du lien
              event.preventDefault();

              // Récupérer la valeur de l'attribut "id" du lien cliqué
              var idValue = this.getAttribute('data-value');

              $("#delete_value").val(idValue);
              var libellesupp = this.getAttribute('data-libelle');
              var mibelle = "Voulez-vous supprimer cet enregistrement : " + libellesupp + " ?";
              $("#masupp").html(mibelle);
              // Faire quelque chose avec la valeur de l'attribut "id"
              //console.log(idValue);
          });
      }
  }


