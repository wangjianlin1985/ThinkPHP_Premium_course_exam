var kejian_manage_tool = null; 
$(function () { 
	initKejianManageTool(); //建立Kejian管理对象
	kejian_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#kejian_manage").datagrid({
		url : backURL + getVisitPath("Kejian") + '/backList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "kejianId",
		sortOrder : "desc",
		toolbar : "#kejian_manage_tool",
		columns : [[
			{
				field : "kejianId",
				title : "课件id",
				width : 70,
			},
			{
				field : "title",
				title : "课件标题",
				width : 140,
			},
			{
				field : "kejianFile",
				title : "课件文件",
				width : "350px",
				formatter: function(val,row) {
 					if(val == "") return "暂无文件";
					return "<a href='" + publicURL + val + "' target='_blank' style='color:red;'>" + val + "</a>";
				}
 			},
			{
				field : "teacherObj",
				title : "发布老师",
				width : 140,
			},
			{
				field : "addTime",
				title : "发布时间",
				width : 140,
			},
		]],
	});

	$("#kejianEditDiv").dialog({
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
				if ($("#kejianEditForm").form("validate")) {
					//验证表单 
					if(!$("#kejianEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
						$("#kejianEditForm").form({
						    url: backURL + getVisitPath("Kejian") + "/update",
						    onSubmit: function(){
								if($("#kejianEditForm").form("validate"))  {
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
			                        $("#kejianEditDiv").dialog("close");
			                        kejian_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#kejianEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#kejianEditDiv").dialog("close");
				$("#kejianEditForm").form("reset"); 
			},
		}],
	});
});

function initKejianManageTool() {
	kejian_manage_tool = {
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
			$("#kejian_manage").datagrid("reload");
		},
		redo : function () {
			$("#kejian_manage").datagrid("unselectAll");
		},
		search: function() {
			var queryParams = $("#kejian_manage").datagrid("options").queryParams;
			queryParams["title"] = $("#title").val();
			queryParams["teacherObj.teacherNo"] = $("#teacherObj_teacherNo_query").combobox("getValue");
			queryParams["addTime"] = $("#addTime").datebox("getValue"); 
			$("#kejian_manage").datagrid("options").queryParams=queryParams; 
			$("#kejian_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#kejianQueryForm").form({
			    url: backURL + getVisitPath("Kejian") + "/outToExcel",
			});
			//提交表单
			$("#kejianQueryForm").submit();
		},
		remove : function () {
			var rows = $("#kejian_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var kejianIds = [];
						for (var i = 0; i < rows.length; i ++) {
							kejianIds.push(rows[i].kejianId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("Kejian") + "/deletes",
							data : {
								kejianIds : kejianIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#kejian_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#kejian_manage").datagrid("loaded");
									$("#kejian_manage").datagrid("load");
									$("#kejian_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#kejian_manage").datagrid("loaded");
									$("#kejian_manage").datagrid("load");
									$("#kejian_manage").datagrid("unselectAll");
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
			var rows = $("#kejian_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("Kejian") + "/update",
					type : "get",
					data : {
						kejianId : rows[0].kejianId,
					},
					dataType: "json",
					beforeSend : function () {
						$.messager.progress({
							text : "正在获取中...",
						});
					},
					success : function (kejian, response, status) {
						$.messager.progress("close");
						if (kejian) { 
							$("#kejianEditDiv").dialog("open");
							$("#kejian_kejianId_edit").val(kejian.kejianId);
							$("#kejian_kejianId_edit").validatebox({
								required : true,
								missingMessage : "请输入课件id",
								editable: false
							});
							$("#kejian_title_edit").val(kejian.title);
							$("#kejian_title_edit").validatebox({
								required : true,
								missingMessage : "请输入课件标题",
							});
							$("#kejian_kejianFile").val(kejian.kejianFile);
							if(kejian.kejianFile == "") $("#kejian_kejianFileA").html("暂无文件");
							else $("#kejian_kejianFileA").html(kejian.kejianFile);
							$("#kejian_kejianFileA").attr("href", publicURL + kejian.kejianFile);
							kejian_kejianDesc_editor.setContent(kejian.kejianDesc, false);
							$("#kejian_teacherObj_teacherNo_edit").combobox({
							    url: backURL + getVisitPath("Teacher") + "/listAll",
							    dataType: "json",
							    valueField:"teacherNo",
							    textField:"teacherName",
							    panelHeight: "auto",
						        editable: false, //不允许手动输入 
						        onLoadSuccess: function () { //数据加载完毕事件
									$("#kejian_teacherObj_teacherNo_edit").combobox("select", kejian.teacherObj);
									//var data = $("#kejian_teacherObj_teacherNo_edit").combobox("getData"); 
						            //if (data.length > 0) {
						                //$("#kejian_teacherObj_teacherNo_edit").combobox("select", data[0].teacherNo);
						            //}
								}
							});
							$("#kejian_addTime_edit").datetimebox({
								value: kejian.addTime,
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
