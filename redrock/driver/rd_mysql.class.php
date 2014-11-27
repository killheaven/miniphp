<?php
class rd_mysql extends rd_sql{
	static $rd_mysql=null;
	private $driver = null;
	static $resources=null;
	function __construct(){
		$driver=$GLOBALS['redrock_app_config']['rd_database_config_default'];
		if($driver && !empty($driver)){
			$this->driver=$driver;
			$this->connect();
		}else{
			debug::addMsg("	<td style='width:33%;color: #666666;'>当前访问".$GLOBALS['redrock_app_config']["rd_database_config"][$this->driver]['database']."数据库:&nbsp;&nbsp;<span style='color: red;font-weight: bold;'>失败[连接驱动:mysql]</span>&nbsp;</td>",'base');
		}
	}
	
	private function connect(){
		if(is_null(self::$rd_mysql)) {
			self::$rd_mysql = mysql_connect($GLOBALS['redrock_app_config']["rd_database_config"][$this->driver]['host'],$GLOBALS['redrock_app_config']["rd_database_config"][$this->driver]['user'],$GLOBALS['redrock_app_config']["rd_database_config"][$this->driver]['passwd']) or die('数据库链接错误!');
			mysql_select_db($GLOBALS['redrock_app_config']["rd_database_config"][$this->driver]['database']) or die('不存在这个数据库!');
			mysql_query("set names ".$GLOBALS['redrock_app_config']["rd_database_config"][$this->driver]['charset']."");
		}else{
			return self::$rd_mysql;
		}
		debug::addMsg("	<td style='width:33%;color: #666666;'>当前访问".$GLOBALS['redrock_app_config']["rd_database_config"][$this->driver]['database']."数据库:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>成功[连接驱动:mysql]</span>&nbsp;</td>",'base');
	}
	
	static function query($sql=''){
		if(empty($sql) || is_null($sql)){
			parent::combineSql();
			$sql=$this->sqls;
		}
		$f = __FUNCTION__;
		//print_r($f);
		/*$d = debug_backtrace();
		//print_r($d);
		//echo $d['2']['class'];
		$class = strtolower($d['1']['class']).".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.');
		$class = substr($class,0,strrpos($class,'models')).".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.');
		*/
		if($returns = mysql_query($sql)){
			$status='[<font color=green>执行成功</font>]';	
		}else{
			$status='[<font color=red>执行失败</font>] [<font color=red>'.mysql_error().'</font>]';
		}
		/*
		debug::addMsg("<tr><td style='width:25%;color: #666666;'>[<span style='color: red;font-weight: bold;'>".$class."</span>]&nbsp;[&nbsp;<span style='color: red;font-weight: bold;'>".$d['1']['function']."</span>&nbsp;]数据模块</td>
					   <td style='width:75%;color: #666666;'>sql语句:&nbsp;[&nbsp;<span style='color: green;font-weight: bold;'>".$sql."</span>&nbsp;]".$status."</td>
					   </tr>",'sql');
					   */
		debug::addMsg("<tr>
					   <td style='width:75%;color: #666666;'>sql语句:&nbsp;[&nbsp;<span style='color: green;font-weight: bold;'>".$sql."</span>&nbsp;]".$status."</td>
					   </tr>",'sql');
		return self::$resources=$returns;
	}
	
	function fetchArray($sql=null,$result_type = MYSQL_ASSOC){
		
		if($this->rowNum($sql)<1){
			return null;
		}
		if(is_string($sql)){
			$sql = $this->query($sql);
		}/*
		if(is_null($sql)){
			$sql=self::$resources;
		}*/
		return @mysql_fetch_array($sql,$result_type);	
	}
	function rowNum($sql=null){
		if(is_string($sql)){
			$sql = $this->query($sql);
		}
		
		return @mysql_num_rows($sql);
	}
	
	function fetchObject($sql=null){
		if($this->rowNum($sql)<1){
			return null;
		}
		if(is_string($sql)){
			$sql = $this->query($sql);
		}
		return @mysql_fetch_object($sql);	
	}
	
	function fetchAll($sql=null,$result_type = MYSQL_ASSOC){
		if($this->rowNum($sql)<1){
			return null;
		}
		if(is_string($sql)){
			$sql = $this->query($sql);
		}
		$array=array();
		while($arr = @mysql_fetch_array($sql,$result_type)){
			$array[] = $arr;
		}
		return $array;
	}
	function insertId(){	

		return  @mysql_insert_id();

	}
	
	function affectedRows($sql=null){
		if($this->rowNum($sql)<1){
			return null;
		}
		if(is_string($sql)){
			$sql = $this->query($sql);
		}
		return @mysql_affected_rows($sql);

	}
	function freeResult($rs){

		mysql_free_result($rs);
	}
		
	public function __destruct()
	{
		if(!$GLOBALS['redrock_app_config']['DEBUG']){
			@mysql_close(self::$rd_mysql);
		}
		//@mysql_close(self::$rd_mysql);
	}
}

	function zhui(){
			$d = debug_backtrace();
		print_r($d);
		
		$class = strtolower($d['1']['class']).".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.');
		$class = substr($class,0,strrpos($class,'models')).".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.');
		
	}
?>