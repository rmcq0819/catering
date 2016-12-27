<!DOCTYPE html><html>
<head>
	<title>用户相册</title>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
	<link href="../Public/Css/styles.css" type="text/css" rel="stylesheet" />
	
	<link href="../Public/Css/photoswipe.css" type="text/css" rel="stylesheet" />
	
	<script type="text/javascript" src="../Public/Css/simple-inheritance.min.js"></script>
	<script type="text/javascript" src="../Public/Css/code-photoswipe-1.0.11.min.js"></script>
	
	
	<script type="text/javascript">
		
		document.addEventListener('DOMContentLoaded', function(){
			
			Code.photoSwipe('a', '#Gallery');
			
		}, false);
		
		
		
		
	</script>
	
</head>
<body>

<div id="MainContent">

	<div class="page-content">
		<center><h1>用户相册</h1></center>
	</div>
	
	
	<div id="Gallery">
		<div class="gallery-row">
			<?php
				$storage = new SaeStorage();//初始化
				$domain = 'images';  //指定存储文件的目录名
				$resultArr = $storage->getList($domain);
				foreach($resultArr as $v){
					$newArr[]=$storage->getUrl($domain,$v);
				}
			?>
			<?php
				foreach($newArr as $url){
					echo "<div class ='gallery-item'>";
					echo "<a href ='$url'>";
					echo "<img src ='$url' />";
					echo "</a>";
					echo "</div>";
				}
			?>
			
		</div>
	</div>		
</div>	

	
<div id="Footer">
</div>

</body>
</html>