<?php

class index{
	function __construct(){
		$this->assign("title","锦瑟南山原创作品展示平台");
		
		
	}
	function index(){
	

		$this->display('index');
	}

}


?>