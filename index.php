<?php
define("APP_DIRECTORY","home");//定义不同用户程序目录  没有定义就不需要
define('DS',DIRECTORY_SEPARATOR);//系统分界符
define("RD", "./redrock");  //框架源文件的位置
define("RD_APP", "./");           //设置当前应用的目录
include_once dirname(__FILE__)."/config.inc.php";
include_once dirname(__FILE__)."/uc_client/client.php";

$rdConfig=array(
	"charset"=>array(
		"default"=>'utf-8',
	)
);
require(RD.'/redrock.php'); //加载框架的入口文件

?>