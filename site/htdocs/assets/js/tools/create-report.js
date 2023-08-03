$(function() {

    const f = document.getElementById("event");
    $(f).submit(function(e){
        $('#loadingauth').show()
        $.post("app/helper/reps.php", $(this).serialize(), (data)=>{
            $('#loadingauth').hide();
            $('#create-button').parent().append(`<a class="add-info ready-to-d" href="${data}" download>Скачать</a>`)

            $('#create-button').remove();        
        })
        e.preventDefault();
    })

}());