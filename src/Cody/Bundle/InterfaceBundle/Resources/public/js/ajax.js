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

