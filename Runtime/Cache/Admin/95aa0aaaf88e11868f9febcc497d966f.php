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
            

            
	<!-- 标题栏 --><script type="text/javascript" src="/aaaa/Public/static/uploadify/jquery.uploadify.min.js"></script>
	<div class="main-title">
		<h2>查看更新状态</h2>
	</div>
	<div class="cf">
		<div class="fl">
			
            <a class="btn" href="<?php echo U('bianji3',array('xiangmu_id'=>$bb));?>">新建更新状态</a>
                    <a class="btn" href="<?php echo U('dayin_sousuo_xiangmu_copy',array('sql'=>$chazhao['0']));?>">打印当前记录</a>

        </div>

        <form action="<?php echo U('Next/sousuo_xiangmu_copy');?>" method="post">
        	
        
				创建日期：	<input type="text" name="time1" class="text time" value="" placeholder="请选择时间" />
				
				 
					<input type="text" name="time2" class="text time" value="" placeholder="请选择时间" />
				<?php if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="hidden" name="xiangmu_id" value="<?php echo ($vo["xiangmu_id"]); ?>" /><?php endforeach; endif; else: echo "" ;endif; ?>
				<input type="submit" name="submit" value="查询">    
				  </form>
        

        <!-- 高级搜索 -->
		<!--<div class="search-form fr cf">
			<div class="sleft">
				<input type="text" name="id" class="search-input" value="<?php echo I('id');?>" placeholder="请输入项目编号">
				<a class="sch-btn" href="javascript:;" id="search" url="<?php echo U('index');?>"><i class="btn-search"></i></a>
			</div>
		</div>-->
    </div>
    <!-- 数据列表 -->
    <div class="data-table table-striped">
	<table class="">
    <thead>
        <tr>
		<th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
		<th class="">项目编号</th>
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
		
		<th class="">更新日期</th>
		<th class="">操作</th>
		
		</tr>
    </thead>
    <tbody>
		<?php if(!empty($_list)): if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
             <td><input class="ids" type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>" /></td>
			<td><?php echo ($vo["xiangmu_id"]); ?> </td>
			<td><?php echo ($vo["name"]); ?></td>
			<td><?php echo ($vo["fenlei"]); ?></td>
			 <td><?php echo ($vo["location"]); ?></td>
			 
			<td><?php echo ($vo["company"]); ?></td>
			<td><?php echo ($vo["man"]); ?></td>
			 <td><?php echo ($vo["phone"]); ?></td>
			 
			<td><span><?php echo ($vo["work_progress"]); ?></span></td>
				<td><span><?php echo ($vo["next_plan"]); ?></span></td>
			
			<td><?php echo ($vo["problem"]); ?></td>
			
			
			
			<td><?php echo ($vo["help"]); ?></td>
			<td><?php echo ($vo["action"]); ?></td>
			
			
			<td><?php echo ($vo["major"]); ?></td>
			<td><?php echo ($vo["major2"]); ?></td>
			<td><?php echo ($vo["major3"]); ?></td>
			<td><?php echo ($vo["major4"]); ?></td>
			
		
			<td><?php echo ($vo["time"]); ?></td>
			
			
			<td><eq name="vo.status" value="1">
				
			
				
                <a href="<?php echo U('Next/xiangmu_copy_delete',array('id'=>$vo['id']));?>" >删除</a>
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
<?php if(C('COLOR_STYLE')=='blue_color') echo '<link href="/aaaa/Public/static/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">'; ?>
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