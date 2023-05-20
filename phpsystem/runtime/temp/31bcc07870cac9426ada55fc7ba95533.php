<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"C:\xampp\htdocs\phpsystem\public/../application/back\view\subject\subject_query.html";i:1550634829;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/subject.css" />

<div id="subject_manage"></div>
<div id="subject_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="subject_manage_tool.edit();">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="subject_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="subject_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="subject_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="subject_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="subjectQueryForm" method="post">
			题目标题：<input type="text" class="textbox" id="title" name="title" style="width:110px" />
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="subject_manage_tool.search();">查询</a>
		</form>	
	</div>
</div>

<div id="subjectEditDiv">
	<form id="subjectEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">题目id:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_subjectId_edit" name="subject_subjectId" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">题目标题:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_title_edit" name="subject_title" style="width:400px" />

			</span>

		</div>
		<div>
			<span class="label">A:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_a_option_edit" name="subject_a_option" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">B:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_b_option_edit" name="subject_b_option" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">C:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_c_option_edit" name="subject_c_option" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">D:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_d_option_edit" name="subject_d_option" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">正确答案:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_rightOption_edit" name="subject_rightOption" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">得分:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_score_edit" name="subject_score" style="width:80px" />

			</span>

		</div>
	</form>
</div>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/subject/subject_manage.js"></script>
