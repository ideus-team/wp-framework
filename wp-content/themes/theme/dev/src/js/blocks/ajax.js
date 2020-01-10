/**
 * Send AJAX request
 */
/*
function initAjax() {
  $('.js-form').on('submit', function(e){
    e.preventDefault();
    var form = $(this);
    var action = form.data('action');

    $.ajax({
      type: 'POST',
      url: ncVar.ajax_url,
      data: {
        'postdata' : form.serialize(),
        'action'   : action,
      },
      dataType: 'json',
      success: function(result) {
        if ( result.success == true ) {
          console.log( result.data );
        } else {
          console.warn( result.data.error );
        }
      }
    });
  });
}
