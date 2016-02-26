$(document).ready(function(){
    $(".spiel").each(function(){
        $(this).qtip(
        {
            content: {
                url: "includes/scripts/showSpiel.php",
                data: {
                    idSpiel: $(this).attr('title'),
                    liga: document.$_GET['liga'],
                    jahr: document.$_GET['jahr']
                    },
                method: 'get'
            },
            style: {
                width: 400
            },
            show: {
                effect: {
                    type: 'fade', 
                    length: 350
                },
                when: 'click',
                solo: true
            },
            hide: {
                when: {
                    event: 'unfocus' , 
                    fixed: false
                }
            }
        });
    });
});