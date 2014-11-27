//喜欢
$('.content-li-like').live('click',function(){
	var like_button =$(this);
	changeLikeState(like_button);
});

function changeLikeState(like_button){ //改变喜欢状态 
	var articleId = like_button.attr("articleid");
	//alert(articleId);	
	var uid=$("#wrapper").attr('value');
	if(uid==0){
		alert("请先登录!");
		return 0;
	}
	var ifLiked = like_button.attr("data-liked");  //1为喜欢 0否
	//alert(ifLiked);
	if(ifLiked != 1){										 //设置喜欢
		like_button.css({ backgroundImage:"url(static/images/home/like_on.png)"});
		like_button.attr('data-liked','1');
		$.ajax({
			url: "index.php?c=ajax&m=like",
			type:"POST",
			data:"artId="+articleId+"&userId="+uid+"&like=on",   //articleId
			success: function(data){
				if(data.status == false){  //设置失败
					like_button.css({ backgroundImage:"url(static/images/home/like.png)"});
					like_button.attr('data-liked','0');
				}
			}
		});                 
	}else{                                //取消喜欢
		like_button.css({ backgroundImage:"url(static/images/home/like.png)"});
		like_button.attr('data-liked','0');
		$.ajax({
			url:"index.php?c=ajax&m=like",
			type:"POST",
			data:"artId="+articleId+"&userId="+uid+"&like=off",
			success:function(data){
				if(data.status == false){
					like_button.css({ backgroundImage:'url(static/images/home/like_on.png)'});
					like_button.attr('data-liked','1');
				}
			}
		});	
	}
}