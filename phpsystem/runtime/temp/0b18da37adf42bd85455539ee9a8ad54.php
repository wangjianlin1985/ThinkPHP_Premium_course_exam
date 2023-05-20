<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"C:\xampp\htdocs\phpsystem\public/../application/back\view\kejian\kejian_add.html";i:1550587159;}*/ ?>
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
		<div>
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
			<a id="kejianAddButton" class="easyui-linkbutton">添加</a>
			<a id="kejianClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/kejian/kejian_add.js"></script>
