<?php
class rd_sql{
	protected $sql_table='';
	protected $sql_fields='';
	protected $sql_values='';
	protected $sql_type='';
	protected $sql_where='';
	protected $sql_group='';
	protected $sql_having='';
	protected $sql_join='';
	protected $sql_order='';
	protected $sql_limit='';
	protected $sql_like='';
	protected $sql_distinct='';
	protected $sqls=null;
	//public $sqls='';
//protected $selectSql  ='SELECT%DISTINCT% %FIELDS% FROM %TABLE%%JOIN%%WHERE%%GROUP%%HAVING%%ORDER%%LIMIT%';
	function combineSql(){
		//echo "sql";
		$type=$this->sql_type;
		$sql='';
		switch ($type){
			case 'update':
					$sql.="update ";
					$sql.=$this->sql_table;
					$sql.=" set ";
					$sql.=$this->sql_fields.' ';
					//$sql.=' where ';
					$sql.=$this->sql_where.' ';
					$sql.=$this->sql_like.' ';
					break;
			case 'insert':
					$sql.='insert into ';
					$sql.=$this->sql_table;
					$sql.=" (";
					$sql.=$this->sql_fields;
					$sql.=") values (";
					$sql.=$this->sql_values.")";
					break;
			case 'delete':
					$sql.='delete from ';
					$sql.=$this->sql_table.' ';
					//$sql.=' where ';
					$sql.=$this->sql_where.' ';
					$sql.=$this->sql_like.' ';
					break;
			case 'select':
					$sql.="select ";
					$sql.=$this->sql_distinct.' ';
					$this->sql_fields==''?$this->sql_fields='*':1;
					$sql.=$this->sql_fields.' ';
					$sql.="from ";
					$sql.=$this->sql_table.' ';
					$sql.=$this->sql_join.' ';
					$sql.=$this->sql_where.' ';
					$sql.=$this->sql_like.' ';
					$sql.=$this->sql_group.' ';
					$sql.=$this->sql_having.' ';
					$sql.=$this->sql_order.' ';
					$sql.=$this->sql_limit.' ';
					break;
		}
		$this->clear();
		$this->sqls=$sql;
	}

	function getTable($tablename){//得到表名
		if(!empty($tablename)){
			$this->sql_table=$tablename;
	    }else{
			$this->sql_table='';
		}
		return $this;
	}
	
	function limit($arr){//array('aaa')
		if(!empty($arr)){
			$this->sql_limit=" limit ".$arr;
		}else{
			$this->sql_limit='';
		}
		return $this;
	}
	
	function order($arr){//array('table.id'=>'desc','table2.1d'=>'asc') 默认为asc
		$a=array();
		//$b=array();
		if(!empty($arr)&&is_array($arr)){
			//$a=implode(',',$arr);
			foreach($arr as $k=>$v){
				if(empty($k)){
					$a[]=$v." asc";
				}else{
					$a[]=$k." ".$v;
				}
			}
			$b=implode(',',$a);
			$this->sql_order='order by '.$b;
		}else{
			$this->sql_order='';
		}
		return $this;
	}
	
	function group($group){
		!empty($group)?$this->sql_group='group by '.$group:$this->sql_group='';
		return $this;
	}
	
	function having($having){
		!empty($having)?$this->sql_having='have '.$having:$this->sql_having='';
		return $this;
	}
	
	function distinct($distinct){
		!empty($distinct)?$this->sql_distinct='distinct':$this->sql_distinct='';
		return $this;
	}
	
	function join($table,$array,$type='',$jointype='and'){//array('aa'=>'bb')
		if(!empty($array)&&is_array($array)&&!empty($table)){
			$b='';
			if(count($array)>1){
				foreach($array as $k=>$v){
					if($b==''){
						$b.=$k.'='.$v;
					}else{
						$b.=' '.$jointype.' '.$k.'='.$v;
					}
				}
				//$b=implode(',',$a);
			}else{
				foreach($array as $k=>$v){
					if($b==''){
						$b.=$k.'='.$v;
					}
				}
			}
			if($type=='left'){
				$this->sql_join='left join '.$table.' on('.$b.')';	
			}elseif($type=='right'){
				$this->sql_join='right join '.$table.' on('.$b.')';
			}elseif($type=='inner'){
				$this->sql_join='inner join '.$table.' on('.$b.')';
			}elseif($type=='full'){
				$this->sql_join='full join '.$table.' on('.$b.')';
			}else{
				$this->sql_join='join '.$table.' on('.$b.')';
			}
		}else{
			$this->sql_join='';
		}
		return $this;
	}
	//字段
	function fields($fields){//select选择要的字段  array('table.a1','table.a3')//或者取别名array('table.a1 as ss','table.a3 as ddd')
		//$a=array();
		$sql_fields='';
		if(!empty($fields)){
			if(is_array($fields)){
				
				$sql_fields=implode(',',$fields);
				
			}else{
				$sql_fields=$fields;
			}
			
			//$sql_fields=str_replace(',',' ',$sql_fields);
		}else{
			$sql_fields=' * ';
		}
		$this->sql_fields=$sql_fields;
		return $this;
	}
	
	
	//function 
	function where($arr,$term='and',$type='',$liketype='and'){//选择字段从表里面 arrar('aa'=>'bb');`aa`='bb 默认为and
		$a='';
		if(!empty($arr)&&is_array($arr)){
			if(count($arr)>1){
				foreach($arr as $k=>$v){
					if($a==''){
						$a.="".$k."=".$v."";
					}else{
						$a.=' '.$term.' '.$k."=".$v."";
					}
				}
			}else{
				foreach($arr as $k=>$v){
					$a="".$k."=".$v."";
				}
			}
			$this->sql_where="where ".$a;
		}else{
			$this->sql_where='';
		}
		return $this;
	}
	
	function like($arr,$term='and'){//array('%d%'=>'%dd%')  
		$a='';
		
		if(!empty($arr)&&is_array($arr)){
			if(count($arr)>1){
				foreach($arr as $k=>$v){
					if($a==''){
						$a.='`'.$k.'` like "'.$v.'" ';//echo "ddddddd";
					}else{
						$a.=$term.' `'.$k.'` like "'.$v.'"';
					}
				}
			}else{
				foreach($arr as $k=>$v){
					$a='`'.$k.'` like "'.$v.'"';
				}
			}
			$this->sql_like='where '.$a;
			//echo "ddddddd";
		}else{
			$this->sql_like='';
		}
		//echo $sql_like;
		return $this;
	}
	
	function select($table=''){
		$this->sql_type='select';
		//$this->fields($fields);
		if($table!=''){
			$this->sql_table=$table;
		}
		return $this;
	}
	
	
	function update($value,$table=''){//$values数组array('key'=>'1','kk'=>'2','ee'=>'3');
		$a=array();
		$this->sql_type='update';
		$this->getTable($table);
		if(is_array($value)&&!empty($value)){
			foreach($value as $k=>$v){
				$a[]="`".$k."`='".$v."'";
			}
			$v=implode(',',$a);
			$this->sql_fields=$v;
		}else{
			
		}
		return $this;
	}
	
	function delete($table=''){//$table是表  array('aa'=>'bb');
		$this->sql_type="delete";
		if(!empty($table)){
			$this->sql_table=$table;
		}
	/*	if(!empty($field)&&count($field)<2){
			$this->where($field);
		}
	*/	return $this;
	}
	
	function insert($value,$table=''){//$values数组array('key'=>'1','kk'=>'2','ee'=>'3');
		$fields=array();
		$values=array();
		$this->sql_type='insert';
		$this->getTable($table);
		if(is_array($value)){
			foreach($value as $f=>$v){
				$fields[]=$this->addstr($f);
				$values[]="'".$v."'";
			}
		
		$this->sql_fields=implode(',',$fields);
		$this->sql_values=implode(',',$values);
		
		}else{
		
		}
		return $this;
	}
	function addstr($v){//给字段，值 添加``
		$v=trim($v);
		if(!empty($v) && $v !='*'){
			$add="`".$v."`";		
		}else{
			$add=$v;
		}
		return $add;
	}
	
	function clear(){
		$this->sql_table='';
		$this->sql_fields='';
		$this->sql_values='';
		$this->sql_type='';
		$this->sql_where='';
		$this->sql_group='';
		$this->sql_having='';
		$this->sql_join='';
		$this->sql_order='';
		$this->sql_limit='';
		$this->sql_distinct='';
	}	
	
}

?>