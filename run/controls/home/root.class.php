<?php
class root extends rd_controls {
	function in(){
		//print_r($_SESSION);
		if(isset($_SESSION['username'])){
			$this->assign("isLogin",true);
			$this->assign("userUid",$_SESSION['uid']);
			$this->assign("userName",$_SESSION['username']);
			$this->assign("HeadUrl",UC_API."/avatar.php?uid=".$_SESSION['uid']."&size=");
		}else{
			if(@$_COOKIE['username'] && @$_COOKIE['userpwd']){
				@$user=user::userLogin($_COOKIE['username'],uc_authcode($_COOKIE['userpwd']));
				if(is_array($user)){
					$this->assign("isLogin",true);
					$this->assign("userUid",$_SESSION['uid']);
					$this->assign("userName",gbkToUtf8($_SESSION['username']));
					
					$this->assign("HeadUrl",UC_API."/avatar.php?uid=".$_POST['userId']."&size=");
				}else{
					user::userQuit();
					$this->assign("isLogin",false);
				}
			}
		}
		if(isset($_SESSION['gustname'])){
			$this->assign("gustName",$_SESSION['gustname']);
		}
	
		$this->assign("UC_API",UC_API);
	//	echo "<script> var loginIs = 'true';</script>";
		
		
	}
}

?>