<?php
define("APP_DIRECTORY","home");//���岻ͬ�û�����Ŀ¼  û�ж���Ͳ���Ҫ
define('DS',DIRECTORY_SEPARATOR);//ϵͳ�ֽ��
define("RD", "./redrock");  //���Դ�ļ���λ��
define("RD_APP", "./");           //���õ�ǰӦ�õ�Ŀ¼
include_once dirname(__FILE__)."/config.inc.php";
include_once dirname(__FILE__)."/uc_client/client.php";

$rdConfig=array(
	"charset"=>array(
		"default"=>'utf-8',
	)
);
require(RD.'/redrock.php'); //���ؿ�ܵ�����ļ�

?>