<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>点餐系统后台登录</title>

<link rel="stylesheet" type="text/css" href="/wecatering/Public/Css/style.css" />
<!--[if lt IE 9]>
<script src="/wecatering/Public/Js/html5.js"></script>
<![endif]-->
<style>
body{height:100%;background:#16a085;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
</style>
<script src="/wecatering/Public/Js/jquery.js"></script>
<script src="/wecatering/Public/Js/verificationNumbers.js"></script>
<script src="/wecatering/Public/Js/Particleground.js"></script>
<script src="/wecatering/Public/Js/basic.js"></script>
<script>
$(document).ready(function() {
  //粒子背景特效
  $('body').particleground({
    dotColor: '#5cbdaa',
    lineColor: '#5cbdaa'
  });
  //验证码
  createCode();
});
</script>
</head>
<body>
<dl class="admin_login">
 <dt>
  <strong>点餐系统后台管理系统</strong>
  <em> Background Management System of Catering</em>
 </dt>
 <form action='/wecatering/admin.php/Home/Login/do_login' method='post' name='myForm'>
 <dd class="user_icon">
  <input type="text" placeholder="账号" name="username" class="login_txtbx"/>
 </dd>
 <dd class="pwd_icon">
  <input type="password" placeholder="密码" name="password" class="login_txtbx"/>
 </dd>
 <dd class="val_icon">
  <div class="checkcode">
    <input type="text" id="J_codetext" placeholder="验证码"  name="checkcode" maxlength="4" class="login_txtbx">
    <canvas class="J_codeimg" id="myCanvas" onclick="createCode()">对不起，您的浏览器不支持canvas，请下载最新版浏览器!</canvas>
  </div>
  <input type="button"  value="验证码核验" class="ver_btn" onclick="validate()"/>
 </dd>
 <input type="hidden" id="J_code" name="code"/>
 <dd>
  <input type="button"  value="立即登录" class="submit_btn" onclick="sub()"/>
 </dd>

 </form>
</dl>
</body>
</html>