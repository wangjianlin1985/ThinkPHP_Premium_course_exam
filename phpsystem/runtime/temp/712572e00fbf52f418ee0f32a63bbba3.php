<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"C:\xampp\htdocs\phpsystem\public/../application/back\view\student\student_query.html";i:1550587158;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/student.css" />

<div id="student_manage"></div>
<div id="student_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="student_manage_tool.edit();">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="student_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="student_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="student_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="student_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="studentQueryForm" method="post">
			学号：<input type="text" class="textbox" id="user_name" name="user_name" style="width:110px" />
			所在班级：<input class="textbox" type="text" id="classObj_classNo_query" name="classObj.classNo" style="width: auto"/>
			姓名：<input type="text" class="textbox" id="name" name="name" style="width:110px" />
			出生日期：<input type="text" id="birthDate" name="birthDate" class="easyui-datebox" editable="false" style="width:100px">
			联系电话：<input type="text" class="textbox" id="telephone" name="telephone" style="width:110px" />
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="student_manage_tool.search();">查询</a>
		</form>	
	</div>
</div>

<div id="studentEditDiv">
	<form id="studentEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">学号:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="student_user_name_edit" name="student_user_name" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">登录密码:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="student_password_edit" name="student_password" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">所在班级:</span>
			<span class="inputControl">
				<input class="textbox"  id="student_classObj_classNo_edit" name="student_classObj_classNo" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">姓名:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="student_name_edit" name="student_name" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">性别:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="student_gender_edit" name="student_gender" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">出生日期:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="student_birthDate_edit" name="student_birthDate" />

			</span>

		</div>
		<div>
			<span class="label">学生照片:</span>
			<span class="inputControl">
				<img id="student_userPhotoImg" width="200px" border="0px"/><br/>
    			<input type="hidden" id="student_userPhoto" name="student_userPhoto"/>
				<input id="userPhotoFile" name="userPhotoFile" type="file" size="50" />
			</span>
		</div>
		<div>
			<span class="label">联系电话:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="student_telephone_edit" name="student_telephone" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">邮箱:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="student_email_edit" name="student_email" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">家庭地址:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="student_address_edit" name="student_address" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">注册时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="student_regTime_edit" name="student_regTime" />

			</span>

		</div>
	</form>
</div>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/student/student_manage.js"></script>
