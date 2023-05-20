<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"C:\xampp\htdocs\phpsystem\public/../application/back\view\score\score_add.html";i:1550587162;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/score.css" />
<div id="scoreAddDiv">
	<form id="scoreAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">考试学生:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="score_studentObj_user_name" name="score.studentObj.user_name" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">测试试卷:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="score_paperObj_paperId" name="score.paperObj.paperId" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">考试成绩:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="score_chengji" name="score_chengji" style="width:80px" />

			</span>

		</div>
		<div>
			<span class="label">考试时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="score_examTime" name="score_examTime" />

			</span>

		</div>
		<div class="operation">
			<a id="scoreAddButton" class="easyui-linkbutton">添加</a>
			<a id="scoreClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/score/score_add.js"></script>
