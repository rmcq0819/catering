<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html> 
  <html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>订单信息</title>
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
     <h2 class="fl">订单信息</h2>
    </div>
      <center>
    <form action='/wecatering/admin.php/Home/Orders/search' method='get'>
    请选择搜索条件:
      <select class="select" name="condi" id="condi">
         <option  value="1">已结</option>
          <option  value="2">未结</option>
        </select>
      <input type='submit' class="link_btn" value='搜索'/>
    </form></center>
    <table class="table">
     <tr>
      <th>编号</th>
      <th>会员编号</th>
      <th>服务员编号</th>
      <th>下单时间</th>
      <th>用餐人数</th>
      <th>总消费额</th>
      <th>折后总额</th>
       <th>已交定金</th>
      <th>应收款</th>
      <th>实收款</th>
      <th>积分</th>
      <th>结账时间</th>
      <th>订单状态</th>
      <th>餐桌数</th>
      <th width="15%">操作</th>
     </tr>
    <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
      <td><center><?php echo ($v["o_id"]); ?></center></td>
      <td><center><?php echo ($v["m_id"]); ?></center></td>
       <td><center><?php echo ($v["w_id"]); ?></center></td>
      <td><center><?php echo ($v["o_time"]); ?></center></td>
       <td><center><?php echo ($v["o_number"]); ?></center></td>
      <td><center><?php echo ($v["o_amount"]); ?></center></td>
       <td><center><?php echo ($v["o_discount"]); ?></center></td>
        <td><center><?php echo ($v["o_deposit"]); ?></center></td>
      <td><center><?php echo ($v["o_receivable"]); ?></center></td>
     
      
       <td><center><?php echo ($v["o_received"]); ?></center></td>
      <td><center><?php echo ($v["o_integral"]); ?></center></td>
       <td><center><?php echo ($v["o_etime"]); ?></center></td>
      <td><center><?php echo ($v["o_state"]); ?></center></td>
      <td><center><?php echo ($v["o_tablenumber"]); ?></center></td>
      <td><center>
       <a href="/wecatering/admin.php/Home/Orders/modify?o_id=<?php echo ($v["o_id"]); ?>" class="inner_btn">修改</a>
       <a href="/wecatering/admin.php/Home/Orders/do_delete?o_id=<?php echo ($v["o_id"]); ?>" class="inner_btn" onclick=" return confirm('确定删除?');">删除</a>
      </center></td>
     </tr><?php endforeach; endif; ?>
    </table>
    <aside class="paging">
    <?php echo ($show); ?>
    </aside>
   </section> 
  </body>
</html>