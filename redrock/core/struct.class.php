<?php

class struct{
	static function root_control(){
		$orootFile=$GLOBALS['redrock_app_config']['redrock_root_file'];
		$drootFile=rtrim($GLOBALS['redrock_app_config']['controls_runtime_path']['controls'],'/')."/".basename($GLOBALS['redrock_app_config']['redrock_root_file']);
		
		if(!file_exists($drootFile) || filemtime($orootFile) > filemtime($drootFile)){
			copy($orootFile, $drootFile);
		}
		import($orootFile);
	}
	
	static function action_control($oacitonFile,$className){
		$dactionFile = rtrim($GLOBALS['redrock_app_config']['controls_runtime_path']['controls'],'/')."/".strtolower($className)."Action.".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.')."";
		if(!file_exists($dactionFile) || filemtime($oacitonFile) > filemtime($dactionFile)){
			$classContent = file_get_contents($oacitonFile);
			$super='/extends\s+(.+?)\s*{/i'; 
				//如果已经有父类
			if(preg_match($super,$classContent, $arr)) {
				$classContent=preg_replace('/class\s+(.+?)\s+extends\s+(.+?)\s*{/i','class \1Action extends \2 {',$classContent);
				//新生成控制器类
				file_put_contents($dactionFile, $classContent);
			//没有父类时
			}else{ 
				//继承权限控制父类root
				$classContent=preg_replace('/class\s+(.+?)\s*{/i','class \1Action extends root {',$classContent);
				//生成控制器类
				file_put_contents($dactionFile,$classContent);	
			}
		}
		include $dactionFile;
		$GLOBALS['redrock_app_config']['include_file_true_path'][md5(basename($dactionFile))]=$oacitonFile;
					debug::addMsg("<tr><td style='width:15%;color: #666666;'>&nbsp;[&nbsp;<span style='color: red;font-weight: bold;'>".$className."</span>&nbsp;]action类</td>
													<td style='width:85%;color: #666666;'>文件位置:&nbsp;[&nbsp;<span style='color: green;font-weight: bold;'>".$oacitonFile."</span>&nbsp;]</td>
													</tr>",'file');
	}
	
	static function action_model($classNames,$userPath,$driver){
	
		$path=rtrim($GLOBALS['redrock_app_config']['controls_runtime_path']['models'],'/')."/";
		
		if( ""==$userPath || is_null($userPath)){
			$Opath=$GLOBALS['redrock_app_config']['include_model_path']['default'];
		}else{
			$Opath=$GLOBALS['redrock_app_config']['include_model_path']['default'];
			$Opath = explode('/',$Opath);
			$Opath[1] = $userPath;
			$Opath = implode('/',$Opath);
		}
		$Oclass = $Opath."/".strtolower($classNames).".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.');
		$className=ucfirst($classNames);
		$Dclass = $path.$className."Models".".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.');
		
		if(file_exists($Oclass)) {
		/*	echo "<pre>";
			echo $classContent=file_get_contents($Oclass);
			echo "</pre>";
			
		*/	
			$classContent=file_get_contents($Oclass);
			$pattern='/extends\s+(.+?)\s*{/i';
			if(preg_match($pattern,$classContent, $name)) {
					$pOclass =  $Opath."/".$name[1].".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.');
					$pDclass =	$path.strtolower($name[1])."Models".".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.');
					if(file_exists($pOclass)){
						if(!file_exists($pDclass) || filemtime($pOclass) > filemtime($pDclass)){
							$pclassContent=file_get_contents($pOclass);
							$pclassContent=preg_replace('/class\s+(.+?)\s*{/i','class '.strtolower($name[1]).'Models extends '.$driver.' {',$pclassContent);
							file_put_contents($pDclass, $pclassContent);
						}
					}else{
						trigger_error("文件{$pOclass}不存在!");
					} 
					$driver=strtolower($name[1])."Models";
					include $pDclass;
					$GLOBALS['redrock_app_config']['include_file_true_path'][md5(basename($pDclass))]=$pOclass;
					debug::addMsg("<tr><td style='width:15%;color: #666666;'>&nbsp;[&nbsp;<span style='color: red;font-weight: bold;'>".$name[1]."</span>&nbsp;]model类</td>
													<td style='width:85%;color: #666666;'>文件位置:&nbsp;[&nbsp;<span style='color: green;font-weight: bold;'>".$pOclass."</span>&nbsp;]</td>
													</tr>",'file');
					
			}			
			if(!file_exists($Dclass) || filemtime($Oclass) > filemtime($Dclass) ) {	
				$classContent=preg_replace('/class\s+(.+?)\s*{/i','class '.$className.'Models extends '.$driver.' {',$classContent);
				file_put_contents($Dclass,$classContent);
			}	
		}else{
			if(!file_exists($Dclass)){
				$classContent="<?php\n\tclass {$className}Models extends {$driver}{\n\t}";
				file_put_contents($Dclass,$classContent);	
			}	
		}
		include $Dclass;
		$GLOBALS['redrock_app_config']['include_file_true_path'][md5(basename($Dclass))]=$Oclass;
		debug::addMsg("<tr><td style='width:15%;color: #666666;'>&nbsp;[&nbsp;<span style='color: red;font-weight: bold;'>".$classNames."</span>&nbsp;]model类</td>
													<td style='width:85%;color: #666666;'>文件位置:&nbsp;[&nbsp;<span style='color: green;font-weight: bold;'>".$Oclass."</span>&nbsp;]</td>
													</tr>",'file');
		return $className.'Models';
	}
}

?>