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
				<div class="form-group">
					<input type="text" class="form-control" placeholder="搜索">
				</div>
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

            <!--<a class="btn btn-success " type="button" href="<?php echo U('Index/xinjian');?>">新增项目</a>-->
            <a class="btn btn-success " type="button" href="<?php echo U('Index/dayin_all');?>" style="margin-left:20px;">打印当前记录</a>
        </div>
        <div>
            <form action="<?php echo U('Index/next_sousuo');?>" method="post">

                创建日期：
                <input type="text" name="time1" class="text time" value="" placeholder="请选择时间" />

                <input type="text" name="time2" class="text time" value="" placeholder="请选择时间" />
                项目名称：	<input type="text" name="name" class="name" placeholder="请输入项目名称" />
                分类：
                <select name="fenlei"id="fenlei">
                    <option value=''></option>
                    <?php if(is_array($fenlei)): $i = 0; $__LIST__ = $fenlei;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fenlei): $mod = ($i % 2 );++$i;?><option value='<?php echo ($fenlei['name']); ?>'><?php echo ($fenlei["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                责任单位：
                <select name="company"id="company">
                    <option value=''></option>
                    <?php if(is_array($company)): $i = 0; $__LIST__ = $company;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$company): $mod = ($i % 2 );++$i;?><option value='<?php echo ($company['company']); ?>'><?php echo ($company["company"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>

                <input type="submit" value="查询" class="btn btn-success "style="margin-left:20px"/>
                <!--<div class="checkbox">-->
                <!--<label>-->
                <!--<input type="checkbox" name="new" value="是">-->
                <!--是否显示最新进展 </label>-->
                <!--</div>-->
                <div class="form-item">

                    <div class="controls" style="padding-left:20px">
                        <label class="checkbox" >
                            <input type="checkbox" name="help" value="是"
                            />
                            是否需要协调 </label>
                        <label class="checkbox">
                            <input type="checkbox" name="action" value="是" />
                            是否开工 </label>

                        <label class="checkbox">
                            <input type="checkbox" name="shenpi" value="是"/>
                            是否通过审批 </label>
                        <label class="checkbox" >
                            <input type="checkbox" name="major" value="是" />
                            市重点项目 </label>

                        <label class="checkbox" >
                            <input type="checkbox" name="major2" value="是" />
                            市政务办现场会项目 </label>

                        <label class="checkbox" >
                            <input type="checkbox" name="major3" value="是" />
                            区重点项目 </label>

                        <label class="checkbox" >
                            <input type="checkbox" name="major4" value="是" />
                            区局联席会项目 </label>

                        <label class="checkbox" >
                            <input type="checkbox" name="haimian" value="是" />
                            海绵城市建设项目 </label>



                    </div>

                </div>


            </form>
        </div>
        <!-- 数据列表 -->
        <div class="sort"  style="float: right;">
            <span></span>
            <a href="<?php echo U('Index/index',array('PHPSESSID'=>'rd23sbgojojkgfanu9bhh87m94','p'=>$next_now));?>"style="color:#005ea7">< 主要信息 丨</a>
            <a href="<?php echo U('Index/next_index');?>"  style="background: #fff2f2;color:#e4393c">更多信息 ></a>
        </div>
        <br>
        <div class="data-table table-striped">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="">编号</th>
                    <th class="">项目名称</th>
                    <th class="">项目建设年度</th>
                    <th class="">建设内容</th>

                    <th class="">本月周进度计划安排</th>
                    <th class="">2016年9月计划安排</th>
                    <th class="">2016年10月计划安排</th>
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
                <?php if(!empty($_list)): if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($vo["id"]); ?></td>
                            <td><?php echo ($vo["name"]); ?></td>
                            <td><?php echo ($vo["construction_year"]); ?></td>
                            <td><?php echo ($vo["construction_content"]); ?></td>

                            <td><?php echo ($vo["current_week"]); ?></td>
                            <td><?php echo ($vo["plan_01"]); ?></td>
                            <td><?php echo ($vo["plan_02"]); ?></td>

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




                <!--<tbody>-->
                <!--<?php if(!empty($_list)): ?>-->
                    <!--<?php if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                        <!--<tr>-->

                            <!--<td><?php echo ($vo["id"]); ?> </td>-->
                            <!--<td><?php echo ($vo["name"]); ?></td>-->



                            <!--<td><?php echo ($vo["construction_year"]); ?></td>-->
                            <!--<td><?php echo ($vo["construction_content"]); ?></td>-->
                            <!--<td><?php echo ($vo["current_week"]); ?></td>-->
                            <!--<td><?php echo ($vo["finish_time1"]); ?></td>-->
                            <!--<td><?php echo ($vo["finish_time2"]); ?></td>-->
                            <!--<td><?php echo ($vo["finish_time3"]); ?></td>-->
                            <!--<td><?php echo ($vo["finish_time4"]); ?></td>-->
                            <!--<td><?php echo ($vo["finish_time5"]); ?></td>-->
                            <!--<td><?php echo ($vo["finsih_time6"]); ?></td>-->
                            <!--<td><?php echo ($vo["finsih_time7"]); ?></td>-->
                            <!--<td><?php echo ($vo["finsih_time8"]); ?></td>-->
                            <!--<td><?php echo ($vo["finsih_time9"]); ?></td>-->
                            <!--<td><?php echo ($vo["finsih_time10"]); ?></td>-->
                            <!--<td><?php echo ($vo["finsih_time11"]); ?></td>-->
                            <!--<td><?php echo ($vo["plan_01"]); ?></td>-->
                            <!--<td><?php echo ($vo["plan_02"]); ?></td>-->
                            <!--<td><?php echo ($vo["plan_03"]); ?></td>-->
                            <!--<td><?php echo ($vo["plan_04"]); ?></td>-->
                            <!--<td><?php echo ($vo["plan_05"]); ?></td>-->
                            <!--<td><?php echo ($vo["plan_06"]); ?></td>-->
                            <!--<td><?php echo ($vo["plan_07"]); ?></td>-->
                            <!--<td><?php echo ($vo["money_need"]); ?></td>-->
                            <!--<td><?php echo ($vo["next_year_plan"]); ?></td>-->
                            <!--<td><?php echo ($vo["money_need_next"]); ?></td>-->





                            <!--<td><?php echo ($vo["time"]); ?></td>-->


                            <!--<td>-->
                                <!--<a href="<?php echo U('Index/next_xiangmu_copy_chakan',array('id'=>$vo['id'],'name'=>$vo['name'],'fenlei'=>$vo['fenlei'],'user_uid'=>$vo['user_uid']));?>" >查看</a>-->
                                <!--<br />-->
                                <!--<a href="<?php echo U('Index/bianji',array('id'=>$vo['id']));?>" >编辑</a>-->
                            <!--</td>-->

                        <!--</tr>-->
                    <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                    <!--<?php else: ?>-->

                <!--<?php endif; ?>-->
                <!--</tbody>-->
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
    </script>

 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</body>
</html>