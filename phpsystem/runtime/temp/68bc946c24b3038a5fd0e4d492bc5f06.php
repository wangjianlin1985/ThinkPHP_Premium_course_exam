<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"C:\xampp\htdocs\phpsystem\public/../application/back\view\question\question_query.html";i:1550654612;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/question.css" />

<div id="question_manage"></div>
<div id="question_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="question_manage_tool.edit();">学生答疑</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="question_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="question_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="question_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="question_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="questionQueryForm" method="post">
			提问标题：<input type="text" class="textbox" id="questionTitle" name="questionTitle" style="width:110px" />
			提问学生：<input class="textbox" type="text" id="userObj_user_name_query" name="userObj.user_name" style="width: auto"/>
			提问时间：<input type="text" id="questionTime" name="questionTime" class="easyui-datebox" editable="false" style="width:100px">
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="question_manage_tool.search();">查询</a>
		</form>	
	</div>
</div>

<div id="questionEditDiv">
	<form id="questionEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">问题id:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="question_questionId_edit" name="question_questionId" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">提问标题:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="question_questionTitle_edit" name="question_questionTitle" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">提问内容:</span>
			<span class="inputControl">
                <textarea name="question_questionContent" id="question_questionContent_edit" style="width:100%;height:500px;"></textarea>

			</span>

		</div>
		<div>
			<span class="label">提问学生:</span>
			<span class="inputControl">
				<input class="textbox"  id="question_userObj_user_name_edit" name="question_userObj_user_name" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">提问时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="question_questionTime_edit" name="question_questionTime" />

			</span>

		</div>
		<div>
			<span class="label">答疑回复:</span>
			<span class="inputControl">
                <textarea name="question_replyContent" id="question_replyContent_edit" style="width:100%;height:500px;"></textarea>

			</span>

		</div>
		<div>
			<span class="label">答疑时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="question_replyTime_edit" name="question_replyTime" />

			</span>

		</div>
	</form>
</div>
<script>
//实例化编辑器
//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
var question_questionContent_editor = UE.getEditor('question_questionContent_edit'); //提问内容编辑器
var question_replyContent_editor = UE.getEditor('question_replyContent_edit'); //答疑回复编辑器
</script>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/question/question_manage.js"></script>
