<?php
/*
	QQ咨询连接系统
 */
class AskAction extends CommonAction
{	
    public function index()
    {
    	$qq = M('qqonline');
    	$qqlist = $qq->where(array('is_del' => -1, 'is_qun'=>2))->select();
    	$this->assign('list',$qqlist);
    	$this->display();
    }

    public function doAdd(){
    	$data = I('post.');
	$data['is_qun'] = 2;
    	if (M('qqonline')->add($data)) {
    		$this->success('添加成功');
    	}else {
    		$this->error('添加成功');
    	}

    }

    public function status(){
		$id = I('get.id');
    	$data['status'] = I('get.s');
    	if (M('qqonline')->where(array('id'=> $id))->save($data)) {
    		$this->success('修改成功');
    	}else {
    		$this->error('修改成功');
    	}
    }

    public function doDelete(){
		$id = I('get.id');
    	$data['is_del'] = 1;
    	if (M('qqonline')->where(array('id'=> $id))->delete()) {
    		$this->success('删除成功');
    	}else {
    		$this->error('删除成功');
    	}
    }

    public function qun(){
    	if ($_POST) {
    		$data['number'] = I('post.number');
    		M('qqonline')->where(array('is_qun'=>1))->save($data);
    		$this->success('操作成功');
    	}
    	$qun = M('qqonline')->where(array('is_qun'=>1))->find();
    	$this->assign('qun',$qun);
    	$this->display();

    }
}
?>