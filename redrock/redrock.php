<?
/*

	author:lx
*/
//echo dirname(__FILE__);

require(RD."/function/redrock_function.php");//包含框架公用函数库

file_exists(RD_APP."config/config.inc.php") ? $config = require(RD_APP."config/config.inc.php") : trigger_error("配置文件不存在!");

$GLOBALS['redrock_app_config'] = redrock_ReadConfig($config,$rdConfig);

header("Content-Type:text/html;charset=".$GLOBALS['redrock_app_config']['charset']['default']."");//编码设置

date_default_timezone_set("".$GLOBALS['redrock_app_config']['timezone']['default'].""); //系统时间格式
if($GLOBALS['redrock_app_config']['is_turn_session']){
	if(!isset($_SESSION)){
		session_start();
	}
}else{
	if(isset($_SESSION)){
		session_destroy();
	}
}
if($GLOBALS['redrock_app_config']['DEBUG']){
	import(RD."/core/debug.class.php");//包含debug类
	debug::start();
	set_error_handler(array("debug", 'setHandler'));
	if( substr(PHP_VERSION, 0, 3) == "5.3" ){
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
	}else{
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	}
}else{
	error_reporting(0);
	ini_set('display_errors', 'Off'); 		//屏蔽错误输出
	if($GLOBALS['redrock_app_config']['isLog']){
		ini_set('log_errors', 'On');            //开启错误日志，将错误报告写入到日志中
		ini_set('error_log',$GLOBALS['redrock_app_config']['logPath']); //指定错误日志文件
	}else{
		ini_set('log_errors', 'Off');
	}	
}

$include_path=get_include_path();
$include_path.=combine_include_path($GLOBALS['redrock_app_config']['include_path']).combine_include_path($GLOBALS['redrock_app_config']['ext_include_path']).combine_include_path($GLOBALS['redrock_app_config']['controls_runtime_path']);
set_include_path($include_path);

//自动加载类 	
function __autoload($className){
	if($className=="memcache"){   
		return ;
	}else if($className=="Smarty"){ 
		import(rtrim($GLOBALS['redrock_app_config']['smarty']['smarty_path'],'/')."/Smarty.class.php");
	}else{ 
		//if($GLOBALS['redrock_app_config']['class_postfix']['enabled']){
		//	echo $className = "".strtolower($className).".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.')."";
		//}
		import($className);
		//die(1111111111111);
	}
}
//modeltest::in();
$GLOBALS['redrock_app_config'][md5('action_c')]=isset($_GET[$GLOBALS['redrock_app_config']['redrock_action']['control_action']])? $_GET[$GLOBALS['redrock_app_config']['redrock_action']['control_action']] : $GLOBALS['redrock_app_config']['redrock_action']['control_action_name'];
$GLOBALS['redrock_app_config'][md5('action_m')]=isset($_GET[$GLOBALS['redrock_app_config']['redrock_action']['module_action']])? $_GET[$GLOBALS['redrock_app_config']['redrock_action']['module_action']] : $GLOBALS['redrock_app_config']['redrock_action']['module_action_name'];
$GLOBALS['redrock_app_config'][md5('action_v')]=isset($_GET[$GLOBALS['redrock_app_config']['redrock_action']['view_action']])? $_GET[$GLOBALS['redrock_app_config']['redrock_action']['view_action']] : $GLOBALS['redrock_app_config']['redrock_action']['view_action_name'];

$controlerfile=rtrim($GLOBALS['redrock_app_config']['include_control_path']['default'],'/')."/".strtolower($GLOBALS['redrock_app_config'][md5('action_c')]).".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.')."";
//test2::say();
if(file_exists($controlerfile)){
	import('struct');
	import("rd_controls");
	struct::root_control();
	struct::action_control($controlerfile,$GLOBALS['redrock_app_config'][md5('action_c')]);
	$className = strtolower($GLOBALS['redrock_app_config'][md5('action_c')])."Action";
	$app = new $className();
	debug::addMsg("	<td style='width:33%;color: #666666;'>当前访问控制器类文件:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".$controlerfile."</span>&nbsp;</td>",'base');
	$app->startRun();
}else{
	debug::addMsg("	<td style='width:33%;color: #666666;'>当前访问控制器类文件:&nbsp;&nbsp;<span style='color: red;font-weight: bold;'>".$controlerfile."不存在</span>&nbsp;</td>",'base');
	trigger_error("控制器类文件".$GLOBALS['redrock_app_config'][md5('action_c')].".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.')."不存在，请查看目录".$GLOBALS['redrock_app_config']['include_control_path']['default']."");
}
//print_r($GLOBALS['redrock_app_config']['static_config']);
if($GLOBALS['redrock_app_config']['DEBUG']){
	debug::addMsg("	<td style='width:33%;color: #666666;'>session:".($GLOBALS['redrock_app_config']['is_turn_session']? "&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>开启 [会话ID:".session_id()."]</span>&nbsp;": "&nbsp;&nbsp;<span style='color: red;font-weight: bold;'>未开启</span>&nbsp;")."</td>",'base');
	
	debug::end();
	
	debug::message();
}

?>