$(function(){
	//全选的实现
	$(".check-all").click(function(){
		$(".ids").prop("checked", this.checked);

	});
	$(".ids").click(function(){
		var option = $(".ids");
		option.each(function(i){
			if(!this.checked){
				$(".check-all").prop("checked", false);
				return false;
			}else{
				$(".check-all").prop("checked", true);
			}
		});
	});

	$('.ajax-post').click(function(){
		var target,query,form;
		var target_form = $(this).attr('target-form');
		var that = this;
		var nead_confirm=false;
		if( ($(this).attr('type')=='submit') || (target = $(this).attr('href')) || (target = $(this).attr('url')) ){
			form = $('.'+target_form);

			if ($(this).attr('hide-data') === 'true'){//无数据时也可以使用的功能
				form = $('.hide-data');
				query = form.serialize();
			}else if (form.get(0)==undefined){
				return false;
			}else if ( form.get(0).nodeName=='FORM' ){
				if ( $(this).hasClass('confirm') ) {
					if(!confirm('确认要执行该操作吗?')){
						return false;
					}
				}
				if($(this).attr('url') !== undefined){
					target = $(this).attr('url');
				}else{
					target = form.get(0).action;
				}
				query = form.serialize();
			}else if( form.get(0).nodeName=='INPUT' || form.get(0).nodeName=='SELECT' || form.get(0).nodeName=='TEXTAREA') {
				form.each(function(k,v){
					if(v.type=='checkbox' && v.checked==true){
						nead_confirm = true;
					}
				})
				if ( nead_confirm && $(this).hasClass('confirm') ) {
					if(!confirm('确认要执行该操作吗?')){
						return false;
					}
				}
				query = form.serialize();
			}else{
				if ( $(this).hasClass('confirm') ) {
					if(!confirm('确认要执行该操作吗?')){
						return false;
					}
				}
				query = form.find('input,select,textarea').serialize();
			}
			$(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
			$.post(target,query).success(function(data){
				if (data.status==1) {
					if (data.url) {
						updateAlert(data.info + ' 页面即将自动跳转~','alert-success');
					}else{
						updateAlert(data.info ,'alert-success');
					}
					setTimeout(function(){
						$(that).removeClass('disabled').prop('disabled',false);
						if (data.url) {
							location.href=data.url;
						}else if( $(that).hasClass('no-refresh')){
							$('#top-alert').find('button').click();
						}else{
							location.reload();
						}
					},1500);
				}else{
					updateAlert(data.info);
					setTimeout(function(){
						$(that).removeClass('disabled').prop('disabled',false);
						if (data.url) {
							location.href=data.url;
						}else{
							$('#top-alert').find('button').click();
						}
					},1500);
				}
			});
		}
		return false;
	});
	//图标隐藏菜单
	$(".entrance").hover(function(){
		$(this).children(".user-menu").show();
	},function(){
		$(this).children(".user-menu").hide();
	});

	$('.action .detailed').each(function(){
		$(this).click(function() {
        	detailed_content();
        	return false;
        });
  	});

	$('.action .thinkbox-image').each(function(){
		$(this).click(function() {
        	thinkbox_image();
        	return false;
        });
  	});

	(function(){
		var $nav = $("#nav"), $current = $nav.children("[data-key=" + $nav.data("key") + "]");
		if($nav.length){
			$current.addClass("current");
		} else {
			$("#nav").children().first().addClass("current");
		}
	})();
});
