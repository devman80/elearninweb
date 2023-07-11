



/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */






/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

var $section = $('#dispenser_section');
// When section gets selected ...
$section.change(function() {

  // ... retrieve the corresponding form.
  var $form = $(this).closest('form');
  // Simulate form data, but only include the selected section value.
  var data = {};
  data[$section.attr('name')] = $section.val();
  // Submit data via AJAX to the form's action path.
  $.ajax({
    url : $form.attr('action'),
    type: $form.attr('method'),
    data : data,
    complete: function(html) {
      // Replace current matiere field ...
      $('#dispenser_matiere').replaceWith(
        // ... with the returned one from the AJAX response.
        $(html.responseText).find('#dispenser_matiere')
      );
      // Position field now displays the appropriate matieres.
    }
  });
});






  
