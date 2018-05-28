$(function(){
    $('#btn_goal_form_toggle').click(function(event) {
        $('#goal_form').slideToggle(300);
    });

    $('#btn_save_goal').click(function(event) {
        var goal_month = $('#goal_month').val();

        $.ajax({
            url         :'api/user.php',
            cache       :false,
            dataType    :"json",
            type        :"POST",
            data:{
                request  :'edit_goal',
                goal_month  :goal_month
            },
            error: function (request, status, error){
                console.log(request.responseText);
            }
        }).done(function(data){
            location.reload();
        });
    });

    // Logout Action
    $('#btn-logout').click(function(event) {
        $(this).html('Logging out...<i class="fas fa-spinner fa-pulse"></i>');
        window.location.replace('logout.php');
    });

    $('#btn-login').click(function(event) {
        $(this).html('Logging in...<i class="fas fa-spinner fa-pulse"></i>');
        var urls = $(this).attr('data-link');
        window.location.replace(urls);
    });
});