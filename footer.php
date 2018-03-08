<script src="/assets/js/jquery-3.3.1.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script>
window.token = { ms_token: "<?php echo $_SESSION['ms_token']; ?>" };
$(function() {
    $.ajaxSetup({
        cache: false,
        data: window.token
    });

    function toJson(form) {
        var array = $(form).serializeArray();
        var json = {};

        $.each(array, function() {
            json[this.name] = this.value || '';
        });

        return json;
    }

    var login = $("#ms-login");
    var result = $("#ms-message");


    login.submit(function(e) {
        e.preventDefault();
        var data = toJson(this);
        $.post('main.Login.php', {
            data: data
        }, function(data) {
            if (data.status == 'success') {
                result.html('<div class="alert alert-' + data.status + '">' + data.message + ', Redirecting...</div>').show().fadeIn();
                setTimeout(function() {
                    location.replace('dashboard.php');
                }, 5000);
            } else {
                result.html('<div class="alert alert-' + data.status + '">' + data.message + '</div>').show().fadeIn();
            }
        }, 'json');
    });
})
</script>
</body>
</html>