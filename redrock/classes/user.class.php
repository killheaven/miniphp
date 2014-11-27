<?php
class user{

    public  $userId  = null;
    public $userName= null;
    private $userPwd = null;
    private $userType= null;
	private $userLock= null;
    private static $is_login = false;
    function  __construct($userName,$userPwd) 
	{
		
			list($uid, $username, $password, $email,$unkownfield, $usernumber, $realname, $usertype) = uc_user_login($userName,$userPwd);
			if ($uid <0 ) {
				list($uid, $username, $password, $email,$unkownfield, $usernumber, $realname, $usertype) = uc_user_login($userName,$userPwd,3);
			}
			if($uid > 0)
			{
				$this->userId   = $uid;
				$this->userName = $username;
				$this->userPwd  = "";
				$this->userType = $usertype;
				
				$this->addUser($uid,$username,$usertype,$realname,$email,$usernumber,$usertype);
			}
		}

	private function addUser($uid,$username,$usertype,$realname,$email,$usernumber,$usertype){
		$db = D();
		$sql = "select * from user where user_id = '$uid'";
		//$re = $db -> query($sql);
		if($db->rowNum($sql)<1){
			$lock='no';
			$sql = "insert into user (`user_id`,`user_name`,`user_type`,`user_lock`,`user_real_name`,`user_email`,`user_number`,`user_last_time`) values ('$uid','$username','$usertype','$lock','$realname','$email','$usernumber','".date("Y-m-d H:i:s")."')";
			if($db -> query($sql)){
				$this->userLock = $lock;
			}
		}
	}

	public static function login($userName,$userPwd) 
	{
		$user_name=trim($userName);
        if(empty($userName)|| empty($userPwd)) 
		{
            return null;
		}
		else 
		{	
			$user = new User($userName,$userPwd);
			if(!is_null($user->userId))
			{
				if($user->userLock=="yes")
				{
					return "-1";
				}
				$dateNow = date("Y-m-d");
				$db=D();
				$sql = "update user set `user_last_time`='$dateNow' where `user_last_time`<>'$dateNow' and `user_id`=".$user->userId;
				//$re = $db->query($sql);
				$is_today_first_login = false;
				if($db->affectedRows($sql)>0)
				{	
					$is_today_first_login = true;	
				}
				
				self::$is_login = true;
				return array
				(
					"userId"  =>$user->userId,
					"userName"=>gbkToUtf8($user->userName),
					"is_today_first_login"=>$is_today_first_login
				);
			}
			else
			{
				return null;	
			}	
        }
    }
	
		static function userLogin($user,$password,$time=24){
		
		$status = user::login($user,$password);
		if(is_array($status)){
			setcookie("username",$user,time()+3600*$time*30);
			setcookie("userpwd",uc_authcode($password,"CODE"),time()+3600*$time*30);
			$_SESSION['username']=$status['userName'];
			$_SESSION['uid']=$status['userId'];
			return $status;
		}else if(is_null($status)){
			return null;
		}else{
			return -1;
		}
		print_r($status);
	}

		static function userQuit(){
			setcookie("username","",time()-1);
			setcookie("userpwd","",time()-1);
			//unset($_SESSION['user']);
			session_destroy();
		}

}



?>