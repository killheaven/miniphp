<?php
return array(

	"isLog"=>false,
	
	"logPath"=>"".RD_APP."log/log_log",//������־
	
	"DEBUG"=>true,//debug����
	
	"is_turn_session"=>true,//debug����
	"ip_address"=>'http://202.202.43.41/jsns',
	"charset"=>array(
		"default"=>'utf-8',//����
	),
	
	"timezone"=>array(
		"default"=>'PRC',//ʱ��
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
	"rd_database_config_default"=>'default',//Ĭ�����ݿ�
	
	"rd_database_driver"=>"mysql",//���ݿ�����
	
	'tpl_postfix'=>'html',
	
	'smarty' => array( // smarty����
		'enabled' => true, // smarty���ÿ�������
		'smarty_path'=>"".RD_APP."redrock/driver/smarty",//smarty��·��
		'config' =>array(
			'template_dir' => RD_APP.ltrim(((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : ''),'/')."/views", // ģ��Ŀ¼
			'compile_dir' => RD_APP.'run/smartyComplie'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."", // ����Ŀ¼
			'cache_dir' => RD_APP.'run/smartyCache'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."", // ����Ŀ¼
			'left_delimiter' => '<{',  // smarty���޶���
			'right_delimiter' => '}>', // smarty���޶���
			'cache_lifetime' => 60, // ����ʱ��
			'caching' => false, // ���濪��
			'auto_literal' => TRUE, // Smarty3������
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
	
	"redrock_root_file"=>"".rtrim(RD_APP,'/').((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."/controls/root.class.php",//ͬ��Ȩ���ļ�
	
	"redrock_error_show_source"=>4,
	/*
	"is_app_path"=>array(
		"enabled"=>true,//�Ƿ���
		"user_directory"=>array(
			'1'=>'home',
		),//�û�Ŀ¼��
	),
	*/
	"ext_include_path"=>array(//���������path import��Ҫ����
		"0"=>"".RD_APP."classes",//��չ��
		"1"=>"".RD_APP."redrock/classes",//�����չ��Ŀ¼
		"2"=>"".RD_APP."redrock/driver",//��������Ŀ¼
	),
	
	"include_path"=>array(//import��Ҫ����
		'default'=>"".RD."/core",//Ĭ�ϵĻ���Ŀ¼
		'import'=>array(
			"0"=>"".RD."/debug",
		),
	),
	
	"include_model_path"=>array(
		'default'=>"".rtrim(RD_APP,'/').((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."/models",//Ĭ��
		'other'=>array(
		
		),
	),
	
	"include_control_path"=>array(
		'default'=>"".rtrim(RD_APP,'/').((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."/controls",//Ĭ��
		'other'=>array(
		
		),
	),
	
	"include_view_path"=>array(
		'default'=>"".rtrim(RD_APP,'/').((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."/views",//Ĭ��
	),
	
	"controls_runtime_path"=>array(
		"controls"=>RD_APP.'run/controls'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."", // controls����Ŀ¼,
		"models"=>RD_APP.'run/models'.((defined("APP_DIRECTORY") && APP_DIRECTORY) ? '/'.APP_DIRECTORY : '')."", 
	),
	
	"class_postfix"=>array(
		"enabled"=>true,//���뿪��
		"postfix"=>".class.php",
	),
);

?>