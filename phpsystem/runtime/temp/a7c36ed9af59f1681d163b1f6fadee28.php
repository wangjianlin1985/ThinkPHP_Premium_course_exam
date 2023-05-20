<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:94:"C:\xampp\htdocs\phpsystem\public/../application/back\view\studentAnswer\studentAnswer_add.html";i:1550587161;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/studentAnswer.css" />
<div id="studentAnswerAddDiv">
	<form id="studentAnswerAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">测试试卷:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="studentAnswer_paperObj_paperId" name="studentAnswer.paperObj.paperId" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">考试题目:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="studentAnswer_subjectObj_subjectId" name="studentAnswer.subjectObj.subjectId" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">学生答案:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="studentAnswer_studentOption" name="studentAnswer_studentOption" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">测试学生:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="studentAnswer_studentObj_user_name" name="studentAnswer.studentObj.user_name" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">考试时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="studentAnswer_examTime" name="studentAnswer_examTime" />

			</span>

		</div>
		<div class="operation">
			<a id="studentAnswerAddButton" class="easyui-linkbutton">添加</a>
			<a id="studentAnswerClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/studentAnswer/studentAnswer_add.js"></script>
