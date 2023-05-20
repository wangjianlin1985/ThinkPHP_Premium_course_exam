<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"C:\xampp\htdocs\phpsystem\public/../application/back\view\score\score_query.html";i:1550587162;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/score.css" />

<div id="score_manage"></div>
<div id="score_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="score_manage_tool.edit();">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="score_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="score_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="score_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="score_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="scoreQueryForm" method="post">
			考试学生：<input class="textbox" type="text" id="studentObj_user_name_query" name="studentObj.user_name" style="width: auto"/>
			测试试卷：<input class="textbox" type="text" id="paperObj_paperId_query" name="paperObj.paperId" style="width: auto"/>
			考试时间：<input type="text" id="examTime" name="examTime" class="easyui-datebox" editable="false" style="width:100px">
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="score_manage_tool.search();">查询</a>
		</form>	
	</div>
</div>

<div id="scoreEditDiv">
	<form id="scoreEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">成绩id:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="score_scoreId_edit" name="score_scoreId" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">考试学生:</span>
			<span class="inputControl">
				<input class="textbox"  id="score_studentObj_user_name_edit" name="score_studentObj_user_name" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">测试试卷:</span>
			<span class="inputControl">
				<input class="textbox"  id="score_paperObj_paperId_edit" name="score_paperObj_paperId" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">考试成绩:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="score_chengji_edit" name="score_chengji" style="width:80px" />

			</span>

		</div>
		<div>
			<span class="label">考试时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="score_examTime_edit" name="score_examTime" />

			</span>

		</div>
	</form>
</div>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/score/score_manage.js"></script>
