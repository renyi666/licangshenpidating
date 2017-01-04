<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<title><?php echo C('WEB_SITE_TITLE');?></title>
<link href="/aaaa/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/aaaa/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="/aaaa/Public/static/bootstrap/css/docs.css" rel="stylesheet">
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
		<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
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
        	

	<form action="<?php echo U(Index/bianji2);?>" method="post" style="padding-top:20px">
		<div class="bianji">
			<span>项目名称：</span>
			<?php if(is_array($result_1)): $i = 0; $__LIST__ = $result_1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r1): $mod = ($i % 2 );++$i;?><input type="text" name="name" value="<?php echo ($r1['name']); ?>"  readonly="true"/><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="bianji">
			<span>项目分类：</span>
			<select name="fenlei">
				分类：
	
				<?php if(is_array($fenlei)): $i = 0; $__LIST__ = $fenlei;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fenlei): $mod = ($i % 2 );++$i; if(is_array($result_1)): $i = 0; $__LIST__ = $result_1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r1): $mod = ($i % 2 );++$i;?><option value='<?php echo ($fenlei['name']); ?>'     <?php if($r1['fenlei'] == $fenlei['name']): ?>selected="selected"<?php endif; ?>><?php echo ($fenlei["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>
		<?php if(is_array($result_1)): $i = 0; $__LIST__ = $result_1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r1): $mod = ($i % 2 );++$i;?><div class="bianji">
				<span>项目位置：</span>
				<input type="text" name="location"  value="<?php echo ($r1['location']); ?>"/>
			</div>
			<div class="bianji">
				<span>项目单位</span>
				<div class="controls">
					<select name="company" class="select">


						<?php if(is_array($company)): $i = 0; $__LIST__ = $company;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$company): $mod = ($i % 2 );++$i; if(is_array($result_1)): $i = 0; $__LIST__ = $result_1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r1): $mod = ($i % 2 );++$i;?><option value='<?php echo ($company['name']); ?>'  <?php if($r1['company'] == $company['company']): ?>selected="selected"<?php endif; ?>

								><?php echo ($company["company"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
						<option value="another" class="another">其他</option>
					</select>
				</div>

			</div>





			<div class="bianji1"><span></span>
				<input type="text" class="shuru" name="shuru" placeholder="请输入项目单位">
			</div>
				<div class="bianji">
				<span>责任人：</span>
				<input type="text" name="man" value="<?php echo ($r1['man']); ?>" />
			</div>
			<div class="bianji">
				<span>联系电话：</span>
				<input type="text" name="phone"  value="<?php echo ($r1['phone']); ?>"/>
			</div>
			<div class="bianji">
				<span>目前工作进展情况：</span>
				<input type="text" name="work_progress" value="<?php echo ($r1['work_progress']); ?>"/>
			</div>
			<div class="bianji">
				<span>下一步打算：</span>
				<input type="text" name="next_plan"value="<?php echo ($r1['next_plan']); ?>" />
			</div>
			<div class="bianji" style="height:150px">
				<span>存在问题：</span>
				<textarea name="problem"><?php echo ($r1['problem']); ?></textarea>
			</div>
			<div class="bianji">
				<span>项目建设年度</span>
				<div class="controls">
					<input class="text input-large" type="text" name="construction_year" value="<?php echo ($r1['construction_year']); ?>" />
				</div>

			</div>
			<div class="bianji">
				<span>建设内容</span>
				<div class="controls">
					<input class="text input-large" type="text" name="construction_content" value="<?php echo ($r1['construction_content']); ?>" />
				</div>

			</div>
			<div class="bianji">
				<span>本月周进度计划安排</span>
				<div class="controls">
					<input class="text input-large" type="text" name="current_week" value="<?php echo ($r1['current_week']); ?>" />
				</div>
			</div>
			<div class="bianji">
				<span>立项手续完成时间及文号</span>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time1" value="<?php echo ($r1['finish_time1']); ?>" />
				</div>
			</div>
			<div class="bianji">
				<span>可研手续完成时间及文号</span>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time2" value="<?php echo ($r1['finish_time2']); ?>" />
				</div>

			</div>
			<div class="bianji">
				<span>初步设计手续完成时间及文号</span>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time3" value="<?php echo ($r1['finish_time3']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>水土保持手续完成时间及文号</span>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time4" value="<?php echo ($r1['finish_time4']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>土地手续完成时间及文号</span>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time5" value="<?php echo ($r1['finish_time5']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>规划手续完成时间及文号</span>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time6" value="<?php echo ($r1['finish_time6']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>环保手续完成时间及文号</span>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time7" value="<?php echo ($r1['finish_time7']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>施工图预算审核完成时间</span>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time8" value="<?php echo ($r1['finish_time8']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>完成设计招标时间</span>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time9" value="<?php echo ($r1['finish_time9']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>完成施工监理招标时间</span>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time10" value="<?php echo ($r1['finish_time10']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>建设周期</span>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time11" value="<?php echo ($r1['finish_time11']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>2016年6月计划安排</span>
				<div class="controls">
					<input class="text input-large" type="text" name="plan_01" value="<?php echo ($r1['plan_01']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>2016年7月计划安排</span>
				<div class="controls">
					<input class="text input-large" type="text" name="plan_02" value="<?php echo ($r1['plan_02']); ?>" />
				</div>

			</div>



			<div class="bianji">
				<span>2016年8月计划安排</span>
				<div class="controls">
					<input class="text input-large" type="text" name="plan_03" value="<?php echo ($r1['plan_03']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>2016年9月计划安排</span>
				<div class="controls">
					<input class="text input-large" type="text" name="plan_04" value="<?php echo ($r1['plan_04']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>2016年10月计划安排</span>
				<div class="controls">
					<input class="text input-large" type="text" name="plan_05" value="<?php echo ($r1['plan_05']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>2016年11月计划安排</span>
				<div class="controls">
					<input class="text input-large" type="text" name="plan_06" value="<?php echo ($r1['plan_06']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>2016年12月计划安排</span>
				<div class="controls">
					<input class="text input-large" type="text" name="plan_07" value="<?php echo ($r1['plan_07']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>2016年年度资金需求</span>
				<div class="controls">
					<input class="text input-large" type="text" name="money_need" value="<?php echo ($r1['money_need']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>2017年计划安排</span>
				<div class="controls">
					<input class="text input-large" type="text" name="next_year_plan" value="<?php echo ($r1['next_year_plan']); ?>" />
				</div>

			</div>

			<div class="bianji">
				<span>2017年资金需求</span>
				<div class="controls">
					<input class="text input-large" type="text" name="money_need_next" value="<?php echo ($r1['money_need_next']); ?>" />
				</div>
			</div>
			<div class="form-item">
	            <label class="item-label">项目情况：</label>
	            <div class="controls condition">
	                <label class="checkbox">
						<input type="checkbox" name="help" value="是"
							<?php if($r1['help'] == '是'): ?>checked<?php endif; ?> 
						/>
						是否需要协调
	                </label>
	                <label class="checkbox">
						<input type="checkbox" name="action" value="是" 
							<?php if($r1['action'] == '是'): ?>checked<?php endif; ?>
						/>
						是否开工
	                </label>
					<label class="checkbox">
						<input type="checkbox" name="shenpi" value="是" <?php if($r1['shenpi'] == '是'): ?>checked<?php endif; ?>/>
						是否通过审批
					</label>
	            </div>
	        </div>
			<div class="project_sort">
				<span>项目类别：</span>
				<div class="project_sort_item">
					<label class="checkbox">
						<input type="checkbox" name="major" value="是"
							<?php if($r1['major'] == '是'): ?>checked<?php endif; ?>
						/>
						市重点项目 
					</label>
					<label class="checkbox">
						<input type="checkbox" name="major2" value="是"
							<?php if($r1['major2'] == '是'): ?>checked<?php endif; ?>
						/>
						市政务办现场会项目 
					</label>
					<label class="checkbox">
						<input type="checkbox" name="major3" value="是"
							<?php if($r1['major3'] == '是'): ?>checked<?php endif; ?> 
						/>
						区重点项目
					</label>
					<label class="checkbox">
						<input type="checkbox" name="major4" value="是"
							<?php if($r1['major4'] == '是'): ?>checked<?php endif; ?>
						/>
						区局联席会项目 
					</label>
					<label class="checkbox">
						<input type="checkbox" name="haimian" value="是"
						<?php if($r1['haimian'] == '是'): ?>checked<?php endif; ?>
						/>
						海绵城市建设项目
					</label>
				</div>
			</div>
			<input type="hidden" name="id" value="<?php echo ($r1['id']); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
		<input type="submit" name="save" value="保存" class="bt btn-success baocun"/>
		<a href="<?php echo U('Xiangmu/index');?>">取消</a>
	</form>

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

	<script type="text/javascript">
		//搜索功能
		$("#search").click(function() {
			var url = $(this).attr('url');
			var query = $('.search-form').find('input').serialize();
			query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g, '');
			query = query.replace(/^&/g, '');
			if (url.indexOf('?') > 0) {
				url += '&' + query;
			} else {
				url += '?' + query;
			}
			window.location.href = url;
		});
		//回车搜索
		$(".search-input").keyup(function(e) {
			if (e.keyCode === 13) {
				$("#search").click();
				return false;
			}
		});
		//导航高亮
		$(document).ready(function(){
			$(".select").change(function () {
				var res=$(".select").val();
				if(res=="another"){
					$(".bianji1").show();

				}

			})


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