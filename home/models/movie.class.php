<?php
class movie {
	function getType($id=1){
		$sql="select * from category where parent_id=".$id."";
		$num = $this->fetchAll($sql);
		return gbkToUtf8($num);
	}
	
	function allNum($fatherId=0){
		if(isset($_GET['type'])&&is_numeric($_GET['type'])&&$_GET['type']!=$fatherId){
			$t="category_id=".$_GET['type']."";
		}else{
			if($fatherId==3){
				$t="category_id in (select category_id from category WHERE parent_id=".$fatherId.")";
			}else{
				$t="category_id=".$fatherId."";
			}
		}
		$sql="select * from content where is_lock=0 and is_top <2 and ".$t."";
		$num = $this->rowNum($sql);
		if($num>0){
			return $num;
		}else{
			return 0;
		}
	}
	
	function getMovie($fatherId=0,$page=1,$limitNum=10,$order='content_add_time desc'){
		if(isset($_GET['type'])&&is_numeric($_GET['type'])&&$_GET['type']!=$fatherId){
			$t="category_id=".$_GET['type']."";
		}else{
			if($fatherId==3){
				$t="category_id in (select category_id from category WHERE parent_id=".$fatherId.")";
			}else{
				$t="category_id=".$fatherId."";
			}
		}
		$num = $this->allNum($fatherId);
		$pg = new Page($limitNum,$num);
		$limit = "".$pg->getLimitStart().",".$pg->getLimitNum()."";
		$sql="select * from content as c left join (picture as p,picture_relate as r) 
		on c.content_id = r.user_id and p.pic_id = r.pic_id where is_lock=0 and is_top <2  and ".$t." order by ".$order." limit ".$limit."";
		//echo "<br>";
		$array = $this->fetchAll($sql);
		$pg->setClass("page","page_on");
		//$lastNum=$pg->getLimitStart();
		
		return array(
			//"curPage"=>$page,
			"content"=>gbkToUtf8(covArray($array)),
			"PageStr"=>$pg->getPageStr(4),
			"page"=>$pg->getCurrentPage()+1,
			"type"=>$fatherId
		);
	}
	
	function getContentById($id){
		if(isset($_SESSION['uid']) && is_numeric($_SESSION['uid'])){
				$u=$_SESSION['uid'];
			}else{
				$u=0;
			}
			$sql='update content set `content_hits`=content_hits+1 where content_id='.$id.'';
			$this->query($sql);
		//echo $sql="select * from content where is_lock=0 and is_top <2 and content_id=".$id."";
		$sql="select * from content as c left join (picture as p,picture_relate as r) on c.content_id = r.user_id and p.pic_id = r.pic_id 
left join (video as v ,video_relate as vr) 
on v.vid_id=vr.vid_id and vr.user_id=c.content_id left join `like` on content_id = like_art_id and like_user_uid = ".$u." where is_lock=0 and is_top <2  and content_id=".$id."";
		$array = $this->fetchArray($sql);
		return gbkToUtf8($array);
	}
	
	function getSerach($like){
		if(isset($_SESSION['uid']) && is_numeric($_SESSION['uid'])){
				$u=$_SESSION['uid'];
			}else{
				$u=0;
			}
		//echo $sql="select * from content where is_lock=0 and is_top <2 and content_id=".$id."";
		$num = $this->likeNum($like);
		$pg = new Page($limitNum,$num);
		$limit = "".$pg->getLimitStart().",".$pg->getLimitNum()."";
		$sql="select * from content as c left join (picture as p,picture_relate as r) on c.content_id = r.user_id and p.pic_id = r.pic_id 
left join (video as v ,video_relate as vr) 
on v.vid_id=vr.vid_id and vr.user_id=c.content_id left join `like` on content_id = like_art_id and like_user_uid = ".$u." where is_lock=0 and is_top <2  and content_title like '%".$like."%' order by content_add_time desc";
		$array = $this->fetchAll($sql);
		$pg->setClass("page","page_on");
		
		return array(
			//"curPage"=>$page,
			"content"=>gbkToUtf8(covArray($array)),
			"PageStr"=>$pg->getPageStr(4),
			"page"=>$pg->getCurrentPage()+1,
			"type"=>$fatherId
		);
		
	}
	
	function likeNum($like){
		$sql="select * from content left join `like` on content_id = like_art_id and like_user_uid = ".$u." where is_lock=0 and is_top <2  and content_title like '%".$like."%'";
		$num = $this->rowNum($sql);
		if($num>0){
			return $num;
		}else{
			return 0;
		}
	}
	
}	

?>