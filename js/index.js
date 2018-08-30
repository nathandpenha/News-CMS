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
				+'<strong class="d-inline-block mb-2 text-primary">'+data[i].category_name+'</strong>'
				+'<h3 class="mb-0">'
				+'<a class="text-dark" href="#">'+data[i].title+'</a>'
				+'</h3>'
				+'<br>'
				+'<p class="card-text mb-auto">'+data[i].body+'...</p>'
				+'<a href="#">Continue reading</a>'
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
