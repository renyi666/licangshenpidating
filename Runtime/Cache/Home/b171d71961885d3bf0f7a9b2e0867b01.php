<?php if (!defined('THINK_PATH')) exit();?><!--<!DOCTYPE HTML>-->
<!--<html>-->
<!--<head>-->
<!--<meta charset="UTF-8">-->
<!--<title><?php echo C('WEB_SITE_TITLE');?></title>-->
<!--<link href="/aaaa/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">-->
<!--<link href="/aaaa/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">-->
<!--<link href="/aaaa/Public/static/bootstrap/css/docs.css" rel="stylesheet">-->
<!--<link href="/aaaa/Public/static/bootstrap/css/onethink.css" rel="stylesheet">-->
<!--<link href="/aaaa/Public/Home/css/datepicker3.css" rel="stylesheet">-->
<!--<link href="/aaaa/Public/Home/css/styles.css" rel="stylesheet">-->
<!--&lt;!&ndash; Le HTML5 shim, for IE6-8 support of HTML5 elements &ndash;&gt;-->
<!--&lt;!&ndash;[if lt IE 9]>-->
<!--<script src="/aaaa/Public/static/bootstrap/js/html5shiv.js"></script>-->
<!--<![endif]&ndash;&gt;-->
<!---->
<!--&lt;!&ndash;[if lt IE 9]>-->
<!--<script type="text/javascript" src="/aaaa/Public/static/jquery-1.10.2.min.js"></script>-->
<!--<![endif]&ndash;&gt;-->
<!--&lt;!&ndash;[if gte IE 9]>&lt;!&ndash;>-->
<!--<script type="text/javascript" src="/aaaa/Public/static/jquery-2.0.3.min.js"></script>-->
<!--<script type="text/javascript" src="/aaaa/Public/static/bootstrap/js/bootstrap.min.js"></script>-->
<!--&lt;!&ndash;<![endif]&ndash;&gt;-->
<!--&lt;!&ndash; 页面header钩子，一般用于加载插件CSS文件和代码 &ndash;&gt;-->
<!--<?php echo hook('pageHeader');?>-->
<!--</head>-->
<!--<body>-->
	<!--<div class="row">-->
		<!--<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">-->
			<!--<div class="login-panel panel panel-default">-->
				<!--<div class="panel-heading">用户登录 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;    <a href="<?php echo U('register');?>">立即注册</a></div>-->

				<!--<div class="panel-body">-->
					<!--<form role="form" class="login-form" action="/aaaa/index.php?s=/Home/User/login.html" method="post">-->
						<!--<fieldset>-->
							<!--<div class="controls form-group">-->
								<!--<input id="inputEmail" class="form-control" name="username" type="text" autofocus=""placeholder="请输入用户名"  ajaxurl="/member/checkUserNameUnique.html" errormsg="请填写1-16位用户名" nullmsg="请填写用户名" datatype="*1-16" value=""/>-->
							<!--</div>-->
							<!--<div class="controls form-group">-->
								<!--<input id="inputPassword" class="form-control" name="password" type="password" value="" placeholder="请输入密码"  errormsg="密码为6-20位" nullmsg="请填写密码" datatype="*6-20" name="password">-->
							<!--</div>-->
							<!--<div class="controls form-group">-->
	              <!--<input type="text" id="inputPassword" class="span3" placeholder="请输入验证码"  errormsg="请填写5位验证码" nullmsg="请填写验证码" datatype="*5-5" name="verify">-->
	            <!--</div>-->
	            <!--<div class="control-group">-->
		            <!--<label class="control-label"></label>-->
		            <!--<div class="controls">-->
		                <!--<img class="verifyimg reloadverify" alt="点击切换" src="<?php echo U('verify');?>" style="cursor:pointer;">-->
		            <!--</div>-->
		            <!--<div class="controls Validform_checktip text-warning"></div>-->
		          <!--</div>-->
							<!--<div class="checkbox">-->
								<!--<label>-->
									<!--<input name="remember" type="checkbox" >自动登录-->
								<!--</label>-->
							<!--</div>-->
							<!--<button type="submit" class="btn btn-primary">登录</button>-->
						<!--</fieldset>-->
					<!--</form>-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>&lt;!&ndash; /.col&ndash;&gt;-->
	<!--</div>&lt;!&ndash; /.row &ndash;&gt;	-->


    <!---->

<!--&lt;!&ndash; 页面footer钩子，一般用于加载插件JS文件和JS代码 &ndash;&gt;-->
<!--<?php echo hook('pageFooter', 'widget');?>-->


	<!--<script type="text/javascript">-->

    	<!--$(document)-->





                <!--}-->
            <!--});-->
		<!--});-->
	<!--</script>-->
<!--</body>-->
<!--</html>-->

<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
	<title>李沧区建设项目综合业务平台</title>
	<link rel="stylesheet" href="/aaaa/Public/static/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="/aaaa/Public/Home/css/bootstrap-theme.min.css">
	<script src="/aaaa/Public/Home/js/jquery.min.js"></script>
	<link rel="stylesheet" href="/aaaa/Public/Home/css/css.css">
	<!--PNG图片兼容-->
	<!--[if lt IE 9]>
	<script src="//cdn.bootcss.com/html5 shiv/3.7.2/html5shiv.min.js"></script>
	<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!--[if IE 6]>
	<script src="js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script>
		/* EXAMPLE */
		DD_belatedPNG .fix('img,.mail,.ztxw-right');

		/* string argument can be any CSS selector */
		/* .png_bg example is unnecessary */
		/* change it to what suits you! */
	</script>
	<![endif]-->
	<!--PNG图片兼容end-->
</head>
<body style="background:#fff">
<div class="background">
	<div class="login-contant">

		<h3> 登录</h3>


		<input type="text" placeholder="账号" class="input" id="username"/>
		<input type="password" placeholder="密码" class="input2" id="password"/>
		<h4></h4>
		<div class="check-tips"></div>
		<input type="button" value="登录" class="button" id="btn"/>
		<div><a href="<?php echo U('User/register');?>">注册</a> </div>


	</div>
</div>
</body>
<script src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.js"></script>


<script type="text/javascript">

//	$("form").submit(function(){
//		var self = $(this);
//		$.post(self.attr("action"), self.serialize(), success, "json");
//		return false;
//		function success(data){
//			if(data.status){
//				window.location.href = data.url;
//			} else {
//alert("cuowu");
//			}
//		}
//	});
		$(document).ready(function(){
		$("#btn").click(function() {
			var self = $(this);
			var username = $("#username").val();
			var password = $("#password").val();
			$.ajax(
					{
						url:'<?php echo U('/Home/User/login');?>',
						data: {username: username, password: password},
						dataType: 'json',
						method:'post',
						success:function (data) {


							if(data.status){
								window.location.href = data.url;
							} else {
								self.find(".check-tips").text(data.info);
								//alert(data.info);
								$("h4").text(data.info);
								$("h4").show();

							}
//

						},




		});

		});

	});

</script>
</html>