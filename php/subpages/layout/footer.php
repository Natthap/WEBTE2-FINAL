<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#newsDiv').empty();
        $.ajax({
            type: 'GET',
            url: 'https://147.175.98.140/semestralnyProjekt/php/rest/RestNews.php',
            dataType: 'json',
            success: function (data) {
                $length = data[0]
                for (i = 0; i < data[0].length; i++) {
                    $('#newsDiv').append(data[0][i] + "<br>");
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                alert('GET nefunguje 😕');
                console.log(xhr.status);
                //console.log(errorThrown);
                console.log(textStatus);
            }
        });
    });
</script>
</body>
</html>
