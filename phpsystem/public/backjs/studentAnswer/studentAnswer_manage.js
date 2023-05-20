var studentAnswer_manage_tool = null; 
$(function () { 
	initStudentAnswerManageTool(); //建立StudentAnswer管理对象
	studentAnswer_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#studentAnswer_manage").datagrid({
		url : backURL + getVisitPath("StudentAnswer") + '/backList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "answerId",
		sortOrder : "desc",
		toolbar : "#studentAnswer_manage_tool",
		columns : [[
			{
				field : "answerId",
				title : "学生答案id",
				width : 70,
			},
			{
				field : "paperObj",
				title : "测试试卷",
				width : 140,
			},
			{
				field : "subjectObj",
				title : "考试题目",
				width : 140,
			},
			{
				field : "studentOption",
				title : "学生答案",
				width : 140,
			},
			{
				field : "studentObj",
				title : "测试学生",
				width : 140,
			},
			{
				field : "examTime",
				title : "考试时间",
				width : 140,
			},
		]],
	});

	$("#studentAnswerEditDiv").dialog({
		title : "修改管理",
		top: "50px",
		width : 700,
		height : 515,
		modal : true,
		closed : true,
		iconCls : "icon-edit-new",
		buttons : [{
			text : "提交",
			iconCls : "icon-edit-new",
			handler : function () {
				if ($("#studentAnswerEditForm").form("validate")) {
					//验证表单 
					if(!$("#studentAnswerEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
						$("#studentAnswerEditForm").form({
						    url: backURL + getVisitPath("StudentAnswer") + "/update",
						    onSubmit: function(){
								if($("#studentAnswerEditForm").form("validate"))  {
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
			                        $("#studentAnswerEditDiv").dialog("close");
			                        studentAnswer_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#studentAnswerEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#studentAnswerEditDiv").dialog("close");
				$("#studentAnswerEditForm").form("reset"); 
			},
		}],
	});
});

function initStudentAnswerManageTool() {
	studentAnswer_manage_tool = {
		init: function() {
			$.ajax({
				url : backURL + getVisitPath("Paper") + "/listAll",
				type : "post",
				dataType: "json",
				success : function (data, response, status) {
					$("#paperObj_paperId_query").combobox({ 
					    valueField:"paperId",
					    textField:"paperName",
					    panelHeight: "200px",
				        editable: false, //不允许手动输入 
					});
					data.splice(0,0,{paperId:0,paperName:"不限制"});
					$("#paperObj_paperId_query").combobox("loadData",data); 
				}
			});
			$.ajax({
				url : backURL + getVisitPath("Subject") + "/listAll",
				type : "post",
				dataType: "json",
				success : function (data, response, status) {
					$("#subjectObj_subjectId_query").combobox({ 
					    valueField:"subjectId",
					    textField:"title",
					    panelHeight: "200px",
				        editable: false, //不允许手动输入 
					});
					data.splice(0,0,{subjectId:0,title:"不限制"});
					$("#subjectObj_subjectId_query").combobox("loadData",data); 
				}
			});
			$.ajax({
				url : backURL + getVisitPath("Student") + "/listAll",
				type : "post",
				dataType: "json",
				success : function (data, response, status) {
					$("#studentObj_user_name_query").combobox({ 
					    valueField:"user_name",
					    textField:"name",
					    panelHeight: "200px",
				        editable: false, //不允许手动输入 
					});
					data.splice(0,0,{user_name:"",name:"不限制"});
					$("#studentObj_user_name_query").combobox("loadData",data); 
				}
			});
		},
		reload : function () {
			$("#studentAnswer_manage").datagrid("reload");
		},
		redo : function () {
			$("#studentAnswer_manage").datagrid("unselectAll");
		},
		search: function() {
			var queryParams = $("#studentAnswer_manage").datagrid("options").queryParams;
			queryParams["paperObj.paperId"] = $("#paperObj_paperId_query").combobox("getValue");
			queryParams["subjectObj.subjectId"] = $("#subjectObj_subjectId_query").combobox("getValue");
			queryParams["studentObj.user_name"] = $("#studentObj_user_name_query").combobox("getValue");
			queryParams["examTime"] = $("#examTime").datebox("getValue"); 
			$("#studentAnswer_manage").datagrid("options").queryParams=queryParams; 
			$("#studentAnswer_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#studentAnswerQueryForm").form({
			    url: backURL + getVisitPath("StudentAnswer") + "/outToExcel",
			});
			//提交表单
			$("#studentAnswerQueryForm").submit();
		},
		remove : function () {
			var rows = $("#studentAnswer_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var answerIds = [];
						for (var i = 0; i < rows.length; i ++) {
							answerIds.push(rows[i].answerId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("StudentAnswer") + "/deletes",
							data : {
								answerIds : answerIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#studentAnswer_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#studentAnswer_manage").datagrid("loaded");
									$("#studentAnswer_manage").datagrid("load");
									$("#studentAnswer_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#studentAnswer_manage").datagrid("loaded");
									$("#studentAnswer_manage").datagrid("load");
									$("#studentAnswer_manage").datagrid("unselectAll");
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
			var rows = $("#studentAnswer_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("StudentAnswer") + "/update",
					type : "get",
					data : {
						answerId : rows[0].answerId,
					},
					dataType: "json",
					beforeSend : function () {
						$.messager.progress({
							text : "正在获取中...",
						});
					},
					success : function (studentAnswer, response, status) {
						$.messager.progress("close");
						if (studentAnswer) { 
							$("#studentAnswerEditDiv").dialog("open");
							$("#studentAnswer_answerId_edit").val(studentAnswer.answerId);
							$("#studentAnswer_answerId_edit").validatebox({
								required : true,
								missingMessage : "请输入学生答案id",
								editable: false
							});
							$("#studentAnswer_paperObj_paperId_edit").combobox({
							    url: backURL + getVisitPath("Paper") + "/listAll",
							    dataType: "json",
							    valueField:"paperId",
							    textField:"paperName",
							    panelHeight: "auto",
						        editable: false, //不允许手动输入 
						        onLoadSuccess: function () { //数据加载完毕事件
									$("#studentAnswer_paperObj_paperId_edit").combobox("select", studentAnswer.paperObj);
									//var data = $("#studentAnswer_paperObj_paperId_edit").combobox("getData"); 
						            //if (data.length > 0) {
						                //$("#studentAnswer_paperObj_paperId_edit").combobox("select", data[0].paperId);
						            //}
								}
							});
							$("#studentAnswer_subjectObj_subjectId_edit").combobox({
							    url: backURL + getVisitPath("Subject") + "/listAll",
							    dataType: "json",
							    valueField:"subjectId",
							    textField:"title",
							    panelHeight: "auto",
						        editable: false, //不允许手动输入 
						        onLoadSuccess: function () { //数据加载完毕事件
									$("#studentAnswer_subjectObj_subjectId_edit").combobox("select", studentAnswer.subjectObj);
									//var data = $("#studentAnswer_subjectObj_subjectId_edit").combobox("getData"); 
						            //if (data.length > 0) {
						                //$("#studentAnswer_subjectObj_subjectId_edit").combobox("select", data[0].subjectId);
						            //}
								}
							});
							$("#studentAnswer_studentOption_edit").val(studentAnswer.studentOption);
							$("#studentAnswer_studentOption_edit").validatebox({
								required : true,
								missingMessage : "请输入学生答案",
							});
							$("#studentAnswer_studentObj_user_name_edit").combobox({
							    url: backURL + getVisitPath("Student") + "/listAll",
							    dataType: "json",
							    valueField:"user_name",
							    textField:"name",
							    panelHeight: "auto",
						        editable: false, //不允许手动输入 
						        onLoadSuccess: function () { //数据加载完毕事件
									$("#studentAnswer_studentObj_user_name_edit").combobox("select", studentAnswer.studentObj);
									//var data = $("#studentAnswer_studentObj_user_name_edit").combobox("getData"); 
						            //if (data.length > 0) {
						                //$("#studentAnswer_studentObj_user_name_edit").combobox("select", data[0].user_name);
						            //}
								}
							});
							$("#studentAnswer_examTime_edit").datetimebox({
								value: studentAnswer.examTime,
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
