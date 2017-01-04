<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>李沧区建设项目综合业务平台</title>
    <link href="/aaaa/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/aaaa/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/aaaa/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/aaaa/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/aaaa/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/aaaa/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/aaaa/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/aaaa/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/aaaa/Public/Admin/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="logo"></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
                <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            

	<form action="<?php echo U(Xiangmu/bianji2);?>" method="post">

		<?php if(is_array($result_1)): $i = 0; $__LIST__ = $result_1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$result_1): $mod = ($i % 2 );++$i;?><div class="form-item">
				<label class="item-label">项目名称</label>
				<div class="controls">
					<input class="text input-large" type="text" name="name" value="<?php echo ($_GET['name']); ?>"  />
				</div>

			</div>
		<div class="form-item">
			<label class="item-label">项目分类</label>
			<div class="controls">
				<select name="fenlei">
					分类：



					<?php if(is_array($fenlei)): $i = 0; $__LIST__ = $fenlei;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fenlei): $mod = ($i % 2 );++$i;?><option value='<?php echo ($fenlei['name']); ?>'     <?php if($result_1['fenlei'] == $fenlei['name']): ?>selected="selected"<?php endif; ?>><?php echo ($fenlei["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>

		</div>


		<div class="form-item">
			<label class="item-label">项目位置</label>
			<div class="controls">
				<input class="text input-large" type="text" name="location" value="<?php echo ($result_1['location']); ?>"  />
			</div>

		</div>
			<div class="form-item">
				<label class="item-label">责任单位</label>
				<div class="controls">
					<select name="company">
						分类：



						<?php if(is_array($company)): $i = 0; $__LIST__ = $company;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$company): $mod = ($i % 2 );++$i;?><option value='<?php echo ($company['company']); ?>'     <?php if($result_1['company'] == $company['company']): ?>selected="selected"<?php endif; ?>><?php echo ($company["company"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>

			</div>

			<div class="form-item">
				<label class="item-label">责任人</label>
				<div class="controls">
					<input class="text input-large" type="text" name="man" value="<?php echo ($result_1['man']); ?>" />
				</div>

			</div>

			<div class="form-item">
				<label class="item-label">联系电话</label>
				<div class="controls">
					<input class="text input-large" type="text" name="phone" value="<?php echo ($result_1['phone']); ?>"  />
				</div>

			</div>
			<div class="form-item">
				<label class="item-label">目前工作进展情况</label>
				<div class="controls">
					<input class="text input-large" type="text" name="work_progress" value="<?php echo ($result_1['work_progress']); ?>"  />
				</div>

			</div>
			<div class="form-item">
				<label class="item-label">下一步打算</label>
				<div class="controls">
					<input class="text input-large" type="text" name="next_plan" value="<?php echo ($result_1['next_plan']); ?>" />
				</div>

			</div>
			<div class="form-item">
				<label class="item-label">存在问题</label>
				<div class="controls">
					<input class="text input-large" type="text" name="problem" value="<?php echo ($result_1['problem']); ?>" />
				</div>



			</div>
			<div class="form-item">
				<label class="item-label">项目建设年度</label>
				<div class="controls">
					<input class="text input-large" type="text" name="construction_year" value="<?php echo ($result_1['construction_year']); ?>"  />
				</div>

			</div>
			<div class="form-item">
				<label class="item-label">建设内容</label>
				<div class="controls">
					<input class="text input-large" type="text" name="construction_content" value="<?php echo ($result_1['construction_content']); ?>"  />
				</div>

			</div>
			<div class="form-item">
				<label class="item-label">本月周进度计划安排</label>
				<div class="controls">
					<input class="text input-large" type="text" name="current_week" value="<?php echo ($result_1['current_week']); ?>"  />
				</div>

			</div>
			<div class="form-item">
				<label class="item-label">立项手续完成时间及文号</label>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time1" value="<?php echo ($result_1['finish_time1']); ?>"  />
				</div>

			</div>
			<div class="form-item">
				<label class="item-label">可研手续完成时间及文号</label>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time2" value="<?php echo ($result_1['finish_time2']); ?>"  />
				</div>

			</div>
			<div class="form-item">
				<label class="item-label">初步设计手续完成时间及文号</label>
				<div class="controls">
					<input class="text input-large" type="text" name="finish_time3" value="<?php echo ($result_1['finish_time3']); ?>"  />
				</div>

			</div>	<div class="form-item">
			<label class="item-label">水土保持手续完成时间及文号</label>
			<div class="controls">
				<input class="text input-large" type="text" name="finish_time4" value="<?php echo ($result_1['finish_time4']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">土地手续完成时间及文号</label>
			<div class="controls">
				<input class="text input-large" type="text" name="finish_time5" value="<?php echo ($result_1['finish_time5']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">规划手续完成时间及文号</label>
			<div class="controls">
				<input class="text input-large" type="text" name="finsih_time6" value="<?php echo ($result_1['finsih_time6']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">环保手续完成时间及文号</label>
			<div class="controls">
				<input class="text input-large" type="text" name="finish_time7" value="<?php echo ($result_1['finish_time7']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">施工图预算审核完成时间</label>
			<div class="controls">
				<input class="text input-large" type="text" name="finsih_time8" value="<?php echo ($result_1['finsih_time8']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">完成设计招标时间</label>
			<div class="controls">
				<input class="text input-large" type="text" name="finish_time9" value="<?php echo ($result_1['finish_time9']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">完成施工监理招标时间</label>
			<div class="controls">
				<input class="text input-large" type="text" name="finish_time10" value="<?php echo ($result_1['finish_time10']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">建设周期</label>
			<div class="controls">
				<input class="text input-large" type="text" name="finish_time11" value="<?php echo ($result_1['finish_time11']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">2016年6月计划安排</label>
			<div class="controls">
				<input class="text input-large" type="text" name="plan_01" value="<?php echo ($result_1['plan_01']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">2016年7月计划安排</label>
			<div class="controls">
				<input class="text input-large" type="text" name="plan_02" value="<?php echo ($result_1['plan_02']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">2016年8月计划安排</label>
			<div class="controls">
				<input class="text input-large" type="text" name="plan_03" value="<?php echo ($result_1['plan_03']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">2016年9月计划安排</label>
			<div class="controls">
				<input class="text input-large" type="text" name="plan_04" value="<?php echo ($result_1['plan_04']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">2016年10月计划安排</label>
			<div class="controls">
				<input class="text input-large" type="text" name="plan_05" value="<?php echo ($result_1['plan_05']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">2016年11月计划安排</label>
			<div class="controls">
				<input class="text input-large" type="text" name="plan_06" value="<?php echo ($result_1['plan_06']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">2016年12月计划安排</label>
			<div class="controls">
				<input class="text input-large" type="text" name="plan_07" value="<?php echo ($result_1['plan_07']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">2016年年度资金需求</label>
			<div class="controls">
				<input class="text input-large" type="text" name="money_need" value="<?php echo ($result_1['money_need']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">2017年计划安排</label>
			<div class="controls">
				<input class="text input-large" type="text" name="next_year_plan" value="<?php echo ($result_1['next_year_plan']); ?>"  />
			</div>

		</div>	<div class="form-item">
			<label class="item-label">2017年资金需求</label>
			<div class="controls">
				<input class="text input-large" type="text" name="money_need_next" value="<?php echo ($result_1['money_need_next']); ?>"  />
			</div>

			项目情况：
		
		<input type="checkbox" name="help" value="是"        
   <?php if($result_1['help'] == '是'): ?>checked<?php endif; ?> />
		是否需要协调
		
		
		<input type="checkbox" name="action" value="是" <?php if($result_1['action'] == '是'): ?>checked<?php endif; ?>/>是否开工
		<br />
		<br />
		<br />

		项目类别：
		<input type="checkbox" name="major" value="是"  <?php if($result_1['major'] == '是'): ?>checked<?php endif; ?>/>
		市重点项目
		<input type="checkbox" name="major2" value="是"  <?php if($result_1['major2'] == '是'): ?>checked<?php endif; ?>/>
		市政务办现场会项目
		<br />
		<input type="checkbox" name="major3" value="是" <?php if($result_1['major3'] == '是'): ?>checked<?php endif; ?> />
		区重点项目
		<input type="checkbox" name="major4" value="是"  <?php if($result_1['major4'] == '是'): ?>checked<?php endif; ?>/>
		区局联席会项目
		<br />
		<input type="hidden" name="id" value="<?php echo ($result_1['id']); ?>">
		<br />
		<br /><?php endforeach; endif; else: echo "" ;endif; ?>
		<input type="submit" name="save" value="保存" />
		<a href="<?php echo U('Xiangmu/index');?>">取消</a>
	</form>

        </div>
        <div class="cont-ft">
            <div class="copyright">

                <div class="fr">V<?php echo (ONETHINK_VERSION); ?></div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "/aaaa", //当前网站地址
            "APP"    : "/aaaa/admin.php?s=", //当前项目地址
            "PUBLIC" : "/aaaa/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/aaaa/Public/static/think.js"></script>
    <script type="text/javascript" src="/aaaa/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
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

	</script>

</body>
</html>