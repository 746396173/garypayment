<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="renderer" content="webkit">
<title><?php echo C("WEB_TITLE");?></title>
<link rel="shortcut icon" href="favicon.ico">
<link href="/Public/Front/css/bootstrap.min.css" rel="stylesheet">
<link href="/Public/Front/css/font-awesome.min.css" rel="stylesheet">
<link href="/Public/Front/css/animate.css" rel="stylesheet">
<link href="/Public/Front/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="/Public/Front/js/plugins/layui/css/layui.css"  media="all">
<style>
.layui-form-switch {width:54px;}
</style>
<body class="gray-bg">
    <div class="wrapper wrapper-content animated">

        <div class="row">
            <div class="col-sm-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">
                        <h5>模板管理</h5>
                        <div class="row">
							<div class="col-sm-2 pull-right" style="width: 280px;">
								<a href="javascript:;" id="addTemplate" class="layui-btn">添加供应商</a>
							</div>
                    	</div>
                    </div>

                    <div class="ibox-content">
                        
                        <div class="table-responsive">
                            <table class="table table-hover" lay-data="{width:'100%',limit:<?php echo ($rows); ?>}">
                                <thead>
                                    <tr>

                                        <th>编号</th>
                                        <th>模板名称</th>
                                        <th>模板代码</th>
										<th>是否默认</th>
										<th>添加时间</th>
                                        <th>修改时间</th>
										<th>备注</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                                        <td><?php echo ($data["id"]); ?></td>
                                        <td><?php echo ($data["name"]); ?></td>
                                        <td><?php echo ($data["theme"]); ?></td>
                                        <td>
											<div class="layui-form">
											<input type="checkbox" <?php if($data['is_default']): ?>checked<?php endif; ?> name="status" value="1" data-id="<?php echo ($data["id"]); ?>" data-name="<?php echo ($data["name"]); ?>" lay-skin="switch" lay-filter="switchTest" lay-text="开|关">
											</div>
										</td>
										<td><?php echo (date("Y-m-d H:i:s",$data["add_time"])); ?></td>
										<td><?php echo (date("Y-m-d H:i:s",$data["update_time"])); ?></td>
										<td><?php echo ($data["remarks"]); ?></td>
                                        <td>
                                        	<?php if(($data['id']) != "1"): ?><div class="layui-btn-group">
												<button class="layui-btn layui-btn-small" onclick="admin_edit('编辑模板','<?php echo U('Template/addSave',array('id'=>$data[id]));?>')">编辑</button>
											  
											  	<button class="layui-btn layui-btn-small" onclick="admin_del(this,'<?php echo $data[id];?>')">删除</button>
											</div><?php endif; ?>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>    
                                </tbody>
                            </table>
                        </div>
					    <div class="page"><?php echo ($page); ?></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="/Public/Front/js/jquery.min.js"></script>
    <script src="/Public/Front/js/bootstrap.min.js"></script>
    <script src="/Public/Front/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="/Public/Front/js/content.js"></script>
	<script src="/Public/Front/js/plugins/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use(['layer', 'form'], function(){
  var form = layui.form
  ,layer = layui.layer;

  //监听指定开关
  form.on('switch(switchTest)', function(data){
	var id = $(this).attr('data-id'),
	is_default = this.checked ? 1 : 0,
	title = $(this).attr('data-name');
	$.ajax({
		url:"<?php echo U('Template/editDefalut');?>",
		type:'post',
		data:"id="+id+"&is_default="+is_default,
		success:function(res){
			if(res.status){
				layer.tips('温馨提示：'+title+'开启', data.othis);
			}else{
				layer.tips('温馨提示：'+title+'关闭', data.othis);
			}
			location.replace(location.href);
		}
	});
  });



});

  //监听提交
  $('#addTemplate').on('click',function(){
	var w=640,h;
	if (h == null || h == '') {
		h=($(window).height() - 50);
	};
	layer.open({
		type: 2,
		fix: false, //不固定
		maxmin: true,
		shadeClose: true,
		area: [w+'px', h +'px'],
		shade:0.4,
		title: "添加模板",
		content: "<?php echo U('Template/addSave');?>"
	});
  });

 //编辑
 function admin_edit(title,url){
	var w=600,h;
	if (h == null || h == '') {
		h=($(window).height() - 50);
	};
	layer.open({
		type: 2,
		fix: false, //不固定
		maxmin: true,
		shadeClose: true,
		area: [w+'px', h +'px'],
		shade:0.4,
		title: title,
		content: url
	});
 }

 /*删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			url:"<?php echo U('Template/del');?>",
			type:'post',
			data:'id='+id,
			success:function(res){
				if(res.status){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
				}
			}
		});
	});
}

</script>
</body>
</html>