var homework_manage_tool = null; 
$(function () { 
	initHomeworkManageTool(); //建立Homework管理对象
	homework_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#homework_manage").datagrid({
		url : backURL + getVisitPath("Homework") + '/backList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "homeworkId",
		sortOrder : "desc",
		toolbar : "#homework_manage_tool",
		columns : [[
			{
				field : "homeworkId",
				title : "作业id",
				width : 70,
			},
			{
				field : "taskTitle",
				title : "作业任务",
				width : 140,
			},
			{
				field : "teacherObj",
				title : "布置的老师",
				width : 140,
			},
			{
				field : "homeworkDate",
				title : "作业日期",
				width : 140,
			},
		]],
	});

	$("#homeworkEditDiv").dialog({
		title : "修改管理",
		top: "10px",
		width : 1000,
		height : 600,
		modal : true,
		closed : true,
		iconCls : "icon-edit-new",
		buttons : [{
			text : "提交",
			iconCls : "icon-edit-new",
			handler : function () {
				if ($("#homeworkEditForm").form("validate")) {
					//验证表单 
					if(!$("#homeworkEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
						$("#homeworkEditForm").form({
						    url: backURL + getVisitPath("Homework") + "/update",
						    onSubmit: function(){
								if($("#homeworkEditForm").form("validate"))  {
				                	$.messager.progress({
										text : "正在提交数据中...",
									});
				                	return true;
				                } else { 
				                    return false; 
				                }
						    },
						    success:function(data){
						    	$.messager.progress("close");
						    	console.log(data);
			                	var obj = jQuery.parseJSON(data);
			                    if(obj.success){
			                        $.messager.alert("消息","信息修改成功！");
			                        $("#homeworkEditDiv").dialog("close");
			                        homework_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#homeworkEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#homeworkEditDiv").dialog("close");
				$("#homeworkEditForm").form("reset"); 
			},
		}],
	});
});

function initHomeworkManageTool() {
	homework_manage_tool = {
		init: function() {
			$.ajax({
				url : backURL + getVisitPath("Teacher") + "/listAll",
				type : "post",
				dataType: "json",
				success : function (data, response, status) {
					$("#teacherObj_teacherNo_query").combobox({ 
					    valueField:"teacherNo",
					    textField:"teacherName",
					    panelHeight: "200px",
				        editable: false, //不允许手动输入 
					});
					data.splice(0,0,{teacherNo:"",teacherName:"不限制"});
					$("#teacherObj_teacherNo_query").combobox("loadData",data); 
				}
			});
		},
		reload : function () {
			$("#homework_manage").datagrid("reload");
		},
		redo : function () {
			$("#homework_manage").datagrid("unselectAll");
		},
		search: function() {
			var queryParams = $("#homework_manage").datagrid("options").queryParams;
			queryParams["taskTitle"] = $("#taskTitle").val();
			queryParams["teacherObj.teacherNo"] = $("#teacherObj_teacherNo_query").combobox("getValue");
			queryParams["homeworkDate"] = $("#homeworkDate").datebox("getValue"); 
			$("#homework_manage").datagrid("options").queryParams=queryParams; 
			$("#homework_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#homeworkQueryForm").form({
			    url: backURL + getVisitPath("Homework") + "/outToExcel",
			});
			//提交表单
			$("#homeworkQueryForm").submit();
		},
		remove : function () {
			var rows = $("#homework_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var homeworkIds = [];
						for (var i = 0; i < rows.length; i ++) {
							homeworkIds.push(rows[i].homeworkId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("Homework") + "/deletes",
							data : {
								homeworkIds : homeworkIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#homework_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#homework_manage").datagrid("loaded");
									$("#homework_manage").datagrid("load");
									$("#homework_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#homework_manage").datagrid("loaded");
									$("#homework_manage").datagrid("load");
									$("#homework_manage").datagrid("unselectAll");
									$.messager.alert("消息",data.message);
								}
							},
						});
					}
				});
			} else {
				$.messager.alert("提示", "请选择要删除的记录！", "info");
			}
		},
		edit : function () {
			var rows = $("#homework_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("Homework") + "/update",
					type : "get",
					data : {
						homeworkId : rows[0].homeworkId,
					},
					dataType: "json",
					beforeSend : function () {
						$.messager.progress({
							text : "正在获取中...",
						});
					},
					success : function (homework, response, status) {
						$.messager.progress("close");
						if (homework) { 
							$("#homeworkEditDiv").dialog("open");
							$("#homework_homeworkId_edit").val(homework.homeworkId);
							$("#homework_homeworkId_edit").validatebox({
								required : true,
								missingMessage : "请输入作业id",
								editable: false
							});
							$("#homework_taskTitle_edit").val(homework.taskTitle);
							$("#homework_taskTitle_edit").validatebox({
								required : true,
								missingMessage : "请输入作业任务",
							});
							homework_taskContent_editor.setContent(homework.taskContent, false);
							$("#homework_teacherObj_teacherNo_edit").combobox({
							    url: backURL + getVisitPath("Teacher") + "/listAll",
							    dataType: "json",
							    valueField:"teacherNo",
							    textField:"teacherName",
							    panelHeight: "auto",
						        editable: false, //不允许手动输入 
						        onLoadSuccess: function () { //数据加载完毕事件
									$("#homework_teacherObj_teacherNo_edit").combobox("select", homework.teacherObj);
									//var data = $("#homework_teacherObj_teacherNo_edit").combobox("getData"); 
						            //if (data.length > 0) {
						                //$("#homework_teacherObj_teacherNo_edit").combobox("select", data[0].teacherNo);
						            //}
								}
							});
							$("#homework_homeworkDate_edit").datebox({
								value: homework.homeworkDate,
							    required: true,
							    showSeconds: true,
							});
						} else {
							$.messager.alert("获取失败！", "未知错误导致失败，请重试！", "warning");
						}
					}
				});
			} else if (rows.length == 0) {
				$.messager.alert("警告操作！", "编辑记录至少选定一条数据！", "warning");
			}
		},
	};
}
