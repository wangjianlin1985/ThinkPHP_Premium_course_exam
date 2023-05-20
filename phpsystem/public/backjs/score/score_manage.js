var score_manage_tool = null; 
$(function () { 
	initScoreManageTool(); //建立Score管理对象
	score_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#score_manage").datagrid({
		url : backURL + getVisitPath("Score") + '/backList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "scoreId",
		sortOrder : "desc",
		toolbar : "#score_manage_tool",
		columns : [[
			{
				field : "scoreId",
				title : "成绩id",
				width : 70,
			},
			{
				field : "studentObj",
				title : "考试学生",
				width : 140,
			},
			{
				field : "paperObj",
				title : "测试试卷",
				width : 140,
			},
			{
				field : "chengji",
				title : "考试成绩",
				width : 70,
			},
			{
				field : "examTime",
				title : "考试时间",
				width : 140,
			},
		]],
	});

	$("#scoreEditDiv").dialog({
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
				if ($("#scoreEditForm").form("validate")) {
					//验证表单 
					if(!$("#scoreEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
						$("#scoreEditForm").form({
						    url: backURL + getVisitPath("Score") + "/update",
						    onSubmit: function(){
								if($("#scoreEditForm").form("validate"))  {
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
			                        $("#scoreEditDiv").dialog("close");
			                        score_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#scoreEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#scoreEditDiv").dialog("close");
				$("#scoreEditForm").form("reset"); 
			},
		}],
	});
});

function initScoreManageTool() {
	score_manage_tool = {
		init: function() {
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
		},
		reload : function () {
			$("#score_manage").datagrid("reload");
		},
		redo : function () {
			$("#score_manage").datagrid("unselectAll");
		},
		search: function() {
			var queryParams = $("#score_manage").datagrid("options").queryParams;
			queryParams["studentObj.user_name"] = $("#studentObj_user_name_query").combobox("getValue");
			queryParams["paperObj.paperId"] = $("#paperObj_paperId_query").combobox("getValue");
			queryParams["examTime"] = $("#examTime").datebox("getValue"); 
			$("#score_manage").datagrid("options").queryParams=queryParams; 
			$("#score_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#scoreQueryForm").form({
			    url: backURL + getVisitPath("Score") + "/outToExcel",
			});
			//提交表单
			$("#scoreQueryForm").submit();
		},
		remove : function () {
			var rows = $("#score_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var scoreIds = [];
						for (var i = 0; i < rows.length; i ++) {
							scoreIds.push(rows[i].scoreId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("Score") + "/deletes",
							data : {
								scoreIds : scoreIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#score_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#score_manage").datagrid("loaded");
									$("#score_manage").datagrid("load");
									$("#score_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#score_manage").datagrid("loaded");
									$("#score_manage").datagrid("load");
									$("#score_manage").datagrid("unselectAll");
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
			var rows = $("#score_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("Score") + "/update",
					type : "get",
					data : {
						scoreId : rows[0].scoreId,
					},
					dataType: "json",
					beforeSend : function () {
						$.messager.progress({
							text : "正在获取中...",
						});
					},
					success : function (score, response, status) {
						$.messager.progress("close");
						if (score) { 
							$("#scoreEditDiv").dialog("open");
							$("#score_scoreId_edit").val(score.scoreId);
							$("#score_scoreId_edit").validatebox({
								required : true,
								missingMessage : "请输入成绩id",
								editable: false
							});
							$("#score_studentObj_user_name_edit").combobox({
							    url: backURL + getVisitPath("Student") + "/listAll",
							    dataType: "json",
							    valueField:"user_name",
							    textField:"name",
							    panelHeight: "auto",
						        editable: false, //不允许手动输入 
						        onLoadSuccess: function () { //数据加载完毕事件
									$("#score_studentObj_user_name_edit").combobox("select", score.studentObj);
									//var data = $("#score_studentObj_user_name_edit").combobox("getData"); 
						            //if (data.length > 0) {
						                //$("#score_studentObj_user_name_edit").combobox("select", data[0].user_name);
						            //}
								}
							});
							$("#score_paperObj_paperId_edit").combobox({
							    url: backURL + getVisitPath("Paper") + "/listAll",
							    dataType: "json",
							    valueField:"paperId",
							    textField:"paperName",
							    panelHeight: "auto",
						        editable: false, //不允许手动输入 
						        onLoadSuccess: function () { //数据加载完毕事件
									$("#score_paperObj_paperId_edit").combobox("select", score.paperObj);
									//var data = $("#score_paperObj_paperId_edit").combobox("getData"); 
						            //if (data.length > 0) {
						                //$("#score_paperObj_paperId_edit").combobox("select", data[0].paperId);
						            //}
								}
							});
							$("#score_chengji_edit").val(score.chengji);
							$("#score_chengji_edit").validatebox({
								required : true,
								validType : "number",
								missingMessage : "请输入考试成绩",
								invalidMessage : "考试成绩输入不对",
							});
							$("#score_examTime_edit").datetimebox({
								value: score.examTime,
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
