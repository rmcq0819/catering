<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_L_DELIM'=>'<{', //修改左定界符
	'TMPL_R_DELIM'=>'}>', //修改右定界符
 	'DB_TYPE'               =>  'mysql',     // 数据库类型
	'DB_HOST'               =>  'localhost', // 服务器地址
	'DB_NAME'               =>  'catering',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  '12345678',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  '',    // 数据库表前缀
	'DB_CHARSET'            =>  'utf8',      // 数据库编码
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志

	/*
	'SHOW_PAGE_TRACE'=>true,//开启页面Trace
    'TMPL_TEMPLATE_SUFFIX'=>'.html',//更改模板文件后缀名
	'TMPL_FILE_DEPR'=>'_',//修改模板文件目录层次
	'DEFAULT_THEME'=>'Theme',//设置默认模板主题
	'TMPL_DETECT_THEME'=>true,//自动侦测模板主题
	'THEME_LIST'=>'myTheme,Theme',//支持的模板主题列表
    */
   
	'TMPL_PARSE_STRING'=>array(           //添加自己的模板变量规则
        '__CSS__'=>__ROOT__.'/Public/Css',
        '__JS__'=>__ROOT__.'/Public/Js',
        '__IMAGES__'=>__ROOT__.'/Public/Images'
	),
);