<?php if (!defined('THINK_PATH')) exit();?>
    <h3>如果你希望添加新的项目，请继续操作</h3><br />
    <form action="<?php echo U('In/xinjian');?>" enctype="multipart/form-data" method="post" >

        <input type="file" name="biaoge" />
        <input type="submit" value="提交" >
    </form>