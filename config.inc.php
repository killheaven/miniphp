<?php

				// ���� UCenter �ķ�ʽ: mysql/NULL, Ĭ��Ϊ��ʱΪ fscoketopen()
							// mysql ��ֱ�����ӵ����ݿ�, Ϊ��Ч��, ������� mysql

//���ݿ���� (mysql ����ʱ, ����û������ UC_DBLINK ʱ, ��Ҫ�������±���)
/*define('UC_DBHOST', 'localhost');			// UCenter ���ݿ�����
define('UC_DBUSER', 'root');				// UCenter ���ݿ��û���
define('UC_DBPW', '070050');					// UCenter ���ݿ�����
define('UC_DBNAME', 'ucenter');				// UCenter ���ݿ�����
define('UC_DBCHARSET', 'gbk');				// UCenter ���ݿ��ַ���
define('UC_DBTABLEPRE', 'killheaven_uc_');			// UCenter ���ݿ��ǰ׺

//ͨ�����
define('UC_KEY', '123456789');				// �� UCenter ��ͨ����Կ, Ҫ�� UCenter ����һ��
define('UC_API', 'http://localhost/ucenter');	// UCenter �� URL ��ַ, �ڵ���ͷ��ʱ�����˳���
define('UC_CHARSET', 'gbk');				// UCenter ���ַ���
define('UC_IP', '');					// UCenter �� IP, �� UC_CONNECT Ϊ�� mysql ��ʽʱ, ���ҵ�ǰӦ�÷�������������������ʱ, �����ô�ֵ
define('UC_APPID', 3);					// ��ǰӦ�õ� ID
*/
//ucexample_2.php �õ���Ӧ�ó������ݿ����Ӳ���
/*
$dbhost = 'localhost';			// ���ݿ������
$dbuser = 'root';			// ���ݿ��û���
$dbpw = '070050';				// ���ݿ�����
$dbname = 'jsns2013';			// ���ݿ���
$pconnect = 0;				// ���ݿ�־����� 0=�ر�, 1=��
$tablepre = 'uc_';   		// ����ǰ׺, ͬһ���ݿⰲװ�����̳���޸Ĵ˴�
$dbcharset = 'gbk';			// MySQL �ַ���, ��ѡ 'gbk', 'big5', 'utf8', 'latin1', ����Ϊ������̳�ַ����趨

//ͬ����¼ Cookie ����
$cookiedomain = ''; 			// cookie ������
$cookiepath = '/';			// cookie ����·��*/
define('UC_CONNECT', '');
define('UC_DBHOST', '');
define('UC_DBUSER', '');
define('UC_DBPW', '');
define('UC_DBNAME', '');
define('UC_DBCHARSET', 'gbk');
define('UC_DBTABLEPRE', '`ucenter`.uc_');
define('UC_DBCONNECT', '0');
define('UC_KEY', '');
define('UC_API', '');
define('UC_CHARSET', 'gbk');
define('UC_IP', '');
define('UC_APPID', '29');
define('UC_PPP', '20');
