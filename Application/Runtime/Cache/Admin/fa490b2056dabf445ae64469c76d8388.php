<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户申请入会处理页面</title>
    <script src="/shetuan/Public/admin/js/jquery.min.js"></script>
</head>
<body>
    <h1>用户申请入会处理页面</h1>
    <table border="2px solid">
        <tr>
        <td>申请人姓名</td>
        <td>申请加入社团名称</td>
        <td>申请理由</td>
        <td>申请时间</td>
        <td>操作</td>
        </tr>
    <?php if(is_array($res)): foreach($res as $k=>$val): ?><tr>
            <!--点击可以查看申请人的基本信息-->
        <td><?php echo ($val["username"]); ?></td>
        <td><?php echo ($val["departname"]); ?></td>
        <td><?php echo ($val["applyreason"]); ?></td>
        <td><?php echo ($val["applytime"]); ?></td>
            <!--同意和不同意两个操作
                1、不论进行同意或者不同意操作，将【未处理】改为【已处理】
                2、同意 status状态置为1 插入社团表
                3、不同意 删除本次申请，做软删除
            -->
        <td data-id="<?php echo ($val["joinid"]); ?>" data-did="<?php echo ($val["departid"]); ?>">
<button class="agreebtn">同意</button>|<button class="disagreebtn">不同意</button>
        </td>
        </tr><?php endforeach; endif; ?>
    </table>
</body>
<script>
    $(function () {
        $('table button').on('click',function () {
            var btn = $(this);
            var dotr = btn.closest('tr');
            var joinId = btn.parent().data('id');
            var departid = btn.parent().data('did');
            var param = {joinId:joinId,departid:departid};
            var btnclass = btn.attr('class');
            //因为只需要applyid一个值，所以在这里进行区分
            if(btnclass == 'agreebtn'){
                var url ="<?php echo U('Superadmin/agreeuserapply');?>";
            }else if (btnclass == 'disagreebtn'){
                var url ="<?php echo U('Superadmin/disagreeuserapply');?>";
            }
            $.ajax({
                url: url,
                data:param,
                dataType:'json',
                type:'post',
                success:function (data) {
                    alert(data.info);
                    if(data.status==1){
                        dotr.remove();
                    }
                },
                error:function () {
                    alert('操作失败');
                }
            })
        })
    })
</script>
</html>