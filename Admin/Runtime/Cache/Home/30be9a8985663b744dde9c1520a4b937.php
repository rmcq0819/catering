<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html> 
  <html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>预定信息</title>
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
     <h2 class="fl">预定信息</h2>
    </div>
    <center>
    <form action='/wecatering/admin.php/Home/Reserve/search' method='get'>
    请选择搜索条件:
      <select class="select" name="condi" id="condi">
         <option  value="1">订单生成</option>
          <option  value="2">预订成功</option>
        </select>
      <input type='submit' class="link_btn" value='搜索'/>
    </form></center>
    <table class="table">
     <tr>
      <th>编号</th>
      <th>预定时间</th>
      <th>预定人数</th>
      <th>姓名</th>
      <th>手机号码</th>
      <th>定金</th>
         <th>状态</th>
         <th>用餐时间</th>
      <th>备注</th>
      <th>操作</th>
     </tr>
    <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
      <td><center><?php echo ($v["n_id"]); ?></center></td>
      <td><center><?php echo ($v["n_reservetime"]); ?></center></td>
       <td><center><?php echo ($v["n_usernumber"]); ?></center></td>
      <td><center><?php echo ($v["n_name"]); ?></center></td>
       <td><center><?php echo ($v["n_phone"]); ?></center></td>
      <td><center><?php echo ($v["n_money"]); ?></center></td>
           <td><center><?php echo ($v["n_state"]); ?></center></td>
            <td><center><?php echo ($v["n_usetime"]); ?></center></td>
       <td><center><?php echo ($v["n_description"]); ?></center></td>
      <td><center>
       <a href="/wecatering/admin.php/Home/Reserve/modify?n_id=<?php echo ($v["n_id"]); ?>" class="inner_btn">修改</a>
       <a href="/wecatering/admin.php/Home/Reserve/do_delete?n_id=<?php echo ($v["n_id"]); ?>" class="inner_btn" onclick=" return confirm('确定删除?');">删除</a>
      </center></td>
     </tr><?php endforeach; endif; ?>
    </table>
    <aside class="paging">
    <?php echo ($show); ?>
    </aside>
   </section> 
  </body>
</html>