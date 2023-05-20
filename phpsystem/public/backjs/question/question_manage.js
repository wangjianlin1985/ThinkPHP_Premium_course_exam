var question_manage_tool = null; 
$(function () { 
	initQuestionManageTool(); //建立Question管理对象
	question_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#question_manage").datagrid({
		url : backURL + getVisitPath("Question") + '/backList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "questionId",
		sortOrder : "desc",
		toolbar : "#question_manage_tool",
		columns : [[
			{
				field : "questionId",
				title : "问题id",
				width : 70,
			},
			{
				field : "questionTitle",
				title : "提问标题",
				width : 140,
			},
			{
				field : "userObj",
				title : "提问学生",
				width : 140,
			},
			{
				field : "questionTime",
				title : "提问时间",
				width : 140,
			},
			{
				field : "replyContent",
				title : "答疑回复",
				width : 140,
			},
			{
				field : "replyTime",
				title : "答疑时间",
				width : 140,
			},
		]],
	});

	$("#questionEditDiv").dialog({
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
				if ($("#questionEditForm").form("validate")) {
					//验证表单 
					if(!$("#questionEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
						$("#questionEditForm").form({
						    url: backURL + getVisitPath("Question") + "/update",
						    onSubmit: function(){
								if($("#questionEditForm").form("validate"))  {
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
			                        $("#questionEditDiv").dialog("close");
			                        question_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#questionEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#questionEditDiv").dialog("close");
				$("#questionEditForm").form("reset"); 
			},
		}],
	});
});

function initQuestionManageTool() {
	question_manage_tool = {
		init: function() {
			$.ajax({
				url : backURL + getVisitPath("Student") + "/listAll",
				type : "post",
				dataType: "json",
				success : function (data, response, status) {
					$("#userObj_user_name_query").combobox({ 
					    valueField:"user_name",
					    textField:"name",
					    panelHeight: "200px",
				        editable: false, //不允许手动输入 
					});
					data.splice(0,0,{user_name:"",name:"不限制"});
					$("#userObj_user_name_query").combobox("loadData",data); 
				}
			});
		},
		reload : function () {
			$("#question_manage").datagrid("reload");
		},
		redo : function () {
			$("#question_manage").datagrid("unselectAll");
		},
		search: function() {
			var queryParams = $("#question_manage").datagrid("options").queryParams;
			queryParams["questionTitle"] = $("#questionTitle").val();
			queryParams["userObj.user_name"] = $("#userObj_user_name_query").combobox("getValue");
			queryParams["questionTime"] = $("#questionTime").datebox("getValue"); 
			$("#question_manage").datagrid("options").queryParams=queryParams; 
			$("#question_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#questionQueryForm").form({
			    url: backURL + getVisitPath("Question") + "/outToExcel",
			});
			//提交表单
			$("#questionQueryForm").submit();
		},
		remove : function () {
			var rows = $("#question_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var questionIds = [];
						for (var i = 0; i < rows.length; i ++) {
							questionIds.push(rows[i].questionId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("Question") + "/deletes",
							data : {
								questionIds : questionIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#question_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#question_manage").datagrid("loaded");
									$("#question_manage").datagrid("load");
									$("#question_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#question_manage").datagrid("loaded");
									$("#question_manage").datagrid("load");
									$("#question_manage").datagrid("unselectAll");
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
			var rows = $("#question_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("Question") + "/update",
					type : "get",
					data : {
						questionId : rows[0].questionId,
					},
					dataType: "json",
					beforeSend : function () {
						$.messager.progress({
							text : "正在获取中...",
						});
					},
					success : function (question, response, status) {
						$.messager.progress("close");
						if (question) { 
							$("#questionEditDiv").dialog("open");
							$("#question_questionId_edit").val(question.questionId);
							$("#question_questionId_edit").validatebox({
								required : true,
								missingMessage : "请输入问题id",
								editable: false
							});
							$("#question_questionTitle_edit").val(question.questionTitle);
							$("#question_questionTitle_edit").validatebox({
								required : true,
								missingMessage : "请输入提问标题",
							});
							question_questionContent_editor.setContent(question.questionContent, false);
							$("#question_userObj_user_name_edit").combobox({
							    url: backURL + getVisitPath("Student") + "/listAll",
							    dataType: "json",
							    valueField:"user_name",
							    textField:"name",
							    panelHeight: "auto",
						        editable: false, //不允许手动输入 
						        onLoadSuccess: function () { //数据加载完毕事件
									$("#question_userObj_user_name_edit").combobox("select", question.userObj);
									//var data = $("#question_userObj_user_name_edit").combobox("getData"); 
						            //if (data.length > 0) {
						                //$("#question_userObj_user_name_edit").combobox("select", data[0].user_name);
						            //}
								}
							});
							$("#question_questionTime_edit").datetimebox({
								value: question.questionTime,
							    required: true,
							    showSeconds: true,
							});
							question_replyContent_editor.setContent(question.replyContent, false);
							$("#question_replyTime_edit").datetimebox({
								value: question.replyTime,
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
