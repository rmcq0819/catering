<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html> 
  <html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>服务员信息</title>
    <link rel="stylesheet" type="text/css" href="/wecatering/Public/Css/style.css" />
    <!--[if lt IE 9]>
    <script src="/wecatering/Public/Js/html5.js"></script>
    <![endif]-->
    <script src="/wecatering/Public/Js/jquery.js"></script>
    <script type="text/javascript">
      window.onload=function(){  
        $("#condi ").val(<?php echo ($condi); ?>); // 设置Select的Value值为<?php echo ($d["c_id"]); ?>的项选中 
      }
  
    </script>
  </head>
  <body>
 <section>
    <div class="page_title">
     <h2 class="fl">服务员信息</h2>
    </div>
   <center>
    <form action='/wecatering/admin.php/Home/Waiter/search' method='get'>
    请选择搜索条件:
      <select class="select" name="condi" id="condi">
         <option  value="1">忙碌</option>
          <option  value="2">空闲</option>
        </select>
      <input type='submit' class="link_btn" value='搜索'/>
    </form></center>
    <table class="table">
     <tr>
      <th>编号</th>
       <th>姓名</th>
      <th>性别</th>
      <th>年龄</th>
      <th>状态</th>
      <th>服务桌号</th>
      <th>操作</th>
     </tr>
    <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
      <td><center><?php echo ($v["w_id"]); ?></center></td>
      <td><center><?php echo ($v["w_name"]); ?></center></td>
      <td><center>
     <?php if($v["w_sex"] == 0): ?>女<?php else: ?>男<?php endif; ?>
       </center></td>
        <td><center><?php echo ($v["w_age"]); ?></center></td>
        <td><center><?php echo ($v["w_state"]); ?></center></td>
         <td><center><?php echo ($v["w_desk"]); ?></center></td>
      <td><center>
      <?php if($v["w_state"] == '忙碌'): ?><a href="/wecatering/admin.php/Home/Waiter/release?w_id=<?php echo ($v["w_id"]); ?>" class="inner_btn">结束服务</a><?php else: endif; ?>
       <a href="/wecatering/admin.php/Home/Waiter/modify?w_id=<?php echo ($v["w_id"]); ?>" class="inner_btn">修改</a>
       <a href="/wecatering/admin.php/Home/Waiter/do_delete?w_id=<?php echo ($v["w_id"]); ?>" class="inner_btn" onclick=" return confirm('确定删除?');">删除</a>
      </center></td>
     </tr><?php endforeach; endif; ?>
    </table>
    <aside class="paging">
    <?php echo ($show); ?>
    </aside>
   </section> 
  </body>
</html>