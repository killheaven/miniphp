$(document).ready(function(e) {

	
	//
	


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
//获取评论
function addCommentBox(id,obj){
	//var comment = "<div class='replyComment-div'><textarea id='textareaId"+id+"' class='replyComment'></textarea><div  style='float:left'><span class='message_face'><font>表情</font></span></div></div><input class='replyComment-button' type='button' value='回复' />";
	
	var comment = "<div><textarea  id='textareaId"+id+"' class='replyComment'></textarea><div  style='float:left'><div class='message_face'><font>表情</font></div></div></div><input class='replyComment-button' type='button' value='回复' />";
	obj.after(comment);
}
function removeCommentBox(obj){
	obj.remove();
}
 window.allObj=null;
   function getEmotion(_this,_textarea,_parent,id){
		
		$(_textarea).focus();
		$(_this).jqfaceedit({txtAreaObj:_textarea,containerObj:_parent,top:25,left:-28,textareaid:id});
	 }
 	$(".message_face").live("mouseover",function(){
		$(this).removeClass("message_face").addClass("message_face_hover");
				$(".message_face_hover").live("click",function(){
				getEmotion($(this),$(this).parent().parent().children('textarea'),$(this).parent().parent(),$(this).parent().parent().children('textarea').attr('id'));
							
				});
				
	});
	$(".message_face_hover").live("mouseout",function(){
		
		$(this).removeClass("message_face_hover").addClass("message_face");
				
	});
	/*
	$(".content-li-more").live("click",function(){
		var id = $(this).attr('value');	
		getMoreContent(id);
	});*/
	/*
function getMoreContent(id){
	$.ajax({
		   type: "POST",
		   url: "index.php?c=ajax&m=getMoreContent",
		   data: "action=getMoreContent&id="+id+"",
		   dataType:'json',
		   success: function(msg){
				if(msg.status){
					var contents = msg.content.content_text;
					var d=art.dialog({
						lock: true,
						content:contents,
						width:780,
						height:100,
						padding:20,
						fixed: true,
						
					});
				}else{
					return false;
				}
		   }
		});
}	
	*/
$('.content-li-comment').bind('click',function(){
	
if(allObj){
		if($(this).attr('value')==allObj.attr('value')){
			return 0;
		}
	}
	var articleBox = $(this).parent().attr('class');
	var i = articleBox.indexOf(" ");
	console.log(i);
	if(i>0){
		articleBox = articleBox.substring(0,i);
	}
	

	var id=$(this).attr('value');
	//alert($(this).parents('.'+articleBox).attr('class'));
	var reply ='<div class="messages-replyBox"><div class="messages-replyBox-avatar"><a href=""><img src="../images/test.png"/></a></div><p><span class="messages-replyBox-name"><span>葫芦娃</span>回复托托星:</span>看过原作再看的《红辣椒》，书中令人咋舌最精彩丰富的地方今敏并没有用，这也许是今敏另一个聪明的地方，知道什么是完美呈现，用自己的视角，即便是改编的作品也带有浓厚的今敏风格。<span><a href="#reply">回复<span></span></a></span></p><div class="messages-reply"><div class="messages-date">2013-02-04 01:47:19</div> </div></div>';
	addCommentBox(id,$(this).next('.content-li-like'));
	getReply(id,3,1,$(this).parents('.'+articleBox));
	//$(this).parents('.'+articleBox).append(reply).append(reply);
	$(this).unbind('click');
	var commentY =$(document).scrollTop();
	
	$('.messages-replyBox p a').live('click',function(){
		var replyTo = $(this).parents('p').find('.messages-replyBox-name').text();
		$('.replyComment').val('回复'+replyTo+'');
		$('html,body').animate({scrollTop:commentY},120);
		
	});
	//回复框旁回复按钮
		$('.replyComment-button').bind('click',function(){
			/*
			
			var replyText = $(this).prev().find('.replyComment').val();
			var status = replyText.substring(replyText.indexOf(":")+1,replyText.length);
			if(status.length<5){
				alert("回复不少于5个字!");
				return 0;
			}
			
			if(status){
			    var id=$(this).parent().find('.content-li-articlecomment').attr("value");
				
				insertReply(id,uid,replyText,$(this).parent());
				//var reply ='<div class="messages-replyBox"><div class="messages-replyBox-avatar"><a href=""><img src="./static/images/home/test.png"/></a></div><p><span class="messages-replyBox-name">葫芦娃:</span>'+replyText+'<span><a href="#reply">回复<span></span></a></span></p><div class="messages-reply"><div class="messages-date">2011-11-11</div> </div></div>';
				//$(this).parent().append(reply);
				var h =$(this).siblings('div').last().offset().top;
				$('html,body').animate({scrollTop:h-20},120);
				$(this).prev().find('.replyComment').val('');
			}else{
				alert("内容不能为空!");
			}
			*/
			var uid=$("#wrapper").attr('value');
			if(uid==0){
				alert("请先登录!");
				return 0;
			}
			var replyText = $(this).siblings('div').find('.replyComment').val();
			var status = replyText.substring(replyText.indexOf(":")+1,replyText.length);
			if(status.length<5){
				alert("至少需要5个字!");
				return 0;
			}
			if(status){
			    var id=$(this).parent().find('.content-li-comment').attr("value");
				
				insertReply(id,uid,replyText,$(this).parent());
				//var reply ='<div class="messages-replyBox"><div class="messages-replyBox-avatar"><a href=""><img src="./static/images/home/test.png"/></a></div><p><span class="messages-replyBox-name">葫芦娃:</span>'+replyText+'<span><a href="#reply">回复<span></span></a></span></p><div class="messages-reply"><div class="messages-date">2011-11-11</div> </div></div>';
				//$(this).parent().append(reply);
				var h =$(this).siblings('div').last().offset().top;
				$('html,body').animate({scrollTop:h-20},120);
				$(this).prev().find('.replyComment').val('');
			}else{
				alert("亲，不能玩我啊!");
			}
			//var reply ='<div class="messages-replyBox"><div class="messages-replyBox-avatar"><a href=""><img src="../images/test.png"/></a></div><p><span class="messages-replyBox-name"><span>葫芦娃</span></span>'+replyText+'。<span><a href="#reply">回复<span></span></a></span></p><div class="messages-reply"><div class="messages-date">2013-02-04 01:47:19</div> </div></div>';
			//$(this).parent().append(reply);
			//var h =$(this).siblings('div').last().offset().top;
			//$('html,body').animate({scrollTop:h-120},120);
			//$(this).prev().find('.replyComment').val('');
		});
});
});



function getReply(id,num,page,_this){
	
	$.ajax({
		   type: "POST",
		   url: "index.php?c=commentajax&m=reply2",
		   data: "action=reply&id="+id+"&page="+page+"&num="+num+"",
		   dataType:'json',
		   success: function(msg){
				if(msg.status){
					var content = msg.content;
					if(content.content){
						
					  for(var key in content.content){
					    var con = content.content[key];
							var reply ='<div class="messages-replyBox"><div class="messages-replyBox-avatar"><a  target="_blank" href="http://202.202.43.125/online/home.php?mod=space&uid='+con.articlecomment_user+'"><img src="'+msg.uc_api+'/avatar.php?uid='+con.articlecomment_user+'&size=big"/></a></div><p><span class="messages-replyBox-name">'+con.articlecomment_realname+':</span>'+con.articlecomment_content+'<span><a href="#reply">&nbsp回复<span></span></a></span></p><div class="messages-reply"><div class="messages-date">'+con.articlecomment_time+'</div> </div></div>';
							_this.append(reply);
						}
						if(content.lastNum>0){
							$("#viewMore"+content.id+"").html("<a href='javascript:test("+content.id+","+content.page+","+num+")'>显示剩余"+content.lastNum+"条回复</a>")
						}else{
							$("#viewMore"+content.id+"").html('');
						}
						//alert(content.lastNum);
					}else{
						
					}
				}else{
					return false;
				}
		   }
		});
}

function insertReply(id,uid,content,_this){
	$.ajax({
		   type: "POST",
		   url: "index.php?c=commentajax&m=submsg",
		   //data: "action=replyMsg&id="+id+"&content="+content+"&userId="+uid+"",
			data: "content="+content+"&action=submit&userId="+uid+"&isHidden=false&contentId="+id+"",
		    
		  dataType:'json',
		   success: function(msg){
		  // alert(msg);
				if(msg.status){
					var reply ='<div class="messages-replyBox"><div class="messages-replyBox-avatar"><a  target="_blank" href="http://202.202.43.125/online/home.php?mod=space&uid='+msg.uid+'"><img src="'+msg.url+'"/></a></div><p><span class="messages-replyBox-name">'+msg.user+':</span>'+msg.content+'<span><a href="#reply">回复<span></span></a></span></p><div class="messages-reply"><div class="messages-date">'+msg.time+'</div> </div></div>';
				$(_this).append(reply);
				}else{
					if(msg.errorId==0){
						alert("请先登录!");
					}else{
						alert("评论失败！");
					}
				}
		   }
		});

}
function test(id,page,num){
	getReply(id,num,page,$("#viewMore"+id+"").prev());
	
}



