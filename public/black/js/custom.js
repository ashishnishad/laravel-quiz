(function($) {
    "use strict";
    $(document).ready(function() {
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
        $('#confirm-delete .btn-ok').on('click', function(e) {
            var thisObj = $(this);
            $.ajax({
                type: "GET",
                url: thisObj.attr('href'),
                success: function(data) {
                    $('#confirm-delete').modal('toggle');
                    if(thisObj.attr('action') != '')
                       window.location.href = thisObj.attr('action');
                    else
                    table.ajax.reload();
                }
            });
            return false;
        });
        
        $('#confirm-delete2 .btn-ok').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: $(this).attr('href'),
                success: function(data) {
                    $('#confirm-delete').modal('toggle');
                    table.ajax.reload();
                }
            });
            return false;
        });
    });
   
})(jQuery);