<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"C:\xampp\htdocs\phpsystem\public/../application/back\view\subject\subject_add.html";i:1550634810;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/subject.css" />
<div id="subjectAddDiv">
	<form id="subjectAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">题目标题:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_title" name="subject_title" style="width:400px" />

			</span>

		</div>
		<div>
			<span class="label">A:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_a_option" name="subject_a_option" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">B:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_b_option" name="subject_b_option" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">C:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_c_option" name="subject_c_option" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">D:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_d_option" name="subject_d_option" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">正确答案:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_rightOption" name="subject_rightOption" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">得分:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="subject_score" name="subject_score" style="width:80px" />

			</span>

		</div>
		<div class="operation">
			<a id="subjectAddButton" class="easyui-linkbutton">添加</a>
			<a id="subjectClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/subject/subject_add.js"></script>
