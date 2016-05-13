<?php 
/**
 * 附件上传控制器
 */
/**
* 
*/
import('ORG.Util.UploadFile');
class AttachAction extends CommonAction
{
	function index(){
		$model = M('Attach');
		$attach_list = $model->select();
		$this->assign('list',$attach_list);
		$this->display();
	}
	function add(){
		$this->display();
	}
	function status(){
		var_dump($_GET);
		$s  = I('get.s',0);
		$id = i('get.id',0);
		if ($s == 'isview-1') {
			$data['is_view'] = 1;
		}else{
			$data['is_view'] = 0;
		}
		M('Attach')->where(array('id'=>$id))->save($data);
		$this->redirect('index');
	}
    function upload(){
    //文件上传地址提交给他，并且上传完成之后返回一个信息，让其写入数据库
    	if(empty($_FILES)){
      		$this->error('必须选择上传文件');  
    	}else{
      		$a=$this->up();
      		$data['title']   = I('post.title',$a[0]['name']);
      		$data['url']     = $a[0]['savepath'].$a[0]['savename'];
      		$data['created'] = time();
      		if(isset($a)){
        		if(M('Attach')->add($data)){
          			$this->success('上传成功');  
        		}
        		else{
          			$this->error('写入数据库失败');  
        		}
      		}else{
        		$this-error('上传文件异常，请与系统管理员联系');  
      		}
   	 	}
  	}
	private function up(){
		//完成与thinkphp相关的，文件上传类的调用  
		$upload=new UploadFile();
		$upload->maxSize='1000000';//默认为-1，不限制上传大小
		$upload->savePath='./Public/Uploads/Attach/';//保存路径建议与主文件平级目录或者平级目录的子目录来保存  
		$upload->saveRule=uniqid;//上传文件的文件名保存规则
		$upload->uploadReplace=true;//如果存在同名文件是否进行覆盖
		$upload->allowExts=array('jpg','jpeg','png','gif', 'txt','rar','zip','doc','xls');//准许上传的文件类型
		 
		if($upload->upload()){
		  $info=$upload->getUploadFileInfo();
		  return $info;
		}else{
		  $this->error($upload->getErrorMsg());//专门用来获取上传的错误信息的  
		}  
	}
}
?>