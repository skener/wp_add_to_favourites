jQuery(document).ready(function ($) {
    $('.wf-favourites-link a').click(function (e) {
        e.preventDefault();
       // debugger;
        var action = $(this).data('action');
        $.ajax({
            type: 'POST',
            url: wf_favourites.url,
            data: {
                action: 'wf_' + action,
                security: wf_favourites.nonce,
                post_id: wf_favourites.post_id
            },
            beforeSend:function(){
              $('.wf-favourites-link a').fadeOut(300, function () {
                    $('.spin-hide-p').fadeIn();
              })
                alert(action);
            },
            success: function (res) {
                $('.spin-hide-p').fadeOut(300, function () {
                    $('.wf-favourites-link a').fadeIn();
                });
                alert(res);
            },
            error: function (err) {
                console.log(err)
            }
        });
    })
});