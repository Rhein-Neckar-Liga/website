$(".beitrag").click(function(event){
	var id = $(this).attr('data-id');
    $.ajax({
		url: "includes/ajax_news.php", 
		type: "POST",
		data: { id: id},
		success: function(result){
			html=getHtml($.parseJSON(result));
			$("#news-"+id).html(html);
		}
	});
});

function getHtml(newsJson){
	console.log(newsJson.title);
	var html="<a id='rnl_'></a>"+
	"<h1><span style='font-size: .8em;font-weight: normal;float:right'>xxxxxx</span>"+newsJson.title+"</h1>"
	+"<div class='content'>"+newsJson.description+"'</div>'";
	return html;
}


