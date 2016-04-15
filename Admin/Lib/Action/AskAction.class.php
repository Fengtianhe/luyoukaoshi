<?php
/*
	QQ咨询连接系统
 */
class AskAction extends CommonAction
{	
    public function index()
    {
    	$qq = M('qqonline');
    	$qqlist = $qq->select();
    	$this->assign('qqlist',$qqlist);
    	$this->display();
    }
}
?>