<?php /* Smarty version 2.6.18, created on 2014-11-27 11:27:17
         compiled from index.html */ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['CSS']; ?>
/main.css">
<script  type="text/javascript" src="<?php echo $this->_tpl_vars['PJS']; ?>
/jquery-1.8.2.min.js"></script>
<script>
	if($.browser.msie&&($.browser.version == '6.0')||$.browser.version=='7.0'){
		window.location.href="support.html";
	}
</script>
</head>
<body>
<div id="mask"></div>
<div id="loginBox">
	<div id="loginBox-title">登录
  	<!--<span id="loginBox-close"></span>-->
  </div>
<!--  <form action='index.php?c=ajax&m=login' method="POST">-->
  	<div>
    	<img src="<?php echo $this->_tpl_vars['IMG']; ?>
/user.png" />
    	<input type="text" name='username' id="login-input">
    </div>
    <div>
    	<img src="<?php echo $this->_tpl_vars['IMG']; ?>
/password.png" />
    	<input type="password" name='userpwd' id="login-password">
    </div>
    <div id="login-register">
		
		<a href="http://202.202.43.125/user/register" id="login-register-text">注册</a> | <a href="http://202.202.43.125/user/resetpassword">忘记密码</a>
    </div>
    <input type="submit" value="登录" name='do' id="login-button" onclick='login()'/>
 <!-- </form>-->

</div>

<div id="wrapper">
  <div id="logo">
  	<!--<p>锦瑟</p>
    <p>南山</p>
    <span>原创作品展示平台</span>-->
  </div>
  <div id="navBlock">
    <div style="background:url(<?php echo $this->_tpl_vars['IMG']; ?>
/c_03.png);"></div>
  	<div id='test' style="left:106px;top:-106px;background:url(<?php echo $this->_tpl_vars['IMG']; ?>
/b_00.png);">
    	<a href='index.php?c=literature' ><div class="navBlock-shade"></div></a>
    </div>
    <div style="left:106px;top:106px;background:url(<?php echo $this->_tpl_vars['IMG']; ?>
/c_06.png);"></div>
    <div style="left:212px;background:url(<?php echo $this->_tpl_vars['IMG']; ?>
/b_01.png);">
    	<a href='index.php?c=photo' ><div class="navBlock-shade"></div></a>
    </div>
    <div style="left:318px;top:106px;background:url(<?php echo $this->_tpl_vars['IMG']; ?>
/b_02.png);">
    	<a href='index.php?c=read' ><div class="navBlock-shade"></div></a>
    </div>
    <div style="left:424px;background:url(<?php echo $this->_tpl_vars['IMG']; ?>
/b_03.png);">
    	<a href='index.php?c=movie' ><div class="navBlock-shade"></div></a>
    </div>
	<?php if ($this->_tpl_vars['isLogin']): ?>
    <div id="index-login" style="left:530px;top:106px;background:url(<?php echo $this->_tpl_vars['IMG']; ?>
/c_09.png);">
		<!--<span id="logins" class='login'>您好</span> -->
        <span id="registers" onclick="window.location.href='index.php?c=personal'"><?php echo $this->_tpl_vars['userName']; ?>
</span>
	<?php else: ?>
	<div id="index-login" style="left:530px;top:106px;background:url(<?php echo $this->_tpl_vars['IMG']; ?>
/c_08.png);">
		<span id="login" class='login'></span> 
        <span id="register"></span>
	<?php endif; ?>
    	<div></div>
    </div>
    <div style="left:530px;top:-106px;background:url(<?php echo $this->_tpl_vars['IMG']; ?>
/b_04.png);">
      <a href='index.php?c=corporation' ><div class="navBlock-shade"></div></a>
    </div>
    <div style="left:636px;background:url(<?php echo $this->_tpl_vars['IMG']; ?>
/b_05.png);">
    	<a href='index.php?c=messages' ><div class="navBlock-shade"></div></a>
    </div>
  </div>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
<script>
$(document).ready(function(){
	for(var i=0;i<$('.navBlock-shade').length;i++){
		(function(i){                     //闭包
			$('.navBlock-shade').eq(i).mouseover(function(){
					$('.navBlock-shade').eq(i).parent().parent().css({'background':'url(<?php echo $this->_tpl_vars['IMG']; ?>
/b_0'+i+'hover.png)'});
			}).mouseout(function(){
					$('.navBlock-shade').eq(i).parent().parent().css({'background':'url(<?php echo $this->_tpl_vars['IMG']; ?>
/b_0'+i+'.png)'});	
			});
		})(i);
	}
});		
	 //登录框
    $('#login').bind('click',function(){
		$('#mask').fadeIn();
		$('#loginBox').css({
			left:($(window).width() - $('#loginBox').outerWidth())/2,
			top: ($(window).height() - $('#loginBox').outerHeight())/2 + $(document).scrollTop()
		}).fadeIn();
		
	});
	$('#loginBox').keydown(function(e){
		if(e.keyCode == 13){
			login();
		}
	});
		$('#loginBox input').bind('focus',function(){
			$(this).css({background:'#d2efd7'});
		}).bind('focusout',function(){
			$(this).siblings('img').fadeIn();
			$(this).css({background:'#eaffee'});
		});
		$('#mask').bind('click',function(){
			$('#mask').fadeOut();
			$('#loginBox').fadeOut();
		});
	function login(){
		
		var u=$("#login-input").val();
		var p=$("#login-password").val();
		$.ajax({
		   type: "POST",
		   url: "index.php?c=ajax&m=login",
		   data: "username="+u+"&userpwd="+p+"&do=login",
		   dataType:'json',
		   success: function(msg){
				if(msg){
					$('#login').remove();
					//$("#nav-personal").append(""+msg.userName+"<a href='javascript:' onclick='quit()' style='color:red;padding:0px 10px'>注销</a>|<a href='"+msg.userId+"'>个人中心</a>");
					$('#register').text(msg.userName);
					$('#register').attr("style",'width:200px;text-align:center;left:0px');
					
					$('#register').attr('onclick',"window.location.href='index.php?c=personal'");
					$('#index-login').css('background','url(<?php echo $this->_tpl_vars['IMG']; ?>
/c_09.png)');
					$('#mask').fadeOut();
					$('#loginBox').fadeOut();
					//$('#login').unbind('click');
					//window.location.href='';
				}else{
					alert("帐号密码错误");
				}
			}
		});
	}

	function quit(){
		$.ajax({
		   type: "POST",
		   url: "index.php?c=ajax&m=quit",
		   data: "do=quit",
		   dataType:'json',
		   success: function(msg){
				if(msg){
					$("#nav-personal").html('');
					$("#nav-personal").append("<a href='javascript:void' id='nav-personal-login'>登录</a>|<a href='http://202.202.43.125/user/user.php' target='blank' id='nav-personal-register'>注册</a>");
					window.location.href='';
				}else{
					alert("退出失败！");
				}
			}
		});
	}

</script>
</html>