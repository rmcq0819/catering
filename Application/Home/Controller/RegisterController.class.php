<?php
namespace Home\Controller;
use Think\Controller;
//use Common\Common\MySendMail;
class RegisterController extends Controller {
    public function register(){
		$this->display();
    }
    public function regverify(){

		$this->display();
    }
    public function regfinish(){
		$this->display();
    }

    public function verify(){//生成验证码
    	$Verify = new \Think\Verify();
    	$Verify->fontSize = 30;
    	$Verify->length   = 4;
    	$Verify->entry();
    }
      public function checkEmail(){//检查邮箱合法性
		$m_email=$_GET['m_email'];
		if(!preg_match("/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$m_email)){
			echo "错误";
		}else{
			echo '正确';
		}

	}
	function check_verify($code, $id =''){ //验证验证码
	    $verify = new \Think\Verify(); 
	    return $verify->check($code, $id);
	}

	public function do_check(){
		$m_openid=$_POST['m_openid'];
		$where['m_openid']=$m_openid;
		$member=M('Member');
		$arr=$member->where($where)->select();
		if($arr){
			$this->error('您已经注册过了！');
		}
		$m_email=$_POST['m_email'];
		$code=$_POST['code'];
    	$ver=rand(100000,999999);
    	$_SESSION['ver']=$ver;
    	if($_SESSION['code']== $code){
	    	$this->sendmail($m_email,$ver);
	    	$this->redirect('regverify?m_openid='.$m_openid.'&m_email='.$m_email);
	    }else{
	    	$this->error('验证码错误');
	    }
	}
	public function checkCode(){
		$code=$_GET['code'];
		if($this->check_verify($code) == false){
            echo '错误';
        }else{
        	$_SESSION['code']=$code;
        	echo '正确';
        }
	}

	public function do_register(){
		if($_SESSION['ver']==$_POST['code']){

			$m=M('Member');
			$data['m_id']=$this->getId();
			$data['m_grade']='0';
			$data['m_integral']='0';
			$data['m_amount']='0';
			$data['m_account']='0';
			$data['m_openid']=$_POST['m_openid'];
			$data['m_email']=$_POST['m_email'];
			$data['m_exist']='1';
			$lastId=$m->add($data);
			if($lastId){
				$this->redirect('regfinish');
			}else{
				$this->error('注册失败！',U('register'));
			}
		}else{
			$this->error('您提交的验证码有误！',U('register'));
		}
		
	}
	public function getId(){
			$dt=date('YmdHis');
			$rd=rand(10,99);
			$n_id=$dt."".$rd;
			$_SESSION['n_id']=$n_id;
			return $n_id;
	}

	public function sendmail($m_email,$ver){
		sendMail($m_email,'verify',$ver);
/*		$mail = new MySendMail();
		$mail->setServer("smtp.163.com", "liuyumei_2372@163.com", "liuyumei372");
		$mail->setFrom("liuyumei_2372@163.com");
		$mail->setReceiver($m_email);
		$mail->setCc("abc@yeah.net");
		$mail->setBcc("cba@yeah.net");
		$mail->setMailInfo("lym",$ver);
		$mail->sendMail();*/
	}
}