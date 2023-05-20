<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"C:\xampp\htdocs\phpsystem\public/../application/back\view\paper\paper_add.html";i:1550587160;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/paper.css" />
<div id="paperAddDiv">
	<form id="paperAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">试卷名称:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paper_paperName" name="paper_paperName" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">测试目标:</span>
			<span class="inputControl">
				<textarea id="paper_purpose" name="paper_purpose" rows="6" cols="80"></textarea>

			</span>

		</div>
		<div>
			<span class="label">考试时间(分钟):</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paper_examTime" name="paper_examTime" style="width:80px" />

			</span>

		</div>
		<div>
			<span class="label">试卷满分:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="paper_totalScore" name="paper_totalScore" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">试卷备注:</span>
			<span class="inputControl">
				<textarea id="paper_paperMemo" name="paper_paperMemo" rows="6" cols="80"></textarea>

			</span>

		</div>
		<div class="operation">
			<a id="paperAddButton" class="easyui-linkbutton">添加</a>
			<a id="paperClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/paper/paper_add.js"></script>
