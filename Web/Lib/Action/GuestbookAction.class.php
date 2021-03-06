<?php
/***********************************************************
    [大米CMS] (C)2011 - 2011 damicms.com
    
	@function 留言模块

    @Filename GuestbookAction.class.php $

    @Author 追影 QQ:279197963 $

    @Date 2011-11-18 09:01:26 $
*************************************************************/
class GuestbookAction extends BaseAction
{
	Public function _empty()
	{ 
		alert('方法不存在',U('Guestbook/index'));
	} 
	
	public function index()
	{
	    $this->assign('title','访客留言');
	//用于ajaxjs的根路径变量
		$url=__ROOT__;
		$this->assign('url',$url);
		$this->display(TMPL_PATH.cookie('think_template').'/guestbook.html');
	}
	
	public function update()
	{
	//输出gb2312码,ajax默认转的是utf-8
		header("Content-type: text/html; charset=utf-8");
		if(!isset($_POST['content']))
		{
			alert('非法操作!',3);
		}
	//读取数据库和缓存
		$pl = M('guestbook');
		$config = F('basic','','./Web/Conf/');
	//准备工作
		if($config['bookoff'] == 0) $data['status'] = 0;
	//先解密js的escape
		$data['author'] = I('post.author','游客');
		$data['content'] = I('post.content');
		$data['ip'] = get_client_ip();
		$data['addtime'] = date('Y-m-d H:i:s');
	//处理数据
		if($pl->add($data))
		{
			Session::set('posttime', time());
			if($config['bookoff'] == 0)
			{
				$this->success('发布成功,留言需要管理员审核!');
			}
			else
			{
				$this->success('发布成功!');
			}
		}
		else
		{
			$this->error('发布失败!');
		}
	}
	
	public function show()
	{
	//读取数据库
		$pl = M('guestbook');
		$config = F('basic','','./Web/Conf/');
	//相关判断
		$data['status'] = 1;
		$list = $pl->where($data)->select();
		if(!$list)
		{
			$this->display(TMPL_PATH.cookie('think_template').'/guestbook_nopl.html','utf-8','text/xml');
			exit;
		}
	//分页处理
	C('VAR_PAGE','page');
	import('ORG.Util.Page');	
		$count = $pl->where($data)->count();
		$this->assign('allnum',$count);
	//每10条分页
		$pagenum = 5;
		$p = new Page($count,$pagenum);
	//总页数
		$pages = ceil($count / $pagenum);
		$plist = $pl->where($data)->order('addtime desc')->limit($p->firstRow.','.$p->listRows)->select();
		//echo $pl->getLastSql();
		foreach($plist as $k=>$v)
		{
			if(!empty($v['recontent']))
			{
				$v['recontent'] = '<font color=red><b>管理员回复：'.$v['recontent'].'</b></font>';
			}
				$pp[$k]=$v;
				$pp[$k]['num'] = $k + 1 + (intval($_GET['page']) - 1) * $pagenum;
		}
	//当前页
		$this->assign('nowpage',intval($_GET['page']));
	//总页数
		$this->assign('pages',$pages); 
	//最后一条记录数
		$this->assign('lastnum',$pagenum);
		$this->assign('list',$pp);
		$this->display(TMPL_PATH.cookie('think_template').'/guestbook_pl.html','utf-8','text/xml');
	}
}
?>