<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"C:\xampp\htdocs\phpsystem\public/../application/back\view\homework\homework_add.html";i:1550587163;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/homework.css" />
<div id="homeworkAddDiv">
	<form id="homeworkAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">作业任务:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="homework_taskTitle" name="homework_taskTitle" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">作业要求:</span>
			<span class="inputControl">
                <textarea name="homework_taskContent" id="homework_taskContent" style="width:750px;height:500px;"></textarea>
			</span>

		</div>
		<div>
			<span class="label">布置的老师:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="homework_teacherObj_teacherNo" name="homework.teacherObj.teacherNo" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">作业日期:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="homework_homeworkDate" name="homework_homeworkDate" />

			</span>

		</div>
		<div class="operation">
			<a id="homeworkAddButton" class="easyui-linkbutton">添加</a>
			<a id="homeworkClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/homework/homework_add.js"></script>
