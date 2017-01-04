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
            

            
	<!-- 标题栏 -->
	<script type="text/javascript" src="/aaaa/Public/static/uploadify/jquery.uploadify.min.js"></script>



		<div>
			<a class="btn" href="<?php echo U('Xiangmu/dayin_major');?>">打印当前记录</a>


	<div class="data-table table-striped">
		<table class="">
			<thead>
				<tr>

					<th class="">编号</th>
					<th class="">项目名称</th>
					<th class="">项目分类</th>
					<th class="">项目位置</th>

					<th class="">责任单位</th>
					<th class="">责任人</th>
					<th class="">联系电话</th>
					<!--<th class="">最后登录IP</th>-->

					<th class="">目前工作进展情况</th>

					<th class="">下一步工作打算</th>
					<th class="">存在问题</th>

					<th class="">是否需要协调</th>
					<th class="">是否开工</th>

					<th class="">市重点项目</th>
					<th class="">市政务办现场会项目</th>
					<th class="">区重点项目</th>
					<th class="">区局联席会项目</th>

					<!--<th class="">项目建设年度</th>-->
					<!--<th class="">建设内容</th>-->
					<!--<th class="">本月周进度计划安排</th>-->
					<!--<th class="">立项手续完成时间及文号</th>-->
					<!--<th class="">可研手续完成时间及文号</th>-->
					<!--<th class="">初步设计手续完成时间及文号</th>-->
					<!--<th class="">水土保持手续完成时间及文号</th>-->
					<!--<th class="">土地手续完成时间及文号</th>-->
					<!--<th class="">规划手续完成时间及文号</th>-->
					<!--<th class="">环保手续完成时间及文号</th>-->
					<!--<th class="">施工图预算审核完成时间</th>-->
					<!--<th class="">完成设计招标时间</th>-->
					<!--<th class="">完成施工监理招标时间</th>-->
					<!--<th class="">建设周期</th>-->
					<!--<th class="">2016年6月计划安排</th>-->
					<!--<th class="">2016年7月计划安排</th>-->
					<!--<th class="">2016年8月计划安排</th>-->
					<!--<th class="">2016年9月计划安排</th>-->
					<!--<th class="">2016年10月计划安排</th>-->
					<!--<th class="">2016年11月计划安排</th>-->
					<!--<th class="">2016年12月计划安排</th>-->
					<!--<th class="">2016年年度资金需求</th>-->
					<!--<th class="">2017年工期计划安排</th>-->
					<!--<th class="">2017年资金需求</th>-->

					<th class="">更新日期</th>
					<th class="">操作</th>

				</tr>
			</thead>
			<tbody>
				<?php if(!empty($_list)): if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>

							<td><?php echo ($vo["id"]); ?> </td>
							<td><?php echo ($vo["name"]); ?></td>
							<td><?php echo ($vo["fenlei"]); ?></td>
							<td><?php echo ($vo["location"]); ?></td>

							<td><?php echo ($vo["company"]); ?></td>
							<td><?php echo ($vo["man"]); ?></td>
							<td><?php echo ($vo["phone"]); ?></td>

							<td><?php echo ($vo["work_progress"]); ?></td>
							<td><?php echo ($vo["next_plan"]); ?></td>

							<td><?php echo ($vo["problem"]); ?></td>

							<td><?php echo ($vo["help"]); ?></td>
							<td><?php echo ($vo["action"]); ?></td>

							<td><?php echo ($vo["major"]); ?></td>
							<td><?php echo ($vo["major2"]); ?></td>
							<td><?php echo ($vo["major3"]); ?></td>
							<td><?php echo ($vo["major4"]); ?></td>
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

							<td><?php echo ($vo["time"]); ?></td>

							<td>
							<eq name="vo.status" value="1">
								<a href="<?php echo U('Xiangmu/xiangmu_copy_chakan',array('id'=>$vo['id'],'name'=>$vo['name'],'fenlei'=>$vo['fenlei']));?>" >更新记录</a>

								<a href="<?php echo U('Xiangmu/bianji',array('id'=>$vo['id'],'name'=>$vo['name'],'fenlei'=>$vo['fenlei'],'man'=>$vo['man'],'company'=>$vo['company'],'location'=>$vo['location'],'phone'=>$vo['phone'],'work_progress'=>$vo['work_progress'],'next_plan'=>$vo['next_plan'],'problem'=>$vo['problem']));?>" >编辑</a>

								<a href="<?php echo U('Xiangmu/delete',array('id'=>$vo['id']));?>" >删除</a>
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
showTab();
//回车搜索
$(".search-input").keyup(function(e){
if(e.keyCode === 13){
$("#search").click();
return false;
}
});
//导航高亮
highlight_subnav('<?php echo U('User/index');?>');

});
	</script>

</body>
</html>