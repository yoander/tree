$(document).ready(function() {
    $('a', '.tree').click(function() {
        var elem = $(this);
        $.post(window.location.href, { 'slug' : $(this).attr('href') },
            function(response, status) {
                elem.parents('li:first').append(response);
            }
        );

        return false;
    })
});
