<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:92:"C:\xampp\htdocs\phpsystem\public/../application/back\view\paperSubject\paperSubject_add.html";i:1550636708;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/paperSubject.css" />
<div id="paperSubjectAddDiv">
	<form id="paperSubjectAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">测试试卷:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paperSubject_paperObj_paperId" name="paperSubject.paperObj.paperId" style="width: 400px;"/>
			</span>
		</div>
		<div>
			<span class="label">题库题目:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paperSubject_subjectObj_subjectId" name="paperSubject.subjectObj.subjectId" style="width: 400px;"/>
			</span>
		</div>
		<div>
			<span class="label">添加时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paperSubject_addTime" name="paperSubject_addTime" />

			</span>

		</div>
		<div class="operation">
			<a id="paperSubjectAddButton" class="easyui-linkbutton">添加</a>
			<a id="paperSubjectClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/paperSubject/paperSubject_add.js"></script>
