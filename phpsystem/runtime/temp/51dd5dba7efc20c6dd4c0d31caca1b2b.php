<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"C:\xampp\htdocs\phpsystem\public/../application/back\view\teacher\teacher_add.html";i:1550587159;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/teacher.css" />
<div id="teacherAddDiv">
	<form id="teacherAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">教师工号:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_teacherNo" name="teacher_teacherNo" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">登录密码:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_password" name="teacher_password" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">教师姓名:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_teacherName" name="teacher_teacherName" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">教师性别:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_teacherSex" name="teacher_teacherSex" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">教师年龄:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_teacherAge" name="teacher_teacherAge" style="width:80px" />

			</span>

		</div>
		<div>
			<span class="label">教师照片:</span>
			<span class="inputControl">
				<input id="teacherPhotoFile" name="teacherPhotoFile" type="file" size="50" />
			</span>
		</div>
		<div>
			<span class="label">入职日期:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_comeDate" name="teacher_comeDate" />

			</span>

		</div>
		<div>
			<span class="label">教师介绍:</span>
			<span class="inputControl">
                <textarea name="teacher_teacherDesc" id="teacher_teacherDesc" style="width:750px;height:500px;"></textarea>
			</span>

		</div>
		<div class="operation">
			<a id="teacherAddButton" class="easyui-linkbutton">添加</a>
			<a id="teacherClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/teacher/teacher_add.js"></script>
