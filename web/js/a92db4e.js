//$(document).ready(function(){
//    $('#point').hide();
//});



$(document).on("change", "#feedback_chain", function() {
   var path = $('#point').attr("data-path");
   if($(this).val() !== '')
   {    
        $('#point').show();
        $.ajax({
             type: "POST",
             data: { chain: $(this).val() },
             url: path,
             dataType : "json",
             success: function(data){
                 if (data !== ''){
                    $('#feedback_point').empty();
                    $('#feedback_point').append('<option value="">Выберите точку</option>');
                    $.each(data, function(k, v) {
                         $('#feedback_point').append('<option value="' + k + '">' + v + '</option>');
                     });
                    }
                    else
                    {
                        $('#feedback_point').append('<option value="No points">No points</option>');
                    }
                },
            error: function(xhr) {
                        alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
                    }
        });
        return false;
    }
    else
    {
        $('#feedback_point').empty();
        $('#feedback_point').append('<option value="">Выберите точку</option>');
    }
});

//var $chain = $('#feedback_chain');
//// When sport gets selected ...
//$chain.change(function() {
//  // ... retrieve the corresponding form.
//  var $form = $(this).closest('form');
//  alert($form);
//  // Simulate form data, but only include the selected sport value.
//  var data = {};
//  data[$chain.attr('name')] = $chain.val();
//  // Submit data via AJAX to the form's action path.
//  $.ajax({
//    url : $form.attr('action'),
//    type: $form.attr('method'),
//    data : data,
//    success: function(html) {
//      // Replace current position field ...
//      $('#feedback_chain').replaceWith(
//        // ... with the returned one from the AJAX response.
//        $(html).find('#feedback_chain')
//      );
//      // Position field now displays the appropriate positions.
//    },
//    error: function(xhr) {
//                        alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
//                    }
//  });
//});
