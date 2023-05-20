<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:94:"C:\xampp\htdocs\phpsystem\public/../application/back\view\paperSubject\paperSubject_query.html";i:1550587161;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/paperSubject.css" />

<div id="paperSubject_manage"></div>
<div id="paperSubject_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="paperSubject_manage_tool.edit();">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="paperSubject_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="paperSubject_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="paperSubject_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="paperSubject_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="paperSubjectQueryForm" method="post">
			测试试卷：<input class="textbox" type="text" id="paperObj_paperId_query" name="paperObj.paperId" style="width: auto"/>
			题库题目：<input class="textbox" type="text" id="subjectObj_subjectId_query" name="subjectObj.subjectId" style="width: auto"/>
			添加时间：<input type="text" id="addTime" name="addTime" class="easyui-datebox" editable="false" style="width:100px">
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="paperSubject_manage_tool.search();">查询</a>
		</form>	
	</div>
</div>

<div id="paperSubjectEditDiv">
	<form id="paperSubjectEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">试卷题目id:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paperSubject_psId_edit" name="paperSubject_psId" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">测试试卷:</span>
			<span class="inputControl">
				<input class="textbox"  id="paperSubject_paperObj_paperId_edit" name="paperSubject_paperObj_paperId" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">题库题目:</span>
			<span class="inputControl">
				<input class="textbox"  id="paperSubject_subjectObj_subjectId_edit" name="paperSubject_subjectObj_subjectId" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">添加时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paperSubject_addTime_edit" name="paperSubject_addTime" />

			</span>

		</div>
	</form>
</div>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/paperSubject/paperSubject_manage.js"></script>
