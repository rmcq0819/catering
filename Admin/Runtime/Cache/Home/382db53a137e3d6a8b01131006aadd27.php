<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html> 
  <html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>用户预定信息</title>
    <link rel="stylesheet" type="text/css" href="/wecatering/Public/Css/style.css" />
    <!--[if lt IE 9]>
    <script src="/wecatering/Public/Js/html5.js"></script>
    <![endif]-->
 </head>
  <body>
 <section>
    <div class="page_title">
     <h2 class="fl">用户预定信息</h2>
    </div>
    <table class="table">
     <tr>
      <th>OPENID</th>
      <th>预定编号</th>
      <th>添加时间</th>
       <th>用餐时间</th>
      <th width="15%">操作</th>
     </tr>
    <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
      <td><center><?php echo ($v["y_openid"]); ?></center></td>
      <td><center><?php echo ($v["y_content"]); ?></center></td>
       <td><center><?php echo ($v["y_addtime"]); ?></center></td>
        <td><center><?php echo ($v["y_usetime"]); ?></center></td>
      <td><center>
       <a href="/wecatering/admin.php/Home/Orders/odrecord?y_content=<?php echo ($v["y_content"]); ?>" class="inner_btn">生成订单餐桌条目</a>
      
      </center></td>
     </tr><?php endforeach; endif; ?>
    </table>
    <aside class="paging">
    <?php echo ($show); ?>
    </aside>
   </section> 
  </body>
</html>