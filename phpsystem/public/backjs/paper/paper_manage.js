var paper_manage_tool = null; 
$(function () { 
	initPaperManageTool(); //建立Paper管理对象
	paper_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#paper_manage").datagrid({
		url : backURL + getVisitPath("Paper") + '/backList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "paperId",
		sortOrder : "desc",
		toolbar : "#paper_manage_tool",
		columns : [[
			{
				field : "paperId",
				title : "试卷id",
				width : 70,
			},
			{
				field : "paperName",
				title : "试卷名称",
				width : 140,
			},
			{
				field : "examTime",
				title : "考试时间(分钟)",
				width : 70,
			},
			{
				field : "totalScore",
				title : "试卷满分",
				width : 140,
			},
		]],
	});

	$("#paperEditDiv").dialog({
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
				if ($("#paperEditForm").form("validate")) {
					//验证表单 
					if(!$("#paperEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
						$("#paperEditForm").form({
						    url: backURL + getVisitPath("Paper") + "/update",
						    onSubmit: function(){
								if($("#paperEditForm").form("validate"))  {
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
			                        $("#paperEditDiv").dialog("close");
			                        paper_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#paperEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#paperEditDiv").dialog("close");
				$("#paperEditForm").form("reset"); 
			},
		}],
	});
});

function initPaperManageTool() {
	paper_manage_tool = {
		init: function() {
		},
		reload : function () {
			$("#paper_manage").datagrid("reload");
		},
		redo : function () {
			$("#paper_manage").datagrid("unselectAll");
		},
		search: function() {
			var queryParams = $("#paper_manage").datagrid("options").queryParams;
			queryParams["paperName"] = $("#paperName").val();
			$("#paper_manage").datagrid("options").queryParams=queryParams; 
			$("#paper_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#paperQueryForm").form({
			    url: backURL + getVisitPath("Paper") + "/outToExcel",
			});
			//提交表单
			$("#paperQueryForm").submit();
		},
		remove : function () {
			var rows = $("#paper_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var paperIds = [];
						for (var i = 0; i < rows.length; i ++) {
							paperIds.push(rows[i].paperId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("Paper") + "/deletes",
							data : {
								paperIds : paperIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#paper_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#paper_manage").datagrid("loaded");
									$("#paper_manage").datagrid("load");
									$("#paper_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#paper_manage").datagrid("loaded");
									$("#paper_manage").datagrid("load");
									$("#paper_manage").datagrid("unselectAll");
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
			var rows = $("#paper_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("Paper") + "/update",
					type : "get",
					data : {
						paperId : rows[0].paperId,
					},
					dataType: "json",
					beforeSend : function () {
						$.messager.progress({
							text : "正在获取中...",
						});
					},
					success : function (paper, response, status) {
						$.messager.progress("close");
						if (paper) { 
							$("#paperEditDiv").dialog("open");
							$("#paper_paperId_edit").val(paper.paperId);
							$("#paper_paperId_edit").validatebox({
								required : true,
								missingMessage : "请输入试卷id",
								editable: false
							});
							$("#paper_paperName_edit").val(paper.paperName);
							$("#paper_paperName_edit").validatebox({
								required : true,
								missingMessage : "请输入试卷名称",
							});
							$("#paper_purpose_edit").val(paper.purpose);
							$("#paper_purpose_edit").validatebox({
								required : true,
								missingMessage : "请输入测试目标",
							});
							$("#paper_examTime_edit").val(paper.examTime);
							$("#paper_examTime_edit").validatebox({
								required : true,
								validType : "integer",
								missingMessage : "请输入考试时间(分钟)",
								invalidMessage : "考试时间(分钟)输入不对",
							});
							$("#paper_totalScore_edit").val(paper.totalScore);
							$("#paper_totalScore_edit").validatebox({
								required : true,
								missingMessage : "请输入试卷满分",
							});
							$("#paper_paperMemo_edit").val(paper.paperMemo);
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
