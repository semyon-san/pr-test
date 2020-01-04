jQuery(function() {
    $(document).on('click', '#gen-apples-btn', function() {

        let btnElement = $(this);

        $.ajax({
            method: "GET",
            url: "/apple/generate-random",
            beforeSend: function() {
                btnElement.addClass('disabled');
            }
        })
        .done(function(resp) {
            for (const el of resp) {
                $('#apples').append(el);
            }
        })
        .fail(function(resp) {
            krajeeDialogError.alert(resp.responseText);
        })
        .always(function() {
            btnElement.removeClass('disabled');
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
            btnElement.removeClass('disabled');
            krajeeDialogError.alert(resp.responseText);
        });

        return false;
    });

    $(document).on('click', '.apple-eat-btn', function() {
        let appleId = $(this).data('id');

        let btnElement = $(this);
        let percent = 0;

        krajeeDialogEat.prompt({
            label:'Сколько съесть (%)?',
            placeholder:'1-100%'
        }, function (result) {
            if (result) {
                percent = result;

                $.ajax({
                    method: "POST",
                    url: "/apple/eat",
                    data: { id: appleId, percent: percent },
                    beforeSend: function() {
                        btnElement.addClass('disabled');
                    }
                    })
                    .done(function(resp) {
                        $('#apple-'+appleId + ' .apple-size').text(resp + '%');
                        if (resp === 0) {
                            $('#apple-'+appleId).remove();
                        }
                    })
                    .fail(function(resp) {
                        krajeeDialogError.alert(resp.responseJSON.message);
                    })
                    .always(function() {
                        btnElement.removeClass('disabled');
                    });
            } else {
                return false;
            }
        });

        return false;
    });

    $(document).on('click', '.apple-delete-btn', function() {
        let appleId = $(this).data('id');

        let btnElement = $(this);

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
            krajeeDialogError.alert(resp.responseText);
        })
        .always(function() {
            btnElement.removeClass('disabled');
        });

        return false;
    });
});