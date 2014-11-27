<?php
class rd_controls extends rd_views{

	function startRun(){
	
		if($GLOBALS['redrock_app_config']['smarty']['enabled']){
				parent::__construct();	
		}
		if(method_exists($this, "in")){
			$this->in();
		}
		$method=$GLOBALS['redrock_app_config'][md5('action_m')];
		if(method_exists($this, $method)){
			$this->$method();
			debug::addMsg("	<td style='width:33%;color: #666666;'>当前访问控制器模块:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".$method."</span>&nbsp;</td>",'base');
		
		}else{
			debug::addMsg("	<td style='width:33%;color: #666666;'>当前访问控制器模块:&nbsp;&nbsp;<span style='color: red;font-weight: bold;'>".$method."模块不存在</span>&nbsp;</td>",'base');
			trigger_error("控制器文件".rtrim($GLOBALS['redrock_app_config']['include_control_path']['default'],'/')."/".$GLOBALS['redrock_app_config'][md5('action_c')].".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.')."不存在".$method."方法模块");
		}
	}
	
	function skip(){
	
	
	}
	
	function success(){
	
	}
	
	function error(){
	
	}
	

}

?>