$(document).ready(function() {
	$.ajax({
		url: '../model/getFeatured.php',
		type: 'GET',
		success : function(data){
			console.log(data);
			var txt = "";
			for ( i = 0; i<data.length; ++i){
				txt+= '<div class="col-md-4">'
				+'<div class="card flex-md-row mb-4 box-shadow h-md-250 hover-shadow">'
				+'<div class="card-body d-flex flex-column align-items-start">'
				+'<strong class="d-inline-block mb-2 text-primary"><a href="category.php?node='+data[i].category+'">'+data[i].category_name+'</a></strong>'
				+'<h4 class="mb-0">'
				+'<a class="text-dark" href="article.php?node='+data[i].id+'">'+data[i].title+'</a>'
				+'</h4><br>'
				+'<div class="card-text mb-auto">'+((data[i].body).replace(/<(?:.|\n)*?>/gm, '').substr(0,70))+'...</div>'
				+'</div>'
				+'</div>'
				+'</div>';
			}
			$("#featured_post").html(txt);
		},
		error : function(error){
			console.log(error);
			console.log(error.responseText);
		}
	});
});
