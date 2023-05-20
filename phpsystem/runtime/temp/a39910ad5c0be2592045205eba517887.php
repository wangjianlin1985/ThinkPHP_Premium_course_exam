<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"C:\xampp\htdocs\phpsystem\public/../application/back\view\teacher\teacher_modify.html";i:1550587159;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/teacher.css" />
<div id="teacher_editDiv">
	<form id="teacherEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">教师工号:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_teacherNo_edit" name="teacher_teacherNo" value="<?php echo $teacherNo; ?>" style="width:200px" />
			</span>
		</div>

		<div>
			<span class="label">登录密码:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_password_edit" name="teacher_password" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">教师姓名:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_teacherName_edit" name="teacher_teacherName" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">教师性别:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_teacherSex_edit" name="teacher_teacherSex" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">教师年龄:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_teacherAge_edit" name="teacher_teacherAge" style="width:80px" />

			</span>

		</div>
		<div>
			<span class="label">教师照片:</span>
			<span class="inputControl">
				<img id="teacher_teacherPhotoImg" width="200px" border="0px"/><br/>
    			<input type="hidden" id="teacher_teacherPhoto" name="teacher_teacherPhoto"/>
				<input id="teacherPhotoFile" name="teacherPhotoFile" type="file" size="50" />
			</span>
		</div>
		<div>
			<span class="label">入职日期:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="teacher_comeDate_edit" name="teacher_comeDate" />

			</span>

		</div>
		<div>
			<span class="label">教师介绍:</span>
			<span class="inputControl">
				<script id="teacher_teacherDesc_edit" name="teacher_teacherDesc" type="text/plain"   style="width:750px;height:500px;"></script>

			</span>

		</div>
		<div class="operation">
			<a id="teacherModifyButton" class="easyui-linkbutton">更新</a> 
		</div>
	</form>
</div>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script src="__PUBLIC__/backjs/teacher/teacher_modify.js"></script>

