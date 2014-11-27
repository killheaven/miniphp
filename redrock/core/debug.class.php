<?php

class debug{
	static $startTime;        
	static $endTime;
	static $includefile=array();
	static $baseMsg=array();
	static $info=array();
	static $sqls=array();
	static $msg = array(
       			 E_WARNING=>'运行时警告',
       			 E_NOTICE=>'运行时提醒',
        		 E_STRICT=>'编码标准化警告',
        		 E_USER_ERROR=>'自定义错误',
        		 E_USER_WARNING=>'自定义警告',
        		 E_USER_NOTICE=>'自定义提醒',
        		 'Unkown '=>'未知错误'
		 );
	
	static function start(){
		self::$startTime = microtime(true);
	}
	
	static function end(){
		self::$endTime = microtime(true);
	}
	
	static function getMistiming(){
		return round((self::$endTime - self::$startTime) , 4);
	}
	
	static function addMsg($msg,$debugType='info'){
		if($GLOBALS['redrock_app_config']['DEBUG']){
			switch($debugType){
				case 'info':
					self::$info[]=$msg;
					break;
				case 'file':
					self::$includefile[]=$msg;
					break;
				case 'sql':
					self::$sqls[]=$msg;
					break;
				case 'base':
					self::$baseMsg[]=$msg;
					break;
			}
		}
	}
	
	static function baseMsg(){
		if($GLOBALS['redrock_app_config']['DEBUG']){
			switch($debugType){
				case 'base':
					self::$info[]=$msg;
					break;
				case 'file':
					self::$includefile[]=$msg;
					break;
				case 'sql':
					self::$sqls[]=$msg;
					break;
				
			}
		}
	}
	
	/*
	static function setHandler($errno, $errstr, $errfile, $errline)
	{
		if (!(error_reporting() & $errno)) {
			// This error code is not included in error_reporting
			return;
		}

		switch ($errno) {
		case E_USER_ERROR:
			echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
			echo "  Fatal error on line $errline in file $errfile";
			echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			echo "Aborting...<br />\n";
			exit(1);
			break;

		case E_USER_WARNING:
			echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
			break;

		case E_USER_NOTICE:
			echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
			break;

		default:
			echo "Unknown error type: [$errno] $errstr<br />\n";
			break;
		}

		
		return true;
	}*/
	static function setHandler($errno, $errstr, $errfile, $errline){
			//echo basename($errfile)."<br>";
			//echo $errfile."<br>";
			//$test =  "/var/www/luoxiang/newmvc/run/models/home/TestModels.class.php";
			//echo $GLOBALS['redrock_app_config']['include_file_true_path'][md5(basename($errfile))];
			//echo ltrim($GLOBALS['redrock_app_config']['include_file_true_path'][md5(basename($errfile))],'.');
			//echo str_replace('/',DIRECTORY_SEPARATOR,ltrim($GLOBALS['redrock_app_config']['include_file_true_path'][md5(basename($errfile))],'.'));
	   		if(empty($GLOBALS['redrock_app_config']['include_file_true_path'][md5(basename($errfile))])){
				$tureFile = $errfile;
			}else{
				$tureFile = dirname($_SERVER['SCRIPT_FILENAME']).ltrim($GLOBALS['redrock_app_config']['include_file_true_path'][md5(basename($errfile))],'.');
			}
			if(!isset(self::$msg[$errno])) 
				$errno='Unkown';

			if($errno==E_NOTICE || $errno==E_USER_NOTICE)
				$color="#000088";
			else
				$color="red";
			$mess="<p style='padding-left:30px;font-family: Microsoft Yahei,Verdana,arial,sans-serif;'>
					<strong><span style='color: red;font-weight: bold;'>".self::$msg[$errno]."</span>:&nbsp;".$errstr."&nbsp;&nbsp;</strong>
					
					<strong><span style='color: red;font-weight: bold;'>错误位置</span></strong>
					FILE:
					<span style='color: red;font-weight: bold;'>".$tureFile."</span>
					LINE:
					<span style='color: red;font-weight: bold;'>".$errline."</span>
				</p>";
			$souceline=getsource($errfile,$errline);
			$mess.="<div style='border: 4px solid #E7F7FF;font: 14px/23px Arial,Helvetica,sans-serif;margin: 0 30px 20px;padding: 10px 20px;'>";
			foreach( $souceline as $singleline ){ $mess.=$singleline;}
			$mess.="</div>";
	   		/*$mess='<font color='.$color.'>';
	   		$mess.='<b>'.self::$msg[$errno]."</b>[在文件 {$errfile} 中,第 $errline 行]:";
	   		$mess.=$errstr;
	   		$mess.='</font>'; 	*/	
	  		self::addMsg($mess);
		}
	static function message(){
			echo "<div style='clear:both;padding:10px;margin:5px;border:1px solid #E0E0E0;background: none repeat scroll 0 0 #FCFCFC;font-size:14px;font-family: Microsoft Yahei,Verdana,arial,sans-serif;'>
				  <h2 style='padding: 8px 0;font-size: 25px;border-bottom: 1px solid #DDDDDD;color: #666666;'>系统调试信息</h2>
				 ";
			echo "<p style='color:#FF6600;font-weight: bold;margin: 4px 0;font-family: Microsoft Yahei,Verdana,arial,sans-serif;'>[ 运行信息 ]&nbsp;&nbsp;<span style='color: #666666;'><strong>消耗时间</strong>(<span style='color: red;font-weight: bold;'>".self::getMistiming()."</span>秒)</span></p>";
			echo "
			<p style='padding-left:30px;font-family: Microsoft Yahei,Verdana,arial,sans-serif;color:#FF6600;font-weight: bold;margin: 4px 0;'>基本信息</p>
			<div style='_width:100%;border: 4px solid #E1E1E1;font: 14px/23px Arial,Helvetica,sans-serif;margin: 0 30px 20px;padding: 10px 20px;'>
				<table style='width:100%;font-family: Microsoft Yahei,Verdana,arial,sans-serif;font-size:12px'>
					<tr>
						<td style='width:33%;color: #666666;'>操作系统:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".PHP_OS."</span>&nbsp;</td>
						<td style='width:33%;color: #666666;'>服务器版本:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".apache_get_version()."</span>&nbsp;</td>
						<td style='width:33%;color: #666666;'>数据库版本:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>mysql-".@mysql_get_server_info()."</span>&nbsp;</td>
					</tr>
					<tr>
						<td style='width:33%;color: #666666;'>最大表单提交大小:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".ini_get('post_max_size')."</span>&nbsp;</td>
						<td style='width:33%;color: #666666;'>上传目录是否可写:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".(is_writable('./')?('可写'):('不可写'))."</span>&nbsp;</td>
						<td style='width:33%;color: #666666;'>最大上传大小:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".ini_get('upload_max_filesize')."</span>&nbsp;</td>
					</tr>
					<tr>
						<td style='width:33%;color: #666666;'>服务器所在时间:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".date("Y-m-d H:i:s")."</span>&nbsp;</td>
						<td style='width:33%;color: #666666;'>调试模式:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>开启</span>&nbsp;</td>
						<td style='width:33%;color: #666666;'>最大执行时间:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".ini_get('max_execution_time')."s</span>&nbsp;</td>
					</tr>";
			if(count(self::$baseMsg) > 0){
				
				$i=1;
				echo "<tr>";
				foreach(self::$baseMsg as $file){
					
					echo $file;
					if( $i%3 == 0){
						echo "</tr><tr>";
					}
					$i++;
				}
				echo "</tr>";
				
			}		
					
			/*echo "	<tr>
						<td style='width:33%;color: #666666;'>当前访问控制器文件:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".$GLOBALS['redrock_app_config'][md5('action_c')].".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.')."</span>&nbsp;</td>
						<td style='width:33%;color: #666666;'>当前访问控制器模块:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>开启</span>&nbsp;</td>
						<td style='width:33%;color: #666666;'>当前访问控制器HTML模版:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".ini_get('max_execution_time')."s</span>&nbsp;</td>
					</tr>";*/
			echo "</table>
			</div>";	 
			
					
			if(count(self::$sqls) > 0) {
				echo "<p style='padding-left:30px;font-family: Microsoft Yahei,Verdana,arial,sans-serif;color:#FF6600;font-weight: bold;margin: 4px 0;'>SQL信息</p>
					  <div style='_width:100%;border: 4px solid #E1E1E1;font: 14px/23px Arial,Helvetica,sans-serif;margin: 0 30px 20px;padding: 10px 20px;'>
					  <table style='width:100%;font-family: Microsoft Yahei,Verdana,arial,sans-serif;font-size:12px'>
					 ";
				foreach(self::$sqls as $sql){
					echo $sql;
				}
				echo "</table></div>";
			}	 
			if(count(self::$includefile) > 0){
				echo "";
				echo "<p style='padding-left:30px;font-family: Microsoft Yahei,Verdana,arial,sans-serif;color:#FF6600;font-weight: bold;margin: 4px 0;'>载入信息</p>
					  <div style='_width:100%;border: 4px solid #E1E1E1;font: 14px/23px Arial,Helvetica,sans-serif;margin: 0 30px 20px;padding: 10px 20px;'>
					  <table style='width:100%;font-family: Microsoft Yahei,Verdana,arial,sans-serif;font-size:12px'>
					 ";
				foreach(self::$includefile as $file){
					echo $file;
				}
				echo "</table></div>";
			}
			
			if(count(self::$info) > 0 ){
				echo "<p style='color:#FF6600;font-weight: bold;margin: 4px 0;'>[ 提示信息 ]</p>";
				foreach(self::$info as $info){
					echo ''.$info.'';
				}
			}

			
			echo '</div>';	
	}
	
	public function __destruct()
	{
		@mysql_close($this->$rd_mysql);
	}
	
}

function getsource($file, $line){
	if (!(file_exists($file) && is_file($file))) {return '';}
	$data = file($file);$count = count($data) - 1;
	$start = $line - $GLOBALS['redrock_app_config']["redrock_error_show_source"];if ($start < 1) {$start = 1;}
	$end = $line + $GLOBALS['redrock_app_config']["redrock_error_show_source"];if ($end > $count) {$end = $count + 1;}
	$returns = array();
	for ($i = $start; $i <= $end; $i++) {
		if( $i == $line ){
			$returns[] = "<div style='background:#CFF0F3'>".$i.".&nbsp;".highlight_code($data[$i - 1], TRUE)."</div>";
		}else{
			$returns[] = $i.".&nbsp;".highlight_code($data[$i - 1], TRUE);
		}
	}
	return $returns;
}
function highlight_code($code){
    if (ereg("<\?(php)?[^[:graph:]]", $code)) {
        $code = highlight_string($code, TRUE);
    } else {
        $code = ereg_replace("(&lt;\?php&nbsp;)+", "", highlight_string("<?php ".$code, TRUE));
    }
    return $code;
}



?>
