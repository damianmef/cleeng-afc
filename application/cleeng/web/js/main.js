$(document).ready(function(){
    $('.btn-modal').click(function(){
       var itemTitle = $(this).data('title');
       var id = $(this).data('id');
       $('span[data-delete-title]').html(itemTitle);
       $('button[data-delete-id]').data('delete-id', id);
    });
    if (typeof DELETE_URL !== 'undefined') {
        DELETE_URL = DELETE_URL.substring(0, DELETE_URL.length - 1);
    }
    $('button[data-delete-id]').click(function () {
        var id = $(this).data('delete-id');
        if (typeof DELETE_URL !== 'undefined') {
            $.getJSON(DELETE_URL + id, function (data) {
                if (data.variables.status) {
                    $('#exampleModal').modal('hide');
                    $('tr[data-delete-row-id=' + id + ']').remove();
                }
            });
        }
    });

    $('.run-tests').click(function() {
        $('.run-test').click();
    });
    $('.run-test').click(function () {
       var url = $(this).data('href');
       var _that = $(this);
        _that.parent().parent().removeClass('bg-success');
        _that.parent().parent().removeClass('bg-danger');

        $.getJSON( url, function( data ) {
            _that.parent().find('pre').html(JSON.stringify(data));
            if (typeof data.status !== 'undefined' && data.status) {
                _that.parent().parent().addClass('bg-success')
            } else {
                _that.parent().parent().addClass('bg-danger')
            }
        });
    });
});