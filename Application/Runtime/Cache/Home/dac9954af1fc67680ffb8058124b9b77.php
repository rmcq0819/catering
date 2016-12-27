<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html> 
  <html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>餐桌信息</title>
    <link rel="stylesheet" type="text/css" href="/wecatering/Public/Css/style.css" />
  <!--[if lt IE 9]>
    <script src="/wecatering/Public/Js/html5.js"></script>
    <![endif]-->
</head>
  <body>
  <section>
    <div class="page_title">
     <h2 class="fl">餐桌信息</h2>
    </div>
     <ul class="ulColumn">
      <form action='/wecatering/application.php/Home/Reserve/reserve' method='post' name='myForm'>
      <li>
      <span class="item_name" style="width:120px;">请选择用餐时间：</span>
       <select class="select" name="b_time">
          <option  value="b_monbreakfast">周一早上</option>
          <option  value="b_monlunch"  selected="selected">周一中午</option>
          <option  value="b_monsupper">周一晚上</option>
          <option  value="b_tuebreakfast">周二早上</option>
          <option  value="b_tuelunch">周二中午</option>
          <option  value="b_tuesupper">周二晚上</option> 
          <option  value="b_wedbreakfast">周三早上</option>
          <option  value="b_wedlunch">周三中午</option>
          <option  value="b_wedsupper">周三晚上</option>
          <option  value="b_thubreakfast">周四早上</option>
          <option  value="b_thulunch">周四中午</option>
          <option  value="b_thusupper">周四晚上</option>
          <option  value="b_fribreakfast">周五早上</option>
          <option  value="b_frilunch">周五中午</option>
          <option  value="b_frisupper">周五晚上</option>
          <option  value="b_satbreakfast">周六早上</option>
          <option  value="b_satlunch">周六中午</option>
          <option  value="b_satsupper">周六晚上</option>
          <option  value="b_sunbreakfast">周日早上</option>
          <option  value="b_sunlunch">周日中午</option>
          <option  value="b_sunsupper">周日晚上</option>          
        </select>
        <input type="submit" class="link_btn" value="去预定" />
       </li>  
       </form>
       </ul>
   
       <table class="table">
     <tr>
      <th>编号</th>
      <th>座位数</th>
      <th>定金</th>
      <th>区域</th>
      <th>周一早上</th>
      <th>周一中午</th>
      <th>周一晚上</th>
      <th>周二早上</th>
      <th>周二中午</th>
      <th>周二晚上</th>
      <th>周三早上</th>
      <th>周三中午</th>
      <th>周三晚上</th>
      <th>周四早上</th>
      <th>周四中午</th>
      <th>周四晚上</th>
      <th>周五早上</th>
      <th>周五中午</th>
      <th>周五晚上</th>
      <th>周六早上</th>
      <th>周六中午</th>
      <th>周六晚上</th>
      <th>周日早上</th>
      <th>周日中午</th>
      <th>周日晚上</th>

     </tr>
    <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>

      <td><center><?php echo ($v["b_id"]); ?></center></td>
      <td><center><?php echo ($v["b_seats"]); ?></center></td>
      <td><center><?php echo ($v["b_deposit"]); ?></center></td>
      <td><center><?php echo ($v["b_block"]); ?></center></td>
      <td><center>
		<?php if(($v["b_monbreakfast"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_monlunch"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_monsupper"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_tuebreakfast"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_tuelunch"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_tuesupper"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_wedbreakfast"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_wedlunch"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_wedsupper"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_thubreakfast"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_thulunch"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_thusupper"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_fribreakfast"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_frilunch"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_frisupper"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_satbreakfast"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_satlunch"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_satsupper"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_sunbreakfast"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_sunlunch"] == 1)): ?>-<?php else: ?><span style="color:red">可预定</span><?php endif; ?>
      </center></td>
      <td><center>
		<?php if(($v["b_sunsupper"] == 1)): ?>-<?php else: ?> <span style="color:red">可预定</span><?php endif; ?>
      </center></td>
     </tr><?php endforeach; endif; ?>
    </table>
    <aside class="paging">
<?php echo ($show); ?>
</aside>
</section> 
  </body>
</html>