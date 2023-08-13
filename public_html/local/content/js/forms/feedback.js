$(document).ready(function() {
    $(".modal-form-text").mask("+7 (999) 999-99-99", {autoclear: true});

    $("#contact").submit(function() {
        return false;
    });

    $("#send").on("click", function(){
        var phonelval   = $("#modal-form-phone").val();
        var nameval     = $("#modal-form-name-id").val();
        var namelen     = nameval.length;
        var phonelen    = phonelval.length;

        if(phonelen !== 18) {
            $("#modal-form-phone").addClass("error");
        }
        else if(phonelen === 18){
            $("#modal-form-phone").removeClass("error");
        }

        if(namelen < 3) {
            $("#modal-form-name-id").addClass("error");
        }
        else if(namelen >= 3){
            $("#modal-form-name-id").removeClass("error");
        }

        if(phonelen === 18 && namelen >= 3) {
            $("#send").replaceWith("<em>Отправка...</em>");

            BX.ajax({
                url: '/local/ajax/modal-form-controller.php',
                method: 'POST',
                data: $("#contact").serialize(),
                dataType: 'json',
                onsuccess: function(data) {
                    if(data.status === 'success') {
                        console.log(data);
                        $("#contact").fadeOut('fast', function(){
                            $(this).before('<strong style="color: #00a67c;">Ваше сообщение успешно отправлено!</strong>');
                        });
                    }
                }
            });
        }
    });
});
