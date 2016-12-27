<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>预定</title>
		<link rel="stylesheet" type="text/css" href="/wecatering/Public/Css/style.css" />
      <!--[if lt IE 9]>
    <script src="/wecatering/Public/Js/html5.js"></script>
    <![endif]-->
    <script src="/wecatering/Public/Js/jquery.js"></script>
    <script type="text/javascript">      
    function select_desk(b_id,b_time){
        //alert(b_id);
        $.get('/wecatering/application.php/Home/Reserve/select_desk',{'b_id':b_id,'b_time':b_time},function(data){
            //alert(data);
            if(data=='选择成功'){
              $("#selectinfo_error"+b_id).html("");
              $("#selectinfo"+b_id).html("√选择成功");
             /* setTimeout(function(){$("#selectinfo"+b_id).html("");},2000);*/
            }else{
              $("#selectinfo"+b_id).html("");
              $("#selectinfo_error"+b_id).html("×选择失败");
             /* setTimeout(function(){$("#selectinfo_error"+b_id).html("");},2000);*/
            }
            return false;
        });
    }

     $(function(){
        $('input[name="n_phone"]').blur(function(){
          var n_phone=$(this).val();
            $.get('/wecatering/application.php/Home/Reserve/checkPhone',{'n_phone':n_phone},function(data){
           alert(data);
           if(data=='正确'){
              $('#phone').html('');
            }else{
              $('#phone').html('请正确填写电话号码！');
            }
          });
        });
      });
    </script>
	</head>
	<body>
	  <section>
    <div class="page_title">
     <h2 class="fl">预定</h2>
    </div>
    <?php if(($list == NULL)): ?><h1>您选择的用餐时间所有餐桌都已经被预定,请<a href="/wecatering/application.php/Home/Desk/deskInfo">返回</a>重新选择</h1><?php else: ?> 
    <table class="table">
     <tr>
      <th>编号</th>
      <th>座位数</th>
      <th>定金</th>
      <th>区域</th>
      <th>操作</th>
     </tr>
    <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>

      <td><center><?php echo ($v["b_id"]); ?></center></td>
      <td><center><?php echo ($v["b_seats"]); ?></center></td>
      <td><center><?php echo ($v["b_deposit"]); ?></center></td>
      <td><center><?php echo ($v["b_block"]); ?></center></td>
      <td><center>
      <a onclick="select_desk('<?php echo ($v["b_id"]); ?>','<?php echo ($b_time); ?>');" class="inner_btn">  选择</a>
      <span id="selectinfo<?php echo ($v["b_id"]); ?>" style="color:green;"></span>
      <span id="selectinfo_error<?php echo ($v["b_id"]); ?>" style="color:red;"></span>
      </center></td>
     </tr><?php endforeach; endif; ?>
     </table>
    <aside class="paging">
       <?php echo ($show); ?>
    </aside>
     </section>
     <section>
    <form action='/wecatering/application.php/Home/Reserve/do_reserve' method='post' name='myForm'>
      <ul class="ulColumn">
      <li> 
        <span class="item_name" style="width:120px;">预定人数：</span>
        <input type="text" name="n_usernumber" class="textbox textbox_295" placeholder="预定人数..."/>
       </li>
      <li>
        <span class="item_name" style="width:120px;">顾客姓名：</span>
        <input type="text" name="n_name" class="textbox textbox_295" placeholder="长度不超过10..."/>
       </li>
       <li>
        <span class="item_name" style="width:120px;">电话：</span>
        <input type="text" name="n_phone" class="textbox textbox_295" placeholder="长度为11..."/>
        <span id="phone" class="errorTips"></span>
       </li>
        <li>
       <li>
        <span class="item_name" style="width:120px;">备注：</span>
        <textarea placeholder="备注..." name="n_description" class="textarea" style="width:500px;height:100px;"></textarea>
       </li>
       <li>
        <span class="item_name" style="width:120px;"></span>
        <input type="submit" class="link_btn"/>
       </li>
      </ul>
      </form><?php endif; ?>
     </section>
	</body>
</html>