jQuery(function() {
    $('#gen-apples-btn').on('click', function() {

        $.ajax({
            method: "GET",
            url: "/apple/generate-random"
        })
        .done(function(resp) {
            for (const el of resp) {
                $('#apples').append(el);
            }
        })
        .fail(function(resp) {
            alert(resp.responseText);
        });

        return false;
    });

    $('.apple-drop-btn').on('click', function() {
        let appleId = $(this).data('id');

        return false;
    });

    $('.apple-eat-btn').on('click', function() {
        let appleId = $(this).data('id');

        return false;
    });

    $('.apple-delete-btn').on('click', function() {
        let appleId = $(this).data('id');

        $.ajax({
            method: "POST",
            url: "/apple/delete",
            data: { id: appleId }
        })
        .done(function(resp) {
            $('#apple-'+appleId).remove();
        })
        .fail(function(resp) {
            alert(resp.responseText);
        });

        return false;
    });
});