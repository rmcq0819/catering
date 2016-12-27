<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "
http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta charset="utf-8"/>
<title>点餐系统后台管理系统</title>
<link rel="stylesheet" type="text/css" href="/wecatering/Public/Css/style.css" />
<!--[if lt IE 9]>
<script src="/wecatering/Public/Js/html5.js"></script>
<![endif]-->
<script src="/wecatering/Public/Js/jquery.js"></script>
<script src="/wecatering/Public/Js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript">
  (function($){
    $(window).load(function(){
      
      $("a[rel='load-content']").click(function(e){
        e.preventDefault();
        var url=$(this).attr("href");
        $.get(url,function(data){
          $(".content .mCSB_container").append(data); //load new content inside .mCSB_container
          //scroll-to appended content 
          $(".content").mCustomScrollbar("scrollTo","h2:last");
        });
      });
      
      $(".content").delegate("a[href='top']","click",function(e){
        e.preventDefault();
        $(".content").mCustomScrollbar("scrollTo",$(this).attr("href"));
      });
      
    });
  })(jQuery);
  
$(document).ready(function(){
  $("a").click(function(){
    $("a").removeClass('active');
    $(this).addClass('active');
  });
});
</script>
</head>
<body>
<!--header-->


<header>
 <h1><img src="/wecatering/Public/Images/admin_logo.png"/></h1>
 <ul class="rt_nav">
 <li><br><sapn style="color:#fff">您好<?php echo ($username); ?>,欢迎使用!</sapn></li>
 <li><a href="/wecatering/admin.php/Home/Admin/modify?id=<{id]>" class="set_icon">账号设置</a></li>
  <li><a href="/wecatering/admin.php/Home/Login/do_logout" class="quit_icon">安全退出</a></li>
 </ul>
</header>

<!--aside nav-->
<aside class="lt_aside_nav content mCustomScrollbar" >
 <ul>
   <li>
   <dl>
    <dt>预定信息管理</dt>
    <dd><a href="/wecatering/admin.php/Home/Reserve/rlist" target="rt_frame">预定列表</a></dd>
    <dd><a href="/wecatering/admin.php/Home/Remsg/rlist" target="rt_frame">预定反馈列表</a></dd>
   </dl>
  </li>
  <li>
   <dl>
    <dt>订单信息管理</dt>
    <dd><a href="/wecatering/admin.php/Home/Orders/olist" target="rt_frame">订单列表</a></dd>
   </dl>
  </li>
     <li>
   <dl>
    <dt>订单条目管理</dt>
    <dd><a href="/wecatering/admin.php/Home/Orderdesk/odlist" target="rt_frame">订单条目列表</a></dd>
   </dl>
  </li>
    <li>
   <dl>
    <dt>菜单条目管理</dt>
    <dd><a href="/wecatering/admin.php/Home/Orderdish/odlist" target="rt_frame">菜单条目列表</a></dd>
   </dl>
  </li>
  <li>
   <dl>
    <dt>会员信息管理</dt>
    <dd><a href="/wecatering/admin.php/Home/Member/mlist" target="rt_frame">会员列表</a></dd>
   </dl>
  </li>
    <li>
   <dl>
    <dt>预定条目管理</dt>
    <dd><a href="/wecatering/admin.php/Home/Reservedesk/rdlist" target="rt_frame">预定条目列表</a></dd>
   </dl>
  </li>
  <li>
  <li>
   <dl>
    <dt>菜品分类管理</dt>
    <!--当前链接则添加class:active-->
       <dd><a href="/wecatering/admin.php/Home/Classfication/add" target="rt_frame">添加分类</a></dd>
       <dd><a href="/wecatering/admin.php/Home/Classfication/cflist" target="rt_frame" >分类列表</a></dd>
   </dl>
  </li>
  <li>
   <dl>
    <dt>菜品信息管理</dt>
    <dd><a href="/wecatering/admin.php/Home/Dishes/add" target="rt_frame">添加菜品</a></dd>
    <dd><a href="/wecatering/admin.php/Home/Dishes/dlist" target="rt_frame">菜品列表</a></dd>
   </dl>
  </li>
  <li>
   <dl>
    <dt>餐桌信息管理</dt>
    <dd><a href="/wecatering/admin.php/Home/Desk/add" target="rt_frame">添加餐桌</a></dd>
    <dd><a href="/wecatering/admin.php/Home/Desk/dlist" target="rt_frame">餐桌列表</a></dd>
   </dl>
  </li>
  <li>
   <dl>
    <dt>服务员信息管理</dt>
    <dd><a href="/wecatering/admin.php/Home/Waiter/add" target="rt_frame">添加服务员</a></dd>
    <dd><a href="/wecatering/admin.php/Home/Waiter/wlist" target="rt_frame">服务员列表</a></dd>
   </dl>
  </li>
  <li>
   <dl>
    <dt>活动信息管理</dt>
    <dd><a href="/wecatering/admin.php/Home/Activity/add" target="rt_frame">添加活动</a></dd>
    <dd><a href="/wecatering/admin.php/Home/Activity/alist" target="rt_frame">活动列表</a></dd>
   </dl>
  </li>
 </ul>
</aside>


<section class="rt_wrap content mCustomScrollbar">
 <div class="rt_content">
 <iframe name="rt_frame" frameborder="0" src="wel" scrolling="no">
 </iframe>
 </div>
</section>
</body>
</html>