
// FUNCTION POUR AFFICHER LE MOT DE PASSE A LA CONNEXION

function ShowPassword() {
    var mdp = document.getElementById("mdp");
  if (mdp.type === "password") {
    mdp.type = "text";
  } else {
    mdp.type = "password";
  }
}
$(document).ready(function(){
  $('#eye').click(function(){
    $('#eye').css('visibility', 'hidden');
    $('#eye-slash').css('visibility', 'visible');
  })
  $('#eye-slash').click(function(){
    $('#eye-slash').css('visibility', 'hidden');
    $('#eye').css('visibility', 'visible');
  })
  // icone stylo dans les dms
  $('#pen').click(function(){
    $('#write_dm').css('display', 'block');
  })
  // afficher/activer inputs pour modifier le mdp
  $('#edit_prenom').on('click', function() {
    $('#input_prenom').removeAttr('disabled');
  })
  $('#edit_nom').on('click', function() {
    $('#input_nom').removeAttr('disabled');
  })
  $('#edit_mail').on('click', function() {
    $('#input_mail').removeAttr('disabled');
  })
  $('#edit_phone').on('click', function() {
    $('#input_phone').removeAttr('disabled');
  })
  $('#edit_descri').on('click', function() {
    $('#input_descri').removeAttr('disabled');
  })

  $('#modif_mdp').one('click', function(e) {
    e.preventDefault();
    $('#set_mdp').append("<input type='password' id='last_mdp' name='last_mdp' placeholder='ancien mot de passe'><br><input type='password' id='new_mdp' name='new_mdp' minlength='8' placeholder='nouveau mot de passe'><br><input type='password' name='confirm_mdp' id='confirm_mdp' minlength='8' placeholder='nouveau mot de passe'>");
  })


})
