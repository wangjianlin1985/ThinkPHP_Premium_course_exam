<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"C:\xampp\htdocs\phpsystem\public/../application/back\view\kejian\kejian_query.html";i:1550587159;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/kejian.css" />

<div id="kejian_manage"></div>
<div id="kejian_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="kejian_manage_tool.edit();">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="kejian_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="kejian_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="kejian_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="kejian_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="kejianQueryForm" method="post">
			课件标题：<input type="text" class="textbox" id="title" name="title" style="width:110px" />
			发布老师：<input class="textbox" type="text" id="teacherObj_teacherNo_query" name="teacherObj.teacherNo" style="width: auto"/>
			发布时间：<input type="text" id="addTime" name="addTime" class="easyui-datebox" editable="false" style="width:100px">
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="kejian_manage_tool.search();">查询</a>
		</form>	
	</div>
</div>

<div id="kejianEditDiv">
	<form id="kejianEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">课件id:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="kejian_kejianId_edit" name="kejian_kejianId" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">课件标题:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="kejian_title_edit" name="kejian_title" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">课件文件:</span>
			<span class="inputControl">
				<a id="kejian_kejianFileA" style="color:red;margin-bottom:5px;">查看</a>&nbsp;&nbsp;
    			<input type="hidden" id="kejian_kejianFile" name="kejian_kejianFile"/>
				<input id="kejianFileFile" name="kejianFileFile" value="重新选择文件" type="file" size="50" />
			</span>
		</div>
		<div>
			<span class="label">课件描述:</span>
			<span class="inputControl">
                <textarea name="kejian_kejianDesc" id="kejian_kejianDesc_edit" style="width:100%;height:500px;"></textarea>

			</span>

		</div>
		<div>
			<span class="label">发布老师:</span>
			<span class="inputControl">
				<input class="textbox"  id="kejian_teacherObj_teacherNo_edit" name="kejian_teacherObj_teacherNo" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">发布时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="kejian_addTime_edit" name="kejian_addTime" />

			</span>

		</div>
	</form>
</div>
<script>
//实例化编辑器
//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
var kejian_kejianDesc_editor = UE.getEditor('kejian_kejianDesc_edit'); //课件描述编辑器
</script>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/kejian/kejian_manage.js"></script>
