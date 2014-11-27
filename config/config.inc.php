<?php
return array(

	"isLog"=>false,
	
	"logPath"=>"".RD_APP."log/log_log",//错误日志
	
	"DEBUG"=>true,//debug开关
	
	"is_turn_session"=>true,//debug开关
	"ip_address"=>'http://202.202.43.41/jsns',
	"charset"=>array(
		"default"=>'utf-8',//编码
	),
	
	"timezone"=>array(
		"default"=>'PRC',//时区
	),
	
	"rd_database_config"=>array(
		"default"=>array(
			"host"=>"localhost",
			"database"=>"jsns2013",
			"user"=>"redrock",
			"passwd"=>"hongyanredrock",
			"charset"=>"gbk",
		),
		/*"uc"=>array(
			"host"=>"localhost",
			"database"=>"test",
			"user"=>"root",
			"passwd"=>"",
			"charset"=>"utf-8",
		),*/
	),
	"rd_database_config_default"=>'default',//默认数据库
	
	"rd_database_driver"=>"mysql",//数据库驱动
	
	'tpl_postfix'=>'html',
	
	'smarty' => array( // smarty配置
		'enabled' => true, // smarty配置开启开关
		'smarty_path'=>"".RD_APP."redrock/driver/smarty",//smarty的路径
		'config' =>array(
			'template_dir' => RD_APP.ltrim(((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : ''),'/')."/views", // 模板目录
			'compile_dir' => RD_APP.'run/smartyComplie'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."", // 编译目录
			'cache_dir' => RD_APP.'run/smartyCache'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."", // 缓存目录
			'left_delimiter' => '<{',  // smarty左限定符
			'right_delimiter' => '}>', // smarty右限定符
			'cache_lifetime' => 60, // 缓存时间
			'caching' => false, // 缓存开关
			'auto_literal' => TRUE, // Smarty3新特性
		)
	),
	'upload_config'=>array(
		"is_time_path"=>true,
		"default_path"=>RD_APP.'upload'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."",
	),
	'static_config'=>array(
		"js_path"=>RD_APP.'static/js'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."",
		"pjs_path"=>RD_APP.'static/js/redrock_public',
		"css_path"=>RD_APP.'static/css'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."",
		"pcss_path"=>RD_APP.'static/css/redrock_public',
		"images_path"=>RD_APP.'static/images'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."",
		"pimages_path"=>RD_APP.'static/images/redrock_public',
		"other_path"=>RD_APP.'static/other'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."",
		"plugin_path"=>RD_APP.'static/plugin',
	),
	"redrock_action"=>array(
		"control_action"=>"c",
		"control_action_name"=>"index",
		"module_action"=>"m",
		"module_action_name"=>"index",
		"view_action"=>"v",
		"view_action_name"=>"index",
	),
	
	"redrock_root_file"=>"".rtrim(RD_APP,'/').((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."/controls/root.class.php",//同意权限文件
	
	"redrock_error_show_source"=>4,
	/*
	"is_app_path"=>array(
		"enabled"=>true,//是否开启
		"user_directory"=>array(
			'1'=>'home',
		),//用户目录名
	),
	*/
	"ext_include_path"=>array(//扩张类包含path import需要的类
		"0"=>"".RD_APP."classes",//扩展类
		"1"=>"".RD_APP."redrock/classes",//框架扩展类目录
		"2"=>"".RD_APP."redrock/driver",//各种驱动目录
	),
	
	"include_path"=>array(//import需要的类
		'default'=>"".RD."/core",//默认的基类目录
		'import'=>array(
			"0"=>"".RD."/debug",
		),
	),
	
	"include_model_path"=>array(
		'default'=>"".rtrim(RD_APP,'/').((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."/models",//默认
		'other'=>array(
		
		),
	),
	
	"include_control_path"=>array(
		'default'=>"".rtrim(RD_APP,'/').((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."/controls",//默认
		'other'=>array(
		
		),
	),
	
	"include_view_path"=>array(
		'default'=>"".rtrim(RD_APP,'/').((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."/views",//默认
	),
	
	"controls_runtime_path"=>array(
		"controls"=>RD_APP.'run/controls'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."", // controls运行目录,
		"models"=>RD_APP.'run/models'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."", 
	),
	
	"class_postfix"=>array(
		"enabled"=>true,//必须开启
		"postfix"=>".class.php",
	),
);

?>