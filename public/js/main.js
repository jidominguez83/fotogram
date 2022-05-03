var url = 'http://127.0.0.1:8000';

window.addEventListener("load", function(){    
	$('.btn-like').css('cursor','pointer');
	$('.btn-dislike').css('cursor','pointer');

	$(document).on("click", ".btn-like", function(e){
		$(this).addClass('btn-dislike').removeClass('btn-like');
		$(this).attr('src', url+'/img/heart-red.png');   

        $.ajax({
            url: url+'/like/'+$(this).data('id'),
            type: 'GET',
            success: function(response){
                if(response.like){
                    console.log('Has dado like a la publicacion');
                    console.log(response.like.image_id);
                    $("#number-likes-"+response.like.image_id).html(response.num_likes);
                }else{
                    console.log('Error al dar like');
                }
            }
        })
	});

	$(document).on("click", ".btn-dislike", function(e){
		$(this).addClass('btn-like').removeClass('btn-dislike');
		$(this).attr('src', url+'/img/heart-gray.png');

        $.ajax({
            url: url+'/dislike/'+$(this).data('id'),
            type: 'GET',
            success: function(response){
                if(response.like){
                    console.log('Has dado dislike a la publicacion');
                    console.log(response.num_likes);
                    $("#number-likes-"+response.like.image_id).html(response.num_likes);
                }else{
                    console.log('Error al dar dislike');
                }
            }
        });
	});

    // Buscador
    $('#buscador').submit(function(){
        $(this).attr('action', url+'/users/'+$('#buscador #search').val());
    });
});
