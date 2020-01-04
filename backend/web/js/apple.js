jQuery(function() {
    $(document).on('click', '#gen-apples-btn', function() {

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

    $(document).on('click', '.apple-drop-btn', function() {
        let appleId = $(this).data('id');

        let btnElement = $(this);

        $.ajax({
            method: "POST",
            url: "/apple/fall",
            data: { id: appleId },
            beforeSend: function() {
                btnElement.addClass('disabled');
            }
        })
        .done(function(resp) {
            $('#apple-'+appleId + ' .apple-status').text(resp);
        })
        .fail(function(resp) {
            alert(resp.responseText);
        })
        .always(function() {
            btnElement.removeClass('disabled');
        });

        return false;
    });

    $(document).on('click', '.apple-eat-btn', function() {
        let appleId = $(this).data('id');

        return false;
    });

    $(document).on('click', '.apple-delete-btn', function() {
        let appleId = $(this).data('id');
        $(this).addClass('disabled');

        let btnElement = this;

        $.ajax({
            method: "POST",
            url: "/apple/delete",
            data: { id: appleId },
            beforeSend: function() {
                btnElement.addClass('disabled');
            }
        })
        .done(function(resp) {
            $('#apple-'+appleId).remove();
        })
        .fail(function(resp) {
            alert(resp.responseText);
        })
        .always(function() {
            btnElement.removeClass('disabled');
        });

        return false;
    });
});