<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"C:\xampp\htdocs\phpsystem\public/../application/back\view\question\question_add.html";i:1550587162;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/question.css" />
<div id="questionAddDiv">
	<form id="questionAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">提问标题:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="question_questionTitle" name="question_questionTitle" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">提问内容:</span>
			<span class="inputControl">
                <textarea name="question_questionContent" id="question_questionContent" style="width:750px;height:500px;"></textarea>
			</span>

		</div>
		<div>
			<span class="label">提问学生:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="question_userObj_user_name" name="question.userObj.user_name" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">提问时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="question_questionTime" name="question_questionTime" />

			</span>

		</div>
		<div>
			<span class="label">答疑回复:</span>
			<span class="inputControl">
                <textarea name="question_replyContent" id="question_replyContent" style="width:750px;height:500px;"></textarea>
			</span>

		</div>
		<div>
			<span class="label">答疑时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="question_replyTime" name="question_replyTime" />

			</span>

		</div>
		<div class="operation">
			<a id="questionAddButton" class="easyui-linkbutton">添加</a>
			<a id="questionClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/question/question_add.js"></script>
