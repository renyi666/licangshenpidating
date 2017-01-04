<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<title><?php echo C('WEB_SITE_TITLE');?></title>
<link rel="stylesheet" type="text/css" href="/aaaa/Public/Home/css/module.css">
<link rel="stylesheet" type="text/css" href="/aaaa/Public/Home/css/default_color.css">
<link href="/aaaa/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/aaaa/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="/aaaa/Public/static/bootstrap/css/docs.css" rel="stylesheet">
<link href="/aaaa/Public/Home/css/lanrenzhijia.css" rel="stylesheet">
<link href="/aaaa/Public/static/bootstrap/css/onethink.css" rel="stylesheet">
<link href="/aaaa/Public/Home/css/datepicker3.css" rel="stylesheet">
<link href="/aaaa/Public/Home/css/styles.css" rel="stylesheet">
<script type="text/javascript" src="/aaaa/Public/static/think.js"></script>
<script type="text/javascript" src="/aaaa/Public/static/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/aaaa/Public/Home/js/common.js"></script>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/aaaa/Public/static/bootstrap/js/html5shiv.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="/aaaa/Public/static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/aaaa/Public/static/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/aaaa/Public/static/bootstrap/js/bootstrap.min.js"></script>
<!--<![endif]-->
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body>
	<!-- 头部 -->
	<!-- 导航条
================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
        	
            <a class="brand" href="<?php echo U('index/index');?>"></a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <?php $__NAV__ = M('Channel')->field(true)->where("status=1")->order("sort")->select(); if(is_array($__NAV__)): $i = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i; if(($nav["pid"]) == "0"): ?><li>
                            <a href="<?php echo (get_nav_url($nav["url"])); ?>" target="<?php if(($nav["target"]) == "1"): ?>_blank<?php else: ?>_self<?php endif; ?>"><?php echo ($nav["title"]); ?></a>
                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <div class="nav-collapse collapse pull-right">
                <?php if(is_login()): ?><ul class="nav" style="margin-right:0">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:0;padding-right:0"><?php echo get_username();?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo U('User/profile');?>">修改密码</a></li>
                                <li><a href="<?php echo U('User/logout');?>">退出</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="nav" style="margin-right:0">
                        <li>
                            <a href="<?php echo U('User/login');?>">登录</a>
                        </li>
                        <li>
                            <a href="<?php echo U('User/register');?>" style="padding-left:0;padding-right:0">注册</a>
                        </li>
                    </ul><?php endif; ?>
            </div>
        </div>
    </div>
</div>

	<!-- /头部 -->
	
	<!-- 主体 -->
	
       <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo U('Index/index');?>">
						<!--<span>Lumino</span>-->
						李沧区建设项目综合业务平台
					</a>
					<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo get_username();?> <span class="caret" style="color:#fff;border-top:4px solid #fff"></span></a>
						<ul class="dropdown-menu" role="menu" id="dropdown-menu">
							<li><a href="<?php echo U('User/profile');?>">修改密码</a></li>
							<li><a href="<?php echo U('User/logout');?>">退出</a></li>
						</ul>
					</li>
				</ul>
				</div>
			</div>
		</nav>
		<div id="sidebar-collapse" class="sidebar">
			<form role="search">
				<!--<div class="form-group">-->
					<!--<input type="text" class="form-control" placeholder="搜索">-->
				<!--</div>-->
			</form>
			<ul class="nav menu">
				<li class="parent ">
					<a href="<?php echo U('Index/index');?>">项目管理 <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right">
					</span> 
					</a>
					<ul class="children collapse" id="sub-item-1">
						<li><a href="<?php echo U('Index/index');?>">项目进度情况</a></li>
						<!--<li><a href="<?php echo U('Index/next_index');?>">项目进展</a></li>-->
						<li><a class="" href="<?php echo U('Index/xinjian');?>">添加新项目</a></li>
					</ul>
				</li>
				<li class="parent ">
					<a href="#">报表打印 <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right">
					</span> 
					</a>
					<ul class="children collapse" id="sub-item-2">
						<li><a class="" href="<?php echo U('Index/city_project');?>">市重点项目</a></li>
						<li><a class="" href="<?php echo U('Index/major2');?>">市政务办现场会项目</a></li>
						<li><a class="" href="<?php echo U('Index/major3');?>">区重点项目</a></li>
						<li><a class="" href="<?php echo U('Index/major4');?>">区局联席会项目</a></li>
						<li><a class="" href="<?php echo U('Index/haimian');?>">海绵城市建设项目</a></li>

					</ul>
				</li>
				<!--<li class="parent ">-->
					<!--<a href="#">数据管理-->
						<!--<span data-toggle="collapse" href="#sub-item-3" class="icon pull-right">-->
						<!--</span> -->
					<!--</a>-->
					<!--<ul class="children collapse" id="sub-item-3">-->
						<!--<li>-->
							<!--<a class="" href="#">责任单位</a>-->
						<!--</li>-->
						<!--<li>-->
				<!--<a class="" href="#">分类设置</a>-->
						<!--</li>-->
					<!--</ul>-->
				<!--</li>-->
			</ul>
			
		</div>
		<div class="side_right">
        	

    <div class="cf" style="float: left;">
        <div class="fl" style="float: right;">
            <a class="btn btn-warning " type="button"   id="test"href="<?php echo U('Index/dayin_xuanze');?>">打印所选记录</a>
            <!--<a class="btn btn-success " type="button" href="<?php echo U('Index/xinjian');?>">新增项目</a>-->
            <a class="btn btn-success " type="button" href="<?php echo U('Index/dayin_major3');?>" style="margin-left:20px;">打印当前记录</a>
        </div>
        <!--<div>-->
            <!--<form action="<?php echo U('Index/sousuo');?>" method="post">-->

                <!--创建日期：-->
                <!--<input type="text" name="time1" class="text time" value="" placeholder="请选择时间" />-->

                <!--<input type="text" name="time2" class="text time" value="" placeholder="请选择时间" />-->
                <!--<input type="submit" value="查询" class="btn btn-success "style="margin-left:20px"/>-->
                <!--<div class="checkbox">-->
                    <!--<label>-->
                        <!--<input type="checkbox" name="new" value="是">-->
                        <!--是否显示最新进展 </label>-->
                <!--</div>-->
                <!--<div class="form-item">-->
                    <!--&lt;!&ndash;<label class="item-label"></label>&ndash;&gt;-->
                    <!--<div class="controls" style="padding-left:20px">-->
                        <!--<label class="checkbox">-->
                            <!--<input type="checkbox" name="help" value="是"-->
                            <!--/>-->
                            <!--是否需要协调 </label>-->
                        <!--<label class="checkbox">-->
                            <!--<input type="checkbox" name="action" value="是" <?php if($r1['action'] == '是'): ?>checked-->

                        <!--<?php endif; ?>/>-->
                            <!--是否开工 </label>-->

                    <!--</div>-->

                <!--</div>-->


            <!--</form>-->
        <!--</div>-->
        <!-- 数据列表 -->
        <div class="data-table table-striped">
            <table class="table table-bordered">
                <thead>
                <tr><th class="row-selected row-selected">
                    <input class="check-all" type="checkbox">
                </th>

                    <th class="">编号</th>
                    <th class="">名称</th>
                    <!--<th class="">分类</th>-->
                    <th class="">位置</th>

                    <th class="">责任单位</th>
                    <th class="">责任人</th>
                    <th class="">联系电话</th>
                    <!--<th class="">最后登录IP</th>-->

                    <!--<th class="">目前工作进展情况</th>-->

                    <!--<th class="">下一步工作打算</th>-->
                    <!--<th class="">存在问题</th>-->

                    <!--<th class="">是否需要协调</th>-->
                    <!--<th class="">是否开工</th>-->

                    <!--<th class="">市重点项目</th>-->
                    <!--<th class="">市政务办现场会项目</th>-->
                    <!--<th class="">区重点项目</th>-->
                    <!--<th class="">区局联席会项目</th>-->
                    <!--<th class="">海绵城市建设项目</th>-->
                    <!--<th class="">是否通过审批</th>-->
                    <!--<th class="">更新日期</th>-->
                    <th class="">操作</th>

                </tr>
                </thead>
                <tbody>
                <?php if(!empty($_list)): if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr><td><input class="ids" type="checkbox" value="<?php echo ($vo['id']); ?>" name="test"></td>

                            <td><?php echo ($vo["id"]); ?></td>
                            <td><?php echo ($vo["name"]); ?></td>
                            <!--<td><?php echo ($vo["fenlei"]); ?></td>-->
                            <td><?php echo ($vo["location"]); ?></td>

                            <td><?php echo ($vo["company"]); ?></td>
                            <td><?php echo ($vo["man"]); ?></td>
                            <td><?php echo ($vo["phone"]); ?></td>

                            <!--<td><?php echo ($vo["work_progress"]); ?></td>-->
                            <!--<td><?php echo ($vo["next_plan"]); ?></td>-->

                            <!--<td><?php echo ($vo["problem"]); ?></td>-->

                            <!--<td><?php echo ($vo["help"]); ?></td>-->
                            <!--<td><?php echo ($vo["action"]); ?></td>-->

                            <!--<td><?php echo ($vo["major"]); ?></td>-->
                            <!--<td><?php echo ($vo["major2"]); ?></td>-->
                            <!--<td><?php echo ($vo["major3"]); ?></td>-->
                            <!--<td><?php echo ($vo["major4"]); ?></td>-->
                            <!--<td><?php echo ($vo["haimian"]); ?></td>-->
                            <!--<td><?php echo ($vo["shenpi"]); ?></td>-->
                            <!--<td><?php echo ($vo["time"]); ?></td>-->

                            <td>
                                <!--<a href="<?php echo U('Index/xiangmu_copy_chakan',array('id'=>$vo['id'],'name'=>$vo['name'],'fenlei'=>$vo['fenlei'],'user_uid'=>$vo['user_uid']));?>" >查看</a>-->
                                <!--<br />-->
                                <a href="<?php echo U('Index/bianji',array('id'=>$vo['id']));?>" >查看</a>
                            </td>

                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php else: endif; ?>
                </tbody>
            </table>
        </div>
        <div class="page">

            <?php echo ($_page); ?>
        </div>

        <script type="text/javascript" src="/aaaa/Public/static/uploadify/jquery.uploadify.min.js"></script>


        </div>
<script src="/aaaa/Public/static/jquery-1.11.1.min.js"></script>
<script src="/aaaa/Public/static/bootstrap/js/bootstrap.min.js"></script>
<script src="/aaaa/Public/static/bootstrap/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(function(){
      $(".user-menu").click(function(){
      	$("#dropdown-menu").toggle()
      });
		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);
		$("#sidebar-collapse").height($(".side_right").height());
    })
</script>
	<!-- /主体 -->

	<!-- 底部 -->
	
<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "/aaaa", //当前网站地址
		"APP"    : "/aaaa/index.php?s=", //当前项目地址
		"PUBLIC" : "/aaaa/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>

    <script src="/aaaa/Public/static/thinkbox/jquery.thinkbox.js"></script>
    <link href="/aaaa/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
    <?php if(C('COLOR_STYLE')=='blue_color') echo '
        <link href="/aaaa/Public/static/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">
        '; ?>
    <link href="/aaaa/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/aaaa/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/aaaa/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script type="text/javascript">

        //搜索功能
        $("#search").click(function(){
            var url = $(this).attr('url');
            var query  = $('.search-form').find('input').serialize();
            query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
            query = query.replace(/^&/g,'');
            if( url.indexOf('?')>0 ){
                url += '&' + query;
            }else{
                url += '?' + query;
            }
            window.location.href = url;
        });

        $('#submit').click(function(){
            $('#form').submit();
        });
        $('#test').click(function(){

            obj = document.getElementsByName("test");
            check_val = [];
            for(k in obj){
                if(obj[k].checked)
                    check_val.push(obj[k].value);
            }

            $('#test').attr('href','<?php echo U('Index/dayin_xuanze');?>'+'&id='+check_val);

        })
        $(function(){
            $('.date').datetimepicker({
                format: 'yyyy-mm-dd',
                language:"zh-CN",
                minView:2,
                autoclose:true
            });
            $('.time').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language:"zh-CN",
                minView:2,
                autoclose:true
            });
//回车搜索
            $(".search-input").keyup(function(e){
                if(e.keyCode === 13){
                    $("#search").click();
                    return false;
                }
            });

        });
        $('.tiaozhuan').click(function(){
            var a=$('.page .current').text();

            var url=$('.tiaozhuan').attr("href");
            var p=$('#z').val();

            if(a=='1'){
                if(p=='1'){

                    $('.tiaozhuan').attr("href","/aaaa/index.php?s=/Home/Index/index.html");


                }else {

                    url=url.substr(0,31);
                    url=url+"/p/"+p+".html";


                    $('.tiaozhuan').attr("href",url);


                }

            }else {

                url=url.substr(0,31);
                url=url+"/p/"+p+".html";

                $('.tiaozhuan').attr("href",url);

            }



        })
    </script>

 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</body>
</html>