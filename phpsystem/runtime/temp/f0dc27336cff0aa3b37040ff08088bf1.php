<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"C:\xampp\htdocs\phpsystem\public/../application/back\view\classInfo\classInfo_add.html";i:1550587158;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/classInfo.css" />
<div id="classInfoAddDiv">
	<form id="classInfoAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">班级编号:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="classInfo_classNo" name="classInfo_classNo" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">班级名称:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="classInfo_className" name="classInfo_className" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">成立日期:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="classInfo_bornDate" name="classInfo_bornDate" />

			</span>

		</div>
		<div>
			<span class="label">班主任:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="classInfo_mainTeacher" name="classInfo_mainTeacher" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">班级备注:</span>
			<span class="inputControl">
				<textarea id="classInfo_classMemo" name="classInfo_classMemo" rows="6" cols="80"></textarea>

			</span>

		</div>
		<div class="operation">
			<a id="classInfoAddButton" class="easyui-linkbutton">添加</a>
			<a id="classInfoClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/classInfo/classInfo_add.js"></script>
