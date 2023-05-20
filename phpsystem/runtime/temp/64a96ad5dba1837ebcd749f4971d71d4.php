<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"C:\xampp\htdocs\phpsystem\public/../application/back\view\paper\paper_query.html";i:1550587160;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/paper.css" />

<div id="paper_manage"></div>
<div id="paper_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="paper_manage_tool.edit();">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="paper_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="paper_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="paper_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="paper_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="paperQueryForm" method="post">
			试卷名称：<input type="text" class="textbox" id="paperName" name="paperName" style="width:110px" />
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="paper_manage_tool.search();">查询</a>
		</form>	
	</div>
</div>

<div id="paperEditDiv">
	<form id="paperEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">试卷id:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paper_paperId_edit" name="paper_paperId" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">试卷名称:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paper_paperName_edit" name="paper_paperName" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">测试目标:</span>
			<span class="inputControl">
				<textarea id="paper_purpose_edit" name="paper_purpose" rows="8" cols="60"></textarea>

			</span>

		</div>
		<div>
			<span class="label">考试时间(分钟):</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paper_examTime_edit" name="paper_examTime" style="width:80px" />

			</span>

		</div>
		<div>
			<span class="label">试卷满分:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paper_totalScore_edit" name="paper_totalScore" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">试卷备注:</span>
			<span class="inputControl">
				<textarea id="paper_paperMemo_edit" name="paper_paperMemo" rows="8" cols="60"></textarea>

			</span>

		</div>
	</form>
</div>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/paper/paper_manage.js"></script>
