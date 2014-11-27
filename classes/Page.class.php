<?php

class Page
{
	protected $_url;
	protected $_current;
	protected $_pageSize;
	protected $_totalNum;
	protected $_totalPage;

	protected $_normalStyle;
	protected $_currentStyle;

	protected $_firstFormat;
	protected $_backFormat;
	protected $_nextFormat;
	protected $_lastFormat;
	
	public function __construct($pageSzie,$totalNum,$format = "page")
	{
		$url = $_SERVER['REQUEST_URI'];
		preg_match("#([\?|&])".$format."=([^&|\s]+)#",$url,$match);
		if(!empty($match))
		{
			if($match[1] == "?")
			{
				//?page=1&
				$url = preg_replace("#\?".$format."=".$match[2]."(&|)#","?",$url);
				//?  or ?id=2
			}
			else
			{
				//?type=2&id=2&page=1  ors ?type=2&page=1&id=2
				$url = str_replace("&".$format."=".$match[2],"",$url);
				//?type=2&id=2
			}
		}
		$url = preg_replace("#\?+#","?",$url);
		$url = preg_replace("#&+#","&",$url);
		$parse_url = parse_url($url);
		$query = isset($parse_url['query']) ? $parse_url['query'] : "";
		if($query)
		{
			if(strlen($url) - strrpos($url,"&") != 1)//?type=2&id=2&
			{
				$url .= "&";
			}
		}
		else
		{
			if(strpos($url,"?") === false)//http://localhost/index.php?
			{
				$url .= "?";
			}
		}
		$url .= $format."=";
		$this->_url = $url;
		
		$this->_current = isset($match[2]) && is_numeric($match[2]) ? $match[2] : 1;
		$this->_pageSize = $pageSzie;
		$this->_totalNum = $totalNum;
		$this->_totalPage = ceil($totalNum / $pageSzie);
		if($this->_current < 1)
		{
			$this->_current = 1;
		}
		if($this->_current > $this->_totalPage)
		{
			$this->_current = $this->_totalPage;
		}
		if($this->_current == 0)
		{
			$this->_current = 1;
		}
	}
	
	public function setClass($normalClass = "",$currentClass = "")
	{
		$this->_normalStyle = "class=\"".$normalClass."\"";
		$this->_currentStyle = "class=\"".$currentClass."\"";
	}
	
	public function setBackFormat($format = "【上页】")
	{
		$this->_backFormat = $format;
	}
	
	public function setNextFormat($format = "【下页】")
	{
		$this->_nextFormat = $format;
	}

	public function setFirstFormat($format = "【首页】")
	{
		$this->_firstFormat = $format;
	}
	
	public function setLastFormat($format = "【尾页】")
	{
		$this->_lastFormat = $format;
	}
	
	public function getPageStr($type)
	{
		//初始化
		if($this->_nextFormat == "")
		{
			$this->setNextFormat();
		}
		if($this->_backFormat == "")
		{
			$this->setBackFormat();
		}
		if($this->_firstFormat == "")
		{
			$this->setFirstFormat();
		}
		if($this->_lastFormat == "")
		{
			$this->setLastFormat();
		}
	//	$pageStr = "共有".$this->_totalNum."条";
		$pageStr = "";
		//首页
		//$pageStr .= "<a href=\"".$this->_url."1\" ".$this->_normalStyle.">".$this->_firstFormat."</a>";
		//上一页
		/*
		if($this->_current > 1)
		{
			$pageStr .= "<a href=\"".$this->_url.($this->_current - 1)."\" ".$this->_normalStyle.">".$this->_backFormat."</a>";
		}
		else
		{
			$pageStr .= "<a href=\"".$this->_url."1\" ".$this->_normalStyle.">".$this->_backFormat."</a>";
		}
		*/
		//数字开始与结束确定
		if($this->_current >= $this->_totalPage - $type)
		{
			$start = $this->_totalPage - $type * 2;
		}
		else
		{
			$start = $this->_current - $type;
		}
		if($this->_current > $type)
		{
			$end = $type + $this->_current;
		}
		else
		{
			$end = $type * 2 + 1;
		}
		if($start < 1)
		{
			$start = 1;
		}
		if($end > $this->_totalPage)
		{
			$end = $this->_totalPage;
		}
		//数字
		
		
		
		for($i=1;$i<=$this->_totalPage;$i++)
		{
			if($i==$this->_current)
			{
				$pageStr .= "<a ".$this->_currentStyle.">".$i."</a>";
			
			}else{
				if($this->_current-4<=$i and $i<=$this->_current+4){
					if($this->_current-1<=$i and $i<=$this->_current+1){
						//$this->getlink($i,$i);
						//echo "<a href=$this->url?page=".$p." class='".$this->link_css."'>$this->pageleftcss$text$this->pagerightcss&nbsp</a>";
						$pageStr .= "<a href=\"".$this->_url.$i."\" ".$this->_normalStyle.">".$i."</a>";
					}else{
						if($i==1 or $i==$this->_totalPage){
							//$this->getlink($i,$i);
							$pageStr .= "<a href=\"".$this->_url.$i."\" ".$this->_normalStyle.">".$i."</a>";
					
							}else{
								$pageStr .= ".";
							}
					}
				}else{
					if($i==1 or $i==$this->_totalPage){
						//$this->getlink($i,$i);
						$pageStr .= "<a href=\"".$this->_url.$i."\" ".$this->_normalStyle.">".$i."</a>";
					
					}else{}
				}
			}
		}
		
		
		/*
		for($i = $start;$i <= $end;$i++)
		{
			if($i == $this->_current)
			{
				$pageStr .= "<a ".$this->_currentStyle.">".$i."</a>";
			}
			else
			{
				$pageStr .= "<a href=\"".$this->_url.$i."\" ".$this->_normalStyle.">".$i."</a>";
			}
		}*/
		//下一页
		/*
		if($this->_current < $this->_totalPage)
		{
			$pageStr .= "<a href=\"".$this->_url.($this->_current + 1)."\" ".$this->_normalStyle.">".$this->_nextFormat."</a>";
		}
		else
		{
			$pageStr .= "<a href=\"".$this->_url.$this->_totalPage."\" ".$this->_normalStyle.">".$this->_nextFormat."</a>";
		}
		//尾页
		//$pageStr .= "<a href=\"".$this->_url.$this->_totalPage."\" ".$this->_normalStyle.">".$this->_lastFormat."</a>";
		*/
		return $pageStr;
	}

	public function getCurrentPage()
	{
		return $this->_current;
	}
	
	public function getLimitNum()
	{
		return $this->_pageSize;
	}
	
	public function getAllPage()
	{
		return $this->_totalPage;
	}
	//skewing 记录偏移量
	public function getLimitStart($skewing = 0)
	{
		return ($this->_current - 1) * $this->_pageSize + $skewing;
	}
	private function allpage(){//全部页面
	for($i=1;$i<=$this->totalpage;$i++)
	{
		if($i==$this->page)
		{
		echo "<a href=$this->url?page=".$i." class='".$this->links_css."'>$i&nbsp</a>";
		//$this->getlinks($i,$i);
		}else{
			if($this->page-4<=$i and $i<=$this->page+4){
				if($this->page-1<=$i and $i<=$this->page+1){
				$this->getlink($i,$i);
				}else{
					if($i==1 or $i==$this->totalpage){
						$this->getlink($i,$i);
						}else{
							echo ".";
						}
				}
			}else{
				if($i==1 or $i==$this->totalpage){
					$this->getlink($i,$i);
				}else{}
			}
		/*	if($i<=$this->page+2){
				$this->getlink($i,$i);
			}else{
			    echo ".";
			}*/
		//$this->getlink($i,$i);
		}
	}
}
}
?>