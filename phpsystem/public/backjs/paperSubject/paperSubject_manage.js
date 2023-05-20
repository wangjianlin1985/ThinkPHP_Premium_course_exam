var paperSubject_manage_tool = null; 
$(function () { 
	initPaperSubjectManageTool(); //建立PaperSubject管理对象
	paperSubject_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#paperSubject_manage").datagrid({
		url : backURL + getVisitPath("PaperSubject") + '/backList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "psId",
		sortOrder : "desc",
		toolbar : "#paperSubject_manage_tool",
		columns : [[
			{
				field : "psId",
				title : "试卷题目id",
				width : 70,
			},
			{
				field : "paperObj",
				title : "测试试卷",
				width : 140,
			},
			{
				field : "subjectObj",
				title : "题库题目",
				width : 140,
			},
			{
				field : "addTime",
				title : "添加时间",
				width : 140,
			},
		]],
	});

	$("#paperSubjectEditDiv").dialog({
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
				if ($("#paperSubjectEditForm").form("validate")) {
					//验证表单 
					if(!$("#paperSubjectEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
						$("#paperSubjectEditForm").form({
						    url: backURL + getVisitPath("PaperSubject") + "/update",
						    onSubmit: function(){
								if($("#paperSubjectEditForm").form("validate"))  {
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
			                        $("#paperSubjectEditDiv").dialog("close");
			                        paperSubject_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#paperSubjectEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#paperSubjectEditDiv").dialog("close");
				$("#paperSubjectEditForm").form("reset"); 
			},
		}],
	});
});

function initPaperSubjectManageTool() {
	paperSubject_manage_tool = {
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
		},
		reload : function () {
			$("#paperSubject_manage").datagrid("reload");
		},
		redo : function () {
			$("#paperSubject_manage").datagrid("unselectAll");
		},
		search: function() {
			var queryParams = $("#paperSubject_manage").datagrid("options").queryParams;
			queryParams["paperObj.paperId"] = $("#paperObj_paperId_query").combobox("getValue");
			queryParams["subjectObj.subjectId"] = $("#subjectObj_subjectId_query").combobox("getValue");
			queryParams["addTime"] = $("#addTime").datebox("getValue"); 
			$("#paperSubject_manage").datagrid("options").queryParams=queryParams; 
			$("#paperSubject_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#paperSubjectQueryForm").form({
			    url: backURL + getVisitPath("PaperSubject") + "/outToExcel",
			});
			//提交表单
			$("#paperSubjectQueryForm").submit();
		},
		remove : function () {
			var rows = $("#paperSubject_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var psIds = [];
						for (var i = 0; i < rows.length; i ++) {
							psIds.push(rows[i].psId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("PaperSubject") + "/deletes",
							data : {
								psIds : psIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#paperSubject_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#paperSubject_manage").datagrid("loaded");
									$("#paperSubject_manage").datagrid("load");
									$("#paperSubject_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#paperSubject_manage").datagrid("loaded");
									$("#paperSubject_manage").datagrid("load");
									$("#paperSubject_manage").datagrid("unselectAll");
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
			var rows = $("#paperSubject_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("PaperSubject") + "/update",
					type : "get",
					data : {
						psId : rows[0].psId,
					},
					dataType: "json",
					beforeSend : function () {
						$.messager.progress({
							text : "正在获取中...",
						});
					},
					success : function (paperSubject, response, status) {
						$.messager.progress("close");
						if (paperSubject) { 
							$("#paperSubjectEditDiv").dialog("open");
							$("#paperSubject_psId_edit").val(paperSubject.psId);
							$("#paperSubject_psId_edit").validatebox({
								required : true,
								missingMessage : "请输入试卷题目id",
								editable: false
							});
							$("#paperSubject_paperObj_paperId_edit").combobox({
							    url: backURL + getVisitPath("Paper") + "/listAll",
							    dataType: "json",
							    valueField:"paperId",
							    textField:"paperName",
							    panelHeight: "auto",
						        editable: false, //不允许手动输入 
						        onLoadSuccess: function () { //数据加载完毕事件
									$("#paperSubject_paperObj_paperId_edit").combobox("select", paperSubject.paperObj);
									//var data = $("#paperSubject_paperObj_paperId_edit").combobox("getData"); 
						            //if (data.length > 0) {
						                //$("#paperSubject_paperObj_paperId_edit").combobox("select", data[0].paperId);
						            //}
								}
							});
							$("#paperSubject_subjectObj_subjectId_edit").combobox({
							    url: backURL + getVisitPath("Subject") + "/listAll",
							    dataType: "json",
							    valueField:"subjectId",
							    textField:"title",
							    panelHeight: "auto",
						        editable: false, //不允许手动输入 
						        onLoadSuccess: function () { //数据加载完毕事件
									$("#paperSubject_subjectObj_subjectId_edit").combobox("select", paperSubject.subjectObj);
									//var data = $("#paperSubject_subjectObj_subjectId_edit").combobox("getData"); 
						            //if (data.length > 0) {
						                //$("#paperSubject_subjectObj_subjectId_edit").combobox("select", data[0].subjectId);
						            //}
								}
							});
							$("#paperSubject_addTime_edit").datetimebox({
								value: paperSubject.addTime,
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
