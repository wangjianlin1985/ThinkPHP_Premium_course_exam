<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"C:\xampp\htdocs\phpsystem\public/../application/back\view\video\video_teacherAdd.html";i:1550667423;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/video.css" />
<div id="videoAddDiv">
	<form id="videoAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">视频标题:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="video_title" name="video_title" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">视频文件:</span>
			<span class="inputControl">
				<input id="videoFileFile" name="videoFileFile" type="file" size="50" />
			</span>
		</div>
		<div>
			<span class="label">视频介绍:</span>
			<span class="inputControl">
                <textarea name="video_videoDesc" id="video_videoDesc" style="width:750px;height:500px;"></textarea>
			</span>

		</div>
		<div style="display:none;">
			<span class="label">发布老师:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="video_teacherObj_teacherNo" name="video.teacherObj.teacherNo" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">发布时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="video_videoTime" name="video_videoTime" />

			</span>

		</div>
		<div class="operation">
			<a id="videoAddButton" class="easyui-linkbutton">上传视频</a>
			<a id="videoClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/video/video_teacher_add.js"></script>
