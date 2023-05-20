<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"C:\xampp\htdocs\phpsystem\public/../application/back\view\video\video_teacher_query.html";i:1550667750;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/video.css" />

<div id="video_manage"></div>
<div id="video_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="video_manage_tool.edit();">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="video_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="video_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="video_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="video_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="videoQueryForm" method="post">
			视频标题：<input type="text" class="textbox" id="title" name="title" style="width:110px" />
			<input class="textbox" type="hidden" id="teacherObj_teacherNo_query" name="teacherObj.teacherNo" style="width: auto"/>
			发布时间：<input type="text" id="videoTime" name="videoTime" class="easyui-datebox" editable="false" style="width:100px">
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="video_manage_tool.search();">查询</a>
		</form>	
	</div>
</div>

<div id="videoEditDiv">
	<form id="videoEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">视频id:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="video_videoId_edit" name="video_videoId" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">视频标题:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="video_title_edit" name="video_title" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">视频文件:</span>
			<span class="inputControl">
				<a id="video_videoFileA" style="color:red;margin-bottom:5px;">查看</a>&nbsp;&nbsp;
    			<input type="hidden" id="video_videoFile" name="video_videoFile"/>
				<input id="videoFileFile" name="videoFileFile" value="重新选择文件" type="file" size="50" />
			</span>
		</div>
		<div>
			<span class="label">视频介绍:</span>
			<span class="inputControl">
                <textarea name="video_videoDesc" id="video_videoDesc_edit" style="width:100%;height:500px;"></textarea>

			</span>

		</div>
		<div style="display:none;">
			<span class="label">发布老师:</span>
			<span class="inputControl">
				<input class="textbox"  id="video_teacherObj_teacherNo_edit" name="video_teacherObj_teacherNo" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">发布时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="video_videoTime_edit" name="video_videoTime" />

			</span>

		</div>
	</form>
</div>
<script>
//实例化编辑器
//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
var video_videoDesc_editor = UE.getEditor('video_videoDesc_edit'); //视频介绍编辑器
</script>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/video/video_teacher_manage.js"></script>
