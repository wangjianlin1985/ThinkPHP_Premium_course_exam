var subject_manage_tool = null; 
$(function () { 
	initSubjectManageTool(); //建立Subject管理对象
	subject_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#subject_manage").datagrid({
		url : backURL + getVisitPath("Subject") + '/backList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "subjectId",
		sortOrder : "desc",
		toolbar : "#subject_manage_tool",
		columns : [[
			{
				field : "subjectId",
				title : "题目id",
				width : 70,
			},
			{
				field : "title",
				title : "题目标题",
				width : 140,
			},
			{
				field : "a_option",
				title : "A",
				width : 140,
			},
			{
				field : "b_option",
				title : "B",
				width : 140,
			},
			{
				field : "c_option",
				title : "C",
				width : 140,
			},
			{
				field : "d_option",
				title : "D",
				width : 140,
			},
			{
				field : "rightOption",
				title : "正确答案",
				width : 140,
			},
			{
				field : "score",
				title : "得分",
				width : 70,
			},
		]],
	});

	$("#subjectEditDiv").dialog({
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
				if ($("#subjectEditForm").form("validate")) {
					//验证表单 
					if(!$("#subjectEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
						$("#subjectEditForm").form({
						    url: backURL + getVisitPath("Subject") + "/update",
						    onSubmit: function(){
								if($("#subjectEditForm").form("validate"))  {
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
			                        $("#subjectEditDiv").dialog("close");
			                        subject_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#subjectEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#subjectEditDiv").dialog("close");
				$("#subjectEditForm").form("reset"); 
			},
		}],
	});
});

function initSubjectManageTool() {
	subject_manage_tool = {
		init: function() {
		},
		reload : function () {
			$("#subject_manage").datagrid("reload");
		},
		redo : function () {
			$("#subject_manage").datagrid("unselectAll");
		},
		search: function() {
			var queryParams = $("#subject_manage").datagrid("options").queryParams;
			queryParams["title"] = $("#title").val();
			$("#subject_manage").datagrid("options").queryParams=queryParams; 
			$("#subject_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#subjectQueryForm").form({
			    url: backURL + getVisitPath("Subject") + "/outToExcel",
			});
			//提交表单
			$("#subjectQueryForm").submit();
		},
		remove : function () {
			var rows = $("#subject_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var subjectIds = [];
						for (var i = 0; i < rows.length; i ++) {
							subjectIds.push(rows[i].subjectId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("Subject") + "/deletes",
							data : {
								subjectIds : subjectIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#subject_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#subject_manage").datagrid("loaded");
									$("#subject_manage").datagrid("load");
									$("#subject_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#subject_manage").datagrid("loaded");
									$("#subject_manage").datagrid("load");
									$("#subject_manage").datagrid("unselectAll");
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
			var rows = $("#subject_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("Subject") + "/update",
					type : "get",
					data : {
						subjectId : rows[0].subjectId,
					},
					dataType: "json",
					beforeSend : function () {
						$.messager.progress({
							text : "正在获取中...",
						});
					},
					success : function (subject, response, status) {
						$.messager.progress("close");
						if (subject) { 
							$("#subjectEditDiv").dialog("open");
							$("#subject_subjectId_edit").val(subject.subjectId);
							$("#subject_subjectId_edit").validatebox({
								required : true,
								missingMessage : "请输入题目id",
								editable: false
							});
							$("#subject_title_edit").val(subject.title);
							$("#subject_title_edit").validatebox({
								required : true,
								missingMessage : "请输入题目标题",
							});
							$("#subject_a_option_edit").val(subject.a_option);
							$("#subject_a_option_edit").validatebox({
								required : true,
								missingMessage : "请输入A",
							});
							$("#subject_b_option_edit").val(subject.b_option);
							$("#subject_b_option_edit").validatebox({
								required : true,
								missingMessage : "请输入B",
							});
							$("#subject_c_option_edit").val(subject.c_option);
							$("#subject_c_option_edit").validatebox({
								required : true,
								missingMessage : "请输入C",
							});
							$("#subject_d_option_edit").val(subject.d_option);
							$("#subject_rightOption_edit").val(subject.rightOption);
							$("#subject_rightOption_edit").validatebox({
								required : true,
								missingMessage : "请输入正确答案",
							});
							$("#subject_score_edit").val(subject.score);
							$("#subject_score_edit").validatebox({
								required : true,
								validType : "number",
								missingMessage : "请输入得分",
								invalidMessage : "得分输入不对",
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
