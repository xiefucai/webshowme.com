$(function(){
	$(".category_panel").find(".category_panel_closebtn").click(function(){
		$(this).parent().hide();
	});
	$(".current_category").bind("click",function(){
		var offset = $(this).offset(),w = $(this).width();console.log(w);
		$(".category_panel").show().find(".arrow_up").css("left",offset.left+18-w/2);
	});
	$("#category_setter").bind("click",function(){
		var category_id = $(".category_panel").find(":checked").val(),articles_id = [];
			$(".article_list").find(":checked").each(function(){
				articles_id.push($(this).val());
			});
		if (articles_id.length === 0 || (+category_id) === 0){
			return;
		}
		
		$.ajax({
			 "type":"post"
			,"dataType":"json"
			,"url":"../../controller/frontControll.php?action=setArticlesCategory&id="+category_id
			,"data":{"articles_id":articles_id.join(",")}
			,"success":function(d){
				var ret = +d.ret,msg=d.msg||"";
				if (ret === 0){
					alert("设置成功");
					location.reload();
				}else{
					alert("设置失败");
				}
			}
			,"error":function(){
				alert("网络连接失败");
			}
		});
	});
});