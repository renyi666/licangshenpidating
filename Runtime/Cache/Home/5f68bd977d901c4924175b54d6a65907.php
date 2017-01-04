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
        	

	<form action="<?php echo U(Index/bianji);?>" method="post" style="padding-top: 20px;">
		<div class="bianji">
			<div class="row" style="margin:0;text-align: center;height: 35px;background: #eee;border:1px solid #ccc;">
				<h4>项目信息</h4>
			</div>
			<?php if(is_array($result_1)): $i = 0; $__LIST__ = $result_1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r1): $mod = ($i % 2 );++$i;?><ul>
					<li>
						<ul class="row" style="border-left:1px solid #ccc;">
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>项目名称</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<h5 contenteditable="false"><input type="text" class="form-control" name="name" value="<?php echo ($r1['name']); ?>" ></h5>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="col-sm-6 ">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>项目位置</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<h5 contenteditable="false"><input type="text" class="form-control" name="location" value="<?php echo ($r1['location']); ?>"style=" margin-top: 0px;"></h5>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li>
						<ul class="row" style="border-left:1px solid #ccc;">
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>项目分类</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<select name="fenlei">

												<?php if(is_array($list_fenlei)): $i = 0; $__LIST__ = $list_fenlei;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fenlei_stage): $mod = ($i % 2 );++$i;?><option value='<?php echo ($fenlei_stage['name']); ?>'<?php if($fenlei_stage['name'] == $r1['fenlei']): ?>selected<?php endif; ?>><?php echo ($fenlei_stage["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

											</select>										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="col-sm-6 ">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>责任单位</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<!--<h5 contenteditable="false">-->
											<!--&lt;!&ndash;<select name="company" class="select_company">&ndash;&gt;-->


												<!--&lt;!&ndash;<?php if(is_array($company)): $i = 0; $__LIST__ = $company;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$company): $mod = ($i % 2 );++$i;?>&ndash;&gt;-->

													<!--&lt;!&ndash;<option value='<?php echo ($company['company']); ?>'<?php if($r1['company'] == $company['company']): ?>selected="selected"<?php endif; ?>&ndash;&gt;-->

													<!--&lt;!&ndash;&gt;<?php echo ($company["company"]); ?></option>&ndash;&gt;-->
												<!--&lt;!&ndash;<?php endforeach; endif; else: echo "" ;endif; ?>&ndash;&gt;-->
												<!--&lt;!&ndash;&lt;!&ndash;<option value="another" class="another">其他</option>&ndash;&gt;&ndash;&gt;-->
											<!--&lt;!&ndash;</select>&ndash;&gt;-->

										<!--&lt;!&ndash;<input type="text" class="shuru" name="shuru" placeholder="请输入项目单位" style="display: none">&ndash;&gt;-->
												<!--<input type="text" class="form-control" name="company" value="<?php echo ($r1['company']); ?>" readonly>-->
											<!--</h5>-->
											<select name="company">

												<?php if(is_array($duty_result)): $i = 0; $__LIST__ = $duty_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$duty_result): $mod = ($i % 2 );++$i;?><option value="<?php echo ($duty_result['name']); ?>"<?php if($duty_result['name'] == $r1['company']): ?>selected<?php endif; ?>><?php echo ($duty_result["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
											</select>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li>
						<ul class="row" style="border-left:1px solid #ccc;">
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>责任人</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<h5 contenteditable="true"><input type="text" class="form-control" name="man" value="<?php echo ($r1['man']); ?>" ></h5>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="col-sm-6 ">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>联系电话</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<h5 contenteditable="true"><input type="text" class="form-control" name="phone" value="<?php echo ($r1['phone']); ?>" ></h5>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li>
						<ul class="row" style="border-left:1px solid #ccc;">
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>目前工作进展情况</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<h5 contenteditable="true"title="<?php echo ($r1["work_progress"]); ?>"><input type="text" class="form-control" name="work_progress" value="<?php echo ($r1['work_progress']); ?>" ></h5>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="col-sm-6 ">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>下一步打算</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<h5 contenteditable="true" title="<?php echo ($r1["next_plan"]); ?>"><input type="text" class="form-control" name="next_plan" value="<?php echo ($r1['next_plan']); ?>" ></h5>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li>
						<ul class="row" style="border-left:1px solid #ccc;">
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>存在问题</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<h5 contenteditable="true" title="<?php echo ($r1["problem"]); ?>"><input type="text" class="form-control" name="problem" value="<?php echo ($r1['problem']); ?>" ></h5>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="col-sm-6 ">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>投资额</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<h5 contenteditable="true"><input type="text" class="form-control" name="total_money" value="<?php echo ($r1['total_money']); ?>" ></h5>
										</div>
									</div>
								</div>
							</li>

						</ul>
					</li>
					<li>
						<ul class="row" style="border-left:1px solid #ccc;">
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>是否开工</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<!--<h5 contenteditable="true">-->
											<select name="action" class="select_action">
												<option value='是'<?php if($r1['action'] == '是'): ?>selected="selected"<?php endif; ?>

												>是
												</option>
												<option value='否'<?php if($r1['action'] == '否'): ?>selected="selected"<?php endif; ?>

												>否</option>

											</select>
											<!--</h5>-->
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>是否通过审批</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<!--<h5 contenteditable="true">-->
											<select name="shenpi" class="select_shenpi">
												<option value='是'<?php if($r1['shenpi'] == '是'): ?>selected="selected"<?php endif; ?>

												>是
												</option>
												<option value='否'<?php if($r1['shenpi'] == '否'): ?>selected="selected"<?php endif; ?>

												>否</option>

											</select>
											<!--</h5>-->
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li>
						<ul class="row" style="border-left:1px solid #ccc;">
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>市重点项目</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<!--<h5 contenteditable="true">-->
											<select name="major" class="select_major">
												<option value='是'<?php if($r1['major'] == '是'): ?>selected="selected"<?php endif; ?>

												>是
												</option>
												<option value='否'<?php if($r1['major'] == '否'): ?>selected="selected"<?php endif; ?>

												>否</option>

											</select>
											<!--</h5>-->
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>市政务办现场会项目</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<!--<h5 contenteditable="true">-->
											<select name="major2" class="select_major2">
												<option value='是'<?php if($r1['major2'] == '是'): ?>selected="selected"<?php endif; ?>

												>是
												</option>
												<option value='否'<?php if($r1['major2'] == '否'): ?>selected="selected"<?php endif; ?>

												>否</option>

											</select>
											<!--</h5>-->
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li>
						<ul class="row" style="border-left:1px solid #ccc;">
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>区重点项目</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<!--<h5 contenteditable="true">-->
											<select name="major3" class="select_major3">
												<option value='是'<?php if($r1['major3'] == '是'): ?>selected="selected"<?php endif; ?>

												>是
												</option>
												<option value='否'<?php if($r1['major3'] == '否'): ?>selected="selected"<?php endif; ?>

												>否</option>

											</select>
											<!--</h5>-->
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>区局联席会项目</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<!--<h5 contenteditable="true">-->
											<select name="major4" class="select_major4">
												<option value='是'<?php if($r1['major4'] == '是'): ?>selected="selected"<?php endif; ?>

												>是
												</option>
												<option value='否'<?php if($r1['major4'] == '否'): ?>selected="selected"<?php endif; ?>

												>否</option>

											</select>
											<!--</h5>-->
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li>
						<ul class="row" style="border-left:1px solid #ccc;">
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>海绵城市建设项目</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<!--<h5 contenteditable="true">-->
											<select name="haimian" class="select_haimian">
												<option value='是'<?php if($r1['haimian'] == '是'): ?>selected="selected"<?php endif; ?>

												>是
												</option>
												<option value='否'<?php if($r1['haimian'] == '否'): ?>selected="selected"<?php endif; ?>

												>否</option>

											</select>
											<!--</h5>-->
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5>是否需要协调</h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<!--<h5 contenteditable="true">-->
											<select name="help" class="select_help">
												<option value='是'<?php if($r1['help'] == '是'): ?>selected="selected"<?php endif; ?>

												>是
												</option>
												<option value='否'<?php if($r1['help'] == '否'): ?>selected="selected"<?php endif; ?>

												>否</option>

											</select>
											<!--</h5>-->
										</div>
									</div>
								</div>
							</li>
							<!--<li>-->
								<!--<div class="col-sm-6 ">-->
									<!--<div class="row">-->
										<!--<div class="col-xs-4 bianji_left">-->
											<!--<h5>投资额</h5>-->
										<!--</div>-->
										<!--<div class="col-sm-8 bianji_right">-->
											<!--<h5 contenteditable="true"><input type="text" class="form-control" name="total_money" value="<?php echo ($r1['total_money']); ?>" ></h5>-->
										<!--</div>-->
									<!--</div>-->
								<!--</div>-->
							<!--</li>-->
						</ul>
					</li>
					<li>
						<ul class="row" style="border-left:1px solid #ccc;">
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5><font color="#dc143c">打印请点这里</font></h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<h5 contenteditable="false">
												<a class="alert-success" href="<?php echo U('dayin_current',array('id'=>$r1['id']));?>">请点这里</a>

											</h5>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-xs-4 bianji_left">
											<h5><font color="#dc143c">剩余信息请点这里</font></h5>
										</div>
										<div class="col-sm-8 bianji_right">
											<h5 contenteditable="false">
												<a class="alert-success" href="<?php echo U('second',array('id'=>$r1['id']));?>">请点这里</a>
											</h5>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
				</ul><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="tuizi">
			<div class="row" style="margin:0;text-align: center;height: 35px;background: #eee;border:1px solid #ccc;">
				<h4>投资项目审批办理进度</h4>
			</div>
			<div class="class" style="width: 100%;overflow: hidden;">
				<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div class="row jieduan">
						》<?php echo ($data["name"]); ?>：
					</div>
					<table class="jieduan_cont">
						<thead>
						<tr>

							<td class="th1">事项名称</td>
							<!--<td class="th2">业务信息</td>-->
							<td class="th2">受理时间</td>
							<td class="th2">办结时间</td>

							<td class="th6"  hidden>id</td>
							<td class="th3">操作</td>
						</tr>
						</thead>
						<tbody>
						<?php if(is_array($data['item'])): $i = 0; $__LIST__ = $data['item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><tr>
								<td class="th1"><?php echo ($c["item_name"]); ?> </td>
								<!--<td class="th2">   </td>-->
								<td class="th2" name="start_time"><?php echo ($c["start_time"]); ?></td>
								<td class="th2" name="end_time"><?php echo ($c["end_time"]); ?></td>
								<td class="th6" name="id" hidden><?php echo ($c["id"]); ?></a></td>
								<td class="th3"><a href="#"class="luru">信息录入</a></td>

							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						<!--<tr>-->
						<!--<td class="th1">规划（建筑）方案征集及专家评定</td>-->
						<!--<td class="th2">无信息</td>-->
						<!--<td class="th2">2016&#45;&#45;09&#45;&#45;12</td>-->
						<!--<td class="th2">2016&#45;&#45;12&#45;&#45;23</td>-->
						<!--<td class="th3"><a href="">信息录入</a></td>-->
						<!--</tr>-->
						<!--<tr>-->
						<!--<td class="th1">规划（建筑）方案征集及专家评定</td>-->
						<!--<td class="th2">无信息</td>-->
						<!--<td class="th2">2016&#45;&#45;09&#45;&#45;12</td>-->
						<!--<td class="th2">2016&#45;&#45;12&#45;&#45;23</td>-->
						<!--<td class="th3"><a href="">信息录入</a></td>-->
						<!--</tr>-->
						</tbody>
					</table><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			<!--<div class="class" style="width: 100%;overflow: hidden;">-->
			<!--<div class="row jieduan">-->
			<!--》立项阶段：-->
			<!--</div>-->
			<!--<table class="jieduan_cont">-->
			<!--<thead>-->
			<!--<tr>-->
			<!--<td class="th1">事项名称</td>-->
			<!--<td class="th2">业务信息</td>-->
			<!--<td class="th2">受理时间</td>-->
			<!--<td class="th2">办结时间</td>-->
			<!--<td class="th3">操作</td>-->
			<!--</tr>-->
			<!--</thead>-->
			<!--<tbody>-->
			<!--<tr>-->
			<!--<td class="th1">规划（建筑）方案征集及专家评定</td>-->
			<!--<td class="th2">无信息</td>-->
			<!--<td class="th2">2016&#45;&#45;09&#45;&#45;12</td>-->
			<!--<td class="th2">2016&#45;&#45;12&#45;&#45;23</td>-->
			<!--<td class="th3"><a href="">信息录入</a></td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--<td class="th1">规划（建筑）方案征集及专家评定</td>-->
			<!--<td class="th2">无信息</td>-->
			<!--<td class="th2">2016&#45;&#45;09&#45;&#45;12</td>-->
			<!--<td class="th2">2016&#45;&#45;12&#45;&#45;23</td>-->
			<!--<td class="th3"><a href="">信息录入</a></td>-->
			<!--</tr>-->
			<!--</tbody>-->
			<!--</table>-->
			<!--</div>-->
		</div>
		<input type="hidden" name="id" value="<?php echo ($r1['id']); ?>">
		</volist>
		<input type="submit" name="save" value="保存" class="bt btn-success baocun"/>
		<a href="<?php echo U('Xiangmu/index');?>">取消</a>
	</form>


	<div class="theme-popover">
		<div class="theme-poptit">
			<a href="javascript:;" title="关闭" class="close">×</a>
			<h3>填写相关信息</h3>
		</div>
		<div class="theme-popbod dform">
			<form class="theme-signin" name="loginform" action="" method="post">
				<ol>
					<!--<li><h4>填写相关信息</h4></li>-->
					<li><input class="ipt" type="text" name="id"  size="20" hidden/></li>
					<li><strong>受理时间：</strong><input type="text" name="time1" class="text date"  id="start_time" placeholder="请选择时间" /></li>
					<li><strong>结束时间：</strong><input type="text" name="end_time" class="text date" id="end_time" value="" placeholder="请选择时间" /></li>

					<li><input class="btn btn-primary" type="button" class="submit"  name="submit" value=" 保  存" id="baocun"/></li>
				</ol>
			</form>
		</div>
	</div>

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
	<script src="/aaaa/Public/static/thinkbox/jquery.thinkbox.js"></script>
	<link href="/aaaa/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
	<?php if(C('COLOR_STYLE')=='blue_color') echo '
		<link href="/aaaa/Public/static/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">
		'; ?>
	<link href="/aaaa/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="/aaaa/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="/aaaa/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8">
		<script src="/aaaa/Public/static/thinkbox/jquery.thinkbox.js">

	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			var left = $(".bianji_left").height();
			var right = $(".bianji_right").height();
			var max = Math.max(left, right);
			console.log(max)
			$(".bianji_left").height(max);
			$(".bianji_right").height(max);

			$(".jieduan").click(function () {
				$(this).next().toggle()
			});

			//搜索功能
			$("#search").click(function () {
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
			$(".search-input").keyup(function (e) {
				if (e.keyCode === 13) {
					$("#search").click();
					return false;
				}
			});

			$(".select_company").change(function () {

				var res = $(".select_company").val();
				if (res == "another") {
					$(".shuru").show();


				} else {

					$(".shuru").hide();
				}

			})

			$('#baocun').click(function(){
				var item_id=$('.ipt').val();
				var start_time=$('#start_time').val();
				var end_time=$('#end_time').val();
				//alert(item_id);
				$.ajax(
						{
							url: '<?php echo U('/Home/Index/xiugai');?>',
							data: {id: item_id, start_time:start_time,end_time:end_time},
							dataType: 'json',
							method: 'post',
							success: function (data) {


								close();
								document.getElementById("start_time").value="";

								//window.location.reload();




							}


						}
				)

			})

			$(".luru").click(function () {

				//获得上一个节点的值
//			var res=$(this).prev().val();

				var res = $(this).parent().parent().find("td[name=id]").text();

				$('.theme-popover-mask').fadeIn(100);
				$('.theme-popover').slideDown(200);
				$('input[name=id]').val(res);



			})
function  close() {
	$('.theme-popover-mask').fadeOut(100);
	$('.theme-popover').slideUp(200);
	
}
			$('.theme-poptit .close').click(function () {

				$('.theme-popover-mask').fadeOut(100);
				$('.theme-popover').slideUp(200);
			})


			$('.date').datetimepicker({
				format: 'yyyy-mm-dd',
				language: "zh-CN",
				minView: 2,
				autoclose: true
			});
			$('.time').datetimepicker({
				format: 'yyyy-mm-dd hh:ii',
				language: "zh-CN",
				minView: 2,
				autoclose: true
			});
			showTab();
//回车搜索
			$(".search-input").keyup(function (e) {
				if (e.keyCode === 13) {
					$("#search").click();
					return false;
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