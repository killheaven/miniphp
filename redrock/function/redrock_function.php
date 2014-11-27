<?php
function getFileExt($filename){
	return strtolower(array_pop(explode('.',trim($filename))));
}

function encodingConvert(&$data,$in_charset='gbk',$out_charset='utf-8'){
	if(is_string($data)){
		return iconv($in_charset, $out_charset.'//IGNORE', $data);		
	}
	if(is_array($data)&&!empty($data)){
		foreach ($data as $k=>$v){
			$data[$k]=encodingConvert($v);			
		}
	}
	return $data;
	
}
function gbkToUtf8($data){
	if(is_array($data)){
		$array=array();
		foreach($data as $key=>$value){
			if(is_array($value)){
				$array[$key]=gbkToUtf8($value);
			}else{
				$array[$key] = iconv("GBK", "UTF-8//IGNORE", $value);
			}
		}
		return $array;
	}else{
		$data = iconv("GBK", "UTF-8//IGNORE", $data);
	}
	return $data;
}
function replaceStr($data,$str){
	if(is_array($data)){
		$array=array();
		foreach($data as $key=>$value){
			if(is_array($value)){
				$array[$key]=replaceStr($value,$str);
			}else{
				$array[$key] = str_replace($str, "<b style='color:blue'>".$str."</b>", $value);
			}
		}
		return $array;
	}else{
		$data = str_replace($str, "<b style='color:blue'>".$str."</b>", $data);
	}
	return $data;
}

function utf8ToGbk($data){
	if(is_array($data)){
		$array=array();
		foreach($data as $key=>$value){
			if(is_array($value)){
				$array[$key]=gbkToUtf8($value);
			}else{
				$array[$key] = iconv("UTF-8", "GBK//IGNORE", $value);
			}
		}
		return $array;
	}else{
		$data = iconv("UTF-8", "GBK//IGNORE", $data);
	}
	return $data;
}
function covArray($arr){
	if(is_array($arr)){
		$array=array();
		foreach($arr as $key=>$value){
			if(is_array($value)){
				$array[$key]=covArray($value);
			}else{
			
				if($key=='comment_content'  || $key=='content' || $key=='comment_user' || $key=='user'){
					$array[$key] = stripslashes($value);
				}elseif($key=='articlecomment_time'  || $key=='comment_time'  || $key=='time'  || $key=='content_add_time'  || $key=='content_update_time'){
					$array[$key] = $date=date('Y-m-d H:i:s',$value);
				}else{
					$array[$key] = $value;
				}/*
				if($key=='comment_content'  || $key=='content' || $key=='comment_user' || $key=='user'){
					$array[$key] = stripslashes($value);
				}else{
					$array[$key] = $value;
				}*/
			}
		}
		return $array;
	}
}
/*
	读取配置文件
*/
function redrock_ReadConfig( $preconfig, $useconfig = null){
	$nowconfig = $preconfig;
	if (is_array($useconfig)){
		foreach ($useconfig as $key => $val){
			if (is_array($useconfig[$key])){
				@$nowconfig[$key] = is_array($nowconfig[$key]) ? redrock_ReadConfig($nowconfig[$key], $useconfig[$key]) : $useconfig[$key];
			}else{
				@$nowconfig[$key] = $val;
			}
		}
	}
	return $nowconfig;
}

/*导入所需的基类类或者扩张类*/
function import($filename, $is_auto_error = TRUE, $is_auto_search = TRUE){
	if(isset($GLOBALS['redrock_app_config']['include_file'][md5($filename)])){
		return true;
	}else if( true == @is_readable($filename)){//如果直接刻度
		require($filename);
		$GLOBALS['redrock_app_config']['include_file'][md5($filename)] = true;
		if($GLOBALS['redrock_app_config']['DEBUG']){
			//echo basename($filename).'<br>';
			$pos = strpos(basename($filename),$GLOBALS['redrock_app_config']['class_postfix']['postfix']);
			$name = substr(basename($filename),0,$pos);
			//echo $GLOBALS['redrock_app_config']['class_postfix']['postfix'].'<br>';
			debug::addMsg("<tr>
		<td style='width:25%;color: #666666;'>&nbsp;[&nbsp;<span style='color: red;font-weight: bold;'>".$name."</span>&nbsp;]基类</td>
		<td style='width:75%;color: #666666;'>文件位置:&nbsp;[&nbsp;<span style='color: green;font-weight: bold;'>".$filename."</span>&nbsp;]</td>
		</tr>",'file');
		//echo rtrim(basename($test),'.class')."<br/>";
		//echo rtrim(basename($filename),$GLOBALS['redrock_app_config']['class_postfix']['postfix'])."<br>";
		}
		return true;
	}else{
		if($GLOBALS['redrock_app_config']['class_postfix']['enabled']){
			$filename = "".$filename.".".ltrim($GLOBALS['redrock_app_config']['class_postfix']['postfix'],'.')."";
		}
		if(true == $is_auto_search){ 
			$tmppath='';
			foreach(array_merge( $GLOBALS['redrock_app_config']['include_path'], $GLOBALS['redrock_app_config']['ext_include_path'] ) as $filepath){
				if(is_array($filepath)){
					foreach($filepath as $key => $path){
						if(isset($GLOBALS['redrock_app_config']["include_file"][md5(rtrim($path,'/').'/'.$filename)])){
							return true;
						}else{
							if(@is_readable( rtrim($path,'/').'/'.$filename)){
								require(rtrim($path,'/').'/'.$filename);// 载入文件
								$GLOBALS['redrock_app_config']['include_file'][md5(rtrim($path,'/').'/'.$filename)] = rtrim($path,'/').'/'.$filename;
								if($GLOBALS['redrock_app_config']['DEBUG']){
									$pos = strpos(basename($filename),$GLOBALS['redrock_app_config']['class_postfix']['postfix']);
									$name = substr(basename($filename),0,$pos);
			
									debug::addMsg("<tr><td style='width:15%;color: #666666;'>&nbsp;[&nbsp;<span style='color: red;font-weight: bold;'>".$name."</span>&nbsp;]基类</td>
													<td style='width:85%;color: #666666;'>文件位置:&nbsp;[&nbsp;<span style='color: green;font-weight: bold;'>".rtrim($path,'/').'/'.$filename."</span>&nbsp;]</td>
													</tr>",'file');
								}
								//echo rtrim(basename($filename),$GLOBALS['redrock_app_config']['class_postfix']['postfix'])."<br/>";
								return true;
							}
						}
						
					}
				}else{
					if(isset($GLOBALS['redrock_app_config']["include_file"][md5(rtrim($filepath,'/').'/'.$filename)])){
						return true;
					}else{
						if(@is_readable( rtrim($filepath,'/').'/'.$filename)){
							require(rtrim($filepath,'/').'/'.$filename);// 载入文件
							$GLOBALS['redrock_app_config']['include_file'][md5(rtrim($filepath,'/').'/'.$filename)] = true;
							if($GLOBALS['redrock_app_config']['DEBUG']){
									//debug::addMsg("<b> ".rtrim($filename,$GLOBALS['redrock_app_config']['class_postfix']['postfix'])." </b>类 <span>[所在文件:".rtrim($filepath,'/').'/'.$filename."]</span>",'file');
								$pos = strpos(basename($filename),$GLOBALS['redrock_app_config']['class_postfix']['postfix']);
								$name = substr(basename($filename),0,$pos);
								debug::addMsg("<tr><td style='width:15%;color: #666666;'>&nbsp;[&nbsp;<span style='color: red;font-weight: bold;'>".$name."</span>&nbsp;]基类</td>
													<td style='width:85%;color: #666666;'>文件位置:&nbsp;[&nbsp;<span style='color: green;font-weight: bold;'>".rtrim($filepath,'/').'/'.$filename."</span>&nbsp;]</td>
													</tr>",'file');
							}
							return true;
						}
					}
				}
			}
		}
	}
	
	if( true == $is_auto_error ){
		trigger_error("未能找到名为：".$filename."的文件");
	}
	return false;
}


function combine_include_path($array=array()){
	$rpath='';
	foreach($array as $key => $path){
		if(is_array($path)){
			$rpath.=combine_include_path($path);
		}else{
			$rpath.=PATH_SEPARATOR.$path;
		}
	}
	return $rpath;
}

function import_tpl($filename,$is_debug=true){
	if(file_exists($filename) && true == @is_readable($filename)){
		include $filename;
		debug::addMsg("引入<b> ".basename($filename)." </b>模版 <span>[所在目录:".dirname($filename)."]</span>",'info')."";
	}else{
		debug::addMsg("<span style='color:red'>引入<b> ".basename($filename)." </b>模版失败 <span>[所在目录:".dirname($filename)."]</span>",'info')."</span>";
	}
}


function lead($arr=null,$type='css'){
	$array=array();
	if(empty($type)){
		return $array;
	}
	$path="".$type."_path";
	if(is_array($arr)){
	
		foreach($arr as $k=>$v){
			
			$array[]=rtrim($GLOBALS['redrock_app_config']['static_config'][''.$path.''],'/')."/".$v."";
		}
		return $array;
	}else if(!is_null($arr)){
		$array[]=rtrim($GLOBALS['redrock_app_config']['static_config'][''.$path.''],'/')."/".$arr."";
	}
	return $array;
}


function D($modelName=null,$userPath=null,$database='default',$driver=null){
	$GLOBALS['redrock_app_config']['rd_database_config_default']=$database;
	$db=null;
	if(is_null($driver)){
		$driver="rd_".$GLOBALS['redrock_app_config']['rd_database_driver'];
	}else{
		$driver="rd_".$driver;
	}	
	if(is_null($modelName)){
		$db = new $driver($database);	
	}else{
		$modelName=strtolower($modelName);
		$model=struct::action_model($modelName,$userPath,$driver);	
		$db=new $model();
	}
	return $db;
}

function MyDir($filepath){
		$path = explode("/",$filepath);
		$filepath = "./";
		foreach($path as $value){
			if('' == $value || '.' == $value){
				continue;
			}
			$tmppath = $filepath.$value."/";
			if(!file_exists($tmppath)){
				@mkdir($tmppath,0755);
			}
			$filepath .=$value."/";
		}
		return $filepath;
	}


function ip() {
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$ip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$ip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}

function replace($content){
		$content = str_replace("\n","<br>",$content);
		return $content = str_replace(" ","&nbsp",$content);
	}
	
function resizeToFile ($sourcefile, $dest_x, $dest_y, $targetfile, $jpegqual)
{

    $picsize=getimagesize("$sourcefile");
	$source_x = $picsize[0];
	$source_y = $picsize[1];
    $arr=explode(".",$sourcefile);
    $ext="";
    if(isset($arr[count($arr)-1]));
    
    $ext=$arr[count($arr)-1];

    $ext=strtolower($ext);
    
    if($ext=="jpg" or $ext=="jpeg"){
   $source_id = imageCreateFromJPEG("$sourcefile");

    }elseif($ext=="gif"){
    $source_id =imagecreatefromgif("$sourcefile");
	
    }elseif($ext=="png"){
    $source_id=imagecreatefrompng("$sourcefile");
	}
	

$width=imagesx($source_id);
$height=imagesy($source_id);
if($width>$height){

   $dest_y=($dest_x/$width)*$height;

}else
   $dest_x=($dest_y/$height)*$width;

    $target_id=imagecreatetruecolor($dest_x, $dest_y);
    $target_pic=imagecopyresampled($target_id,$source_id, 0,0,0,0, $dest_x,$dest_y, $source_x,$source_y);

    imagejpeg ($target_id,"$targetfile",$jpegqual);

    return true;

}
function resizeToFile2 ($sourcefile, $dest_x, $dest_y, $targetfile, $jpegqual)
{

    $picsize=getimagesize("$sourcefile");
	$source_x = $picsize[0];
	$source_y = $picsize[1];
    $arr=explode(".",$sourcefile);
    $ext="";
    if(isset($arr[count($arr)-1]));
    
    $ext=$arr[count($arr)-1];

    $ext=strtolower($ext);
    
    if($ext=="jpg" or $ext=="jpeg"){
   $source_id = imageCreateFromJPEG("$sourcefile");

    }elseif($ext=="gif"){
    $source_id =imagecreatefromgif("$sourcefile");
	
    }elseif($ext=="png"){
    $source_id=imagecreatefrompng("$sourcefile");
	}
	

$width=imagesx($source_id);
$height=imagesy($source_id);
if($width>$height){

   $dest_y=($dest_x/$width)*$height;

}else
   $dest_x=($dest_y/$height)*$width;

    $target_id=imagecreatetruecolor($dest_x, $dest_y);
    $target_pic=imagecopyresampled($target_id,$source_id, 0,0,0,0, $dest_x,$dest_y, $source_x,$source_y);

    imagejpeg ($target_id,"$targetfile",$jpegqual);

    return true;

}
function mk_dir($dir, $mode = 0755) 
{ 
	if (is_dir($dir) || @mkdir($dir,$mode)) return true; 
	if (!mk_dir(dirname($dir),$mode)) return false; 
	return @mkdir($dir,$mode); 
} 

function imagesreplace($msg){
		$array=array(
		'[呵呵]'=>'static/images/emotions/1.gif',
		'[嘻嘻]'=>'static/images/emotions/2.gif',
		'[哈哈]'=>'static/images/emotions/3.gif',
		'[可爱]'=>'static/images/emotions/4.gif',
		'[可怜]'=>'static/images/emotions/5.gif',
		'[挖鼻孔]'=>'static/images/emotions/6.gif',
		'[吃惊]'=>'static/images/emotions/7.gif',
		'[害羞]'=>'static/images/emotions/8.gif',
		'[挤眼]'=>'static/images/emotions/9.gif',
		'[闭嘴]'=>'static/images/emotions/10.gif',
		'[鄙视]'=>'static/images/emotions/11.gif',
		'[爱你]'=>'static/images/emotions/12.gif',
		'[流泪]'=>'static/images/emotions/13.gif',
		'[偷笑]'=>'static/images/emotions/14.gif',
		'[亲亲]'=>'static/images/emotions/15.gif',
		'[生病]'=>'static/images/emotions/16.gif',
		'[开心]'=>'static/images/emotions/17.gif',
		'[懒得理你]'=>'static/images/emotions/18.gif',
		'[左哼哼]'=>'static/images/emotions/19.gif',
		'[右哼哼]'=>'static/images/emotions/20.gif',
		'[嘘]'=>'static/images/emotions/21.gif',
		'[衰]'=>'static/images/emotions/22.gif',
		'[委屈]'=>'static/images/emotions/23.gif',
		'[吐]'=>'static/images/emotions/24.gif',
		'[打哈欠]'=>'static/images/emotions/25.gif',
		'[抱抱]'=>'static/images/emotions/26.gif',
		'[怒]'=>'static/images/emotions/27.gif',
		'[疑问]'=>'static/images/emotions/28.gif',
		'[馋嘴]'=>'static/images/emotions/29.gif',
		'[拜拜]'=>'static/images/emotions/30.gif',
		'[思考]'=>'static/images/emotions/31.gif',
		'[汗]'=>'static/images/emotions/32.gif',
		'[困]'=>'static/images/emotions/33.gif',
		'[睡觉]'=>'static/images/emotions/34.gif',
		'[钱]'=>'static/images/emotions/35.gif',
		'[失望]'=>'static/images/emotions/36.gif',
		'[酷]'=>'static/images/emotions/37.gif',
		'[花心]'=>'static/images/emotions/38.gif',
		'[哼]'=>'static/images/emotions/39.gif',
		'[鼓掌]'=>'static/images/emotions/40.gif',
		'[晕]'=>'static/images/emotions/41.gif',
		'[悲伤]'=>'static/images/emotions/42.gif',
		'[抓狂]'=>'static/images/emotions/43.gif',
		'[黑线]'=>'static/images/emotions/44.gif',
		'[阴脸]'=>'static/images/emotions/45.gif',
		'[怒骂]'=>'static/images/emotions/46.gif',
		'[心]'=>'static/images/emotions/47.gif',
		'[伤心]'=>'static/images/emotions/48.gif',
		'[猪头]'=>'static/images/emotions/49.gif',
		'[OK]'=>'static/images/emotions/50.gif',
		'[耶]'=>'static/images/emotions/51.gif',
		'[good]'=>'static/images/emotions/52.gif',
		'[不要]'=>'static/images/emotions/53.gif',
		'[赞]'=>'static/images/emotions/54.gif',
		'[来]'=>'static/images/emotions/55.gif',
		'[弱]'=>'static/images/emotions/56.gif',
		'[蜡烛]'=>'static/images/emotions/57.gif',
		'[钟]'=>'static/images/emotions/58.gif',
		'[蛋糕]'=>'static/images/emotions/59.gif',
		'[话筒]'=>'static/images/emotions/60.gif',
		);
		preg_match_all('/\[([\x{4e00}-\x{9fa5}]*)\]/u',$msg,$match);
		if($match){
			foreach($match[0] as $key=>$value){
				//echo $value;
				$msg = str_replace($value,"<img src='".$array[$value]."'>",$msg);
			}
		}
		return $msg;
	}
?>