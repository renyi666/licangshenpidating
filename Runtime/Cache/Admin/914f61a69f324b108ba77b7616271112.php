<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<table>
    <tr>
        <th>选择</th>
        <th>编号</th>
    <th>项目名称</th>
    </tr>
    <?php if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
<div name="list">
<td><input type="checkbox"  id="test" value="<?php echo ($vo['id']); ?>"></td>
</div>
        <td><?php echo ($vo["id"]); ?></td>
        <td><?php echo ($vo["name"]); ?></td>


    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

</table>
<!--<input type="checkbox" id="all">-->
<input type="button" id="selectAll" value="ceshi"><br>
<!--<input type="button" id="othercheck" value="反选"><br>-->

<!--<a href="<?php echo U('dayin_xuanze');?>">打印</a>-->
</body>
<script src="http://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
<script>

//    function  ceshi() {
//
//        alert("aaa");
//        var b= document.getElementById("list").value;
//        alert(b);
//    };
   $("#selectAll").click(function () {
      alert( $("#test").val());
       alert('aa');
   });
</script>
</html>