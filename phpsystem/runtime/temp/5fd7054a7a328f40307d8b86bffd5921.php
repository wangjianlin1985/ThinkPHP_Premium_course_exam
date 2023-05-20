<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"C:\xampp\htdocs\phpsystem\public/../application/back\view\homework\homework_query.html";i:1550587163;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/homework.css" />

<div id="homework_manage"></div>
<div id="homework_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="homework_manage_tool.edit();">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="homework_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="homework_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="homework_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="homework_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="homeworkQueryForm" method="post">
			作业任务：<input type="text" class="textbox" id="taskTitle" name="taskTitle" style="width:110px" />
			布置的老师：<input class="textbox" type="text" id="teacherObj_teacherNo_query" name="teacherObj.teacherNo" style="width: auto"/>
			作业日期：<input type="text" id="homeworkDate" name="homeworkDate" class="easyui-datebox" editable="false" style="width:100px">
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="homework_manage_tool.search();">查询</a>
		</form>	
	</div>
</div>

<div id="homeworkEditDiv">
	<form id="homeworkEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">作业id:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="homework_homeworkId_edit" name="homework_homeworkId" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">作业任务:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="homework_taskTitle_edit" name="homework_taskTitle" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">作业要求:</span>
			<span class="inputControl">
                <textarea name="homework_taskContent" id="homework_taskContent_edit" style="width:100%;height:500px;"></textarea>

			</span>

		</div>
		<div>
			<span class="label">布置的老师:</span>
			<span class="inputControl">
				<input class="textbox"  id="homework_teacherObj_teacherNo_edit" name="homework_teacherObj_teacherNo" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">作业日期:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="homework_homeworkDate_edit" name="homework_homeworkDate" />

			</span>

		</div>
	</form>
</div>
<script>
//实例化编辑器
//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
var homework_taskContent_editor = UE.getEditor('homework_taskContent_edit'); //作业要求编辑器
</script>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/homework/homework_manage.js"></script>
