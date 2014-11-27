<?php
class rd_views extends Smarty{

	function __construct(){
		$this->template_dir=$GLOBALS['redrock_app_config']['smarty']['config']['template_dir'];  //模板目录
		$this->compile_dir=$GLOBALS['redrock_app_config']['smarty']['config']['compile_dir'];    //里的文件是自动生成的，合成的文件
		$this->caching=$GLOBALS['redrock_app_config']['smarty']['config']['caching'];     //设置缓存开启
		$this->cache_dir=$GLOBALS['redrock_app_config']['smarty']['config']['cache_dir'];  //设置缓存的目录
		$this->cache_lifetime=$GLOBALS['redrock_app_config']['smarty']['config']['cache_lifetime'];  //设置缓存的时间 
		$this->left_delimiter=$GLOBALS['redrock_app_config']['smarty']['config']['left_delimiter'];   //模板文件中使用的“左”分隔符号
		$this->right_delimiter=$GLOBALS['redrock_app_config']['smarty']['config']['right_delimiter'];   //模板文件中使用的“右”分隔符号
		parent::__construct(); //重载父类
	}
	
	function display($tpl_name=null, $cache_id = null, $compile_id = null){
		
		$tpl=ltrim($GLOBALS['redrock_app_config']['tpl_postfix'],'.');
		
		if(is_null($tpl_name)){
			 $tpl_name="".$GLOBALS['redrock_app_config'][md5('action_m')].".".$tpl;
		}else if(strstr($tpl_name,"/")){
			 $tpl_name=$tpl_name.".".$tpl;
		}else{
			 $tpl_name="".$tpl_name.".".$tpl;
		}
		
		if($GLOBALS['redrock_app_config']['smarty']['enabled']){
			$this->assign('CSS',$GLOBALS['redrock_app_config']['static_config']['css_path']);//css路径
			$this->assign('IMG',$GLOBALS['redrock_app_config']['static_config']['images_path']);//css路径
			$this->assign('JS',$GLOBALS['redrock_app_config']['static_config']['js_path']);//css路径
			$this->assign('OTHER',$GLOBALS['redrock_app_config']['static_config']['other_path']);//css路径
			$this->assign('PLUGIN',$GLOBALS['redrock_app_config']['static_config']['plugin_path']);//css路径
			
			$this->assign('PCSS',$GLOBALS['redrock_app_config']['static_config']['pcss_path']);
			$this->assign('PIMG',$GLOBALS['redrock_app_config']['static_config']['pimages_path']);
			$this->assign('PJS',$GLOBALS['redrock_app_config']['static_config']['pjs_path']);
			
			parent::display($tpl_name, $cache_id, $compile_id);
			//debug::addMsg("引入<b> ".basename($tpl_name)." </b>模版 <span>[所在目录:".dirname($GLOBALS['redrock_app_config']['smarty']['config']['template_dir']."/".$tpl_name)."]</span>",'info');
			debug::addMsg("	<td style='width:33%;color: #666666;'>smarty:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>开启</span>&nbsp;</td>",'base');
			debug::addMsg("	<td style='width:33%;color: #666666;'>当前访问".basename($tpl_name)."模版文件:&nbsp;&nbsp;<span style='color: green;font-weight: bold;'>".$GLOBALS['redrock_app_config']['smarty']['config']['template_dir']."/".$tpl_name."</span>&nbsp;</td>",'base');
		}else{
			import_tpl(rtrim($GLOBALS['redrock_app_config']['smarty']['config']['template_dir']).'/'.$tpl_name);
		}
	}
	
}

?>