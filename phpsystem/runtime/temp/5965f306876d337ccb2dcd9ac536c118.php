<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"C:\xampp\htdocs\phpsystem\public/../application/back\view\kejian\kejian_teacherAdd.html";i:1550654848;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/kejian.css" />
<div id="kejianAddDiv">
	<form id="kejianAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">课件标题:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="kejian_title" name="kejian_title" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">课件文件:</span>
			<span class="inputControl">
				<input id="kejianFileFile" name="kejianFileFile" type="file" size="50" />
			</span>
		</div>
		<div>
			<span class="label">课件描述:</span>
			<span class="inputControl">
                <textarea name="kejian_kejianDesc" id="kejian_kejianDesc" style="width:750px;height:500px;"></textarea>
			</span>

		</div>
		<div style="display:none;">
			<span class="label">发布老师:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="kejian_teacherObj_teacherNo" name="kejian.teacherObj.teacherNo" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">发布时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="kejian_addTime" name="kejian_addTime" />

			</span>

		</div>
		<div class="operation">
			<a id="kejianAddButton" class="easyui-linkbutton">课件发布</a>
			<a id="kejianClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/kejian/kejian_teacher_add.js"></script>
