function sub(){
	var username=document.myForm.username;
	var password=document.myForm.password;
	var checkcode=document.myForm.checkcode;
	var code=document.myForm.code;
	//alert(code.value);
	if(code.value==''){
		alert('请核验验证码');
	}else if(username.value==''||password.value==''){
		document.getElementById("J_codetext").setAttribute("placeholder","输入验证码");
		document.getElementById("J_code").value='';
		alert('用户名或者密码不能为空');
	}else{
		document.getElementById("J_code").value='';
		document.myForm.submit();
	}
}

function modifyPwd(){
	var p_npwd=document.myForm.p_npwd;
	var p_verifypwd=document.myForm.p_verifypwd;
	if(p_npwd.value==''||p_verifypwd.value==''){
		alert('请输入密码！');
	}else{
		if(p_npwd.value!=p_verifypwd.value){
			alert('两次输入的密码不一致！');
		}else{
			document.myForm.submit();
		}
	}
}

function checkPwd(){
	var p_password=document.myForm.p_password;
	var p_verifypwd=document.myForm.p_verifypwd;
	if(p_password.value==''||p_verifypwd.value==''){
		alert('请输入密码！');
	}else{
		if(p_password.value!=p_verifypwd.value){
			alert('两次输入的密码不一致！');
		}else{
			document.myForm.submit();
		}
	}
	
	
}