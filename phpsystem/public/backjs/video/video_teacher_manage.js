var video_manage_tool = null; 
$(function () { 
	initVideoManageTool(); //建立Video管理对象
	video_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#video_manage").datagrid({
		url : backURL + getVisitPath("Video") + '/teacherBackList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "videoId",
		sortOrder : "desc",
		toolbar : "#video_manage_tool",
		columns : [[
			{
				field : "videoId",
				title : "视频id",
				width : 70,
			},
			{
				field : "title",
				title : "视频标题",
				width : 140,
			},
			{
				field : "videoFile",
				title : "视频文件",
				width : "350px",
				formatter: function(val,row) {
 					if(val == "") return "暂无文件";
					return "<a href='" + publicURL + val + "' target='_blank' style='color:red;'>" + val + "</a>";
				}
 			},
			{
				field : "videoTime",
				title : "发布时间",
				width : 140,
			},
		]],
	});

	$("#videoEditDiv").dialog({
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
				if ($("#videoEditForm").form("validate")) {
					//验证表单 
					if(!$("#videoEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
						$("#videoEditForm").form({
						    url: backURL + getVisitPath("Video") + "/update",
						    onSubmit: function(){
								if($("#videoEditForm").form("validate"))  {
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
			                        $("#videoEditDiv").dialog("close");
			                        video_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#videoEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#videoEditDiv").dialog("close");
				$("#videoEditForm").form("reset"); 
			},
		}],
	});
});

function initVideoManageTool() {
	video_manage_tool = {
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
			$("#video_manage").datagrid("reload");
		},
		redo : function () {
			$("#video_manage").datagrid("unselectAll");
		},
		search: function() {
			var queryParams = $("#video_manage").datagrid("options").queryParams;
			queryParams["title"] = $("#title").val();
			queryParams["teacherObj.teacherNo"] = $("#teacherObj_teacherNo_query").combobox("getValue");
			queryParams["videoTime"] = $("#videoTime").datebox("getValue"); 
			$("#video_manage").datagrid("options").queryParams=queryParams; 
			$("#video_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#videoQueryForm").form({
			    url: backURL + getVisitPath("Video") + "/outToExcel",
			});
			//提交表单
			$("#videoQueryForm").submit();
		},
		remove : function () {
			var rows = $("#video_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var videoIds = [];
						for (var i = 0; i < rows.length; i ++) {
							videoIds.push(rows[i].videoId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("Video") + "/deletes",
							data : {
								videoIds : videoIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#video_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#video_manage").datagrid("loaded");
									$("#video_manage").datagrid("load");
									$("#video_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#video_manage").datagrid("loaded");
									$("#video_manage").datagrid("load");
									$("#video_manage").datagrid("unselectAll");
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
			var rows = $("#video_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("Video") + "/update",
					type : "get",
					data : {
						videoId : rows[0].videoId,
					},
					dataType: "json",
					beforeSend : function () {
						$.messager.progress({
							text : "正在获取中...",
						});
					},
					success : function (video, response, status) {
						$.messager.progress("close");
						if (video) { 
							$("#videoEditDiv").dialog("open");
							$("#video_videoId_edit").val(video.videoId);
							$("#video_videoId_edit").validatebox({
								required : true,
								missingMessage : "请输入视频id",
								editable: false
							});
							$("#video_title_edit").val(video.title);
							$("#video_title_edit").validatebox({
								required : true,
								missingMessage : "请输入视频标题",
							});
							$("#video_videoFile").val(video.videoFile);
							if(video.videoFile == "") $("#video_videoFileA").html("暂无文件");
							else $("#video_videoFileA").html(video.videoFile);
							$("#video_videoFileA").attr("href", publicURL + video.videoFile);
							video_videoDesc_editor.setContent(video.videoDesc, false);
							$("#video_teacherObj_teacherNo_edit").combobox({
							    url: backURL + getVisitPath("Teacher") + "/listAll",
							    dataType: "json",
							    valueField:"teacherNo",
							    textField:"teacherName",
							    panelHeight: "auto",
						        editable: false, //不允许手动输入 
						        onLoadSuccess: function () { //数据加载完毕事件
									$("#video_teacherObj_teacherNo_edit").combobox("select", video.teacherObj);
									//var data = $("#video_teacherObj_teacherNo_edit").combobox("getData"); 
						            //if (data.length > 0) {
						                //$("#video_teacherObj_teacherNo_edit").combobox("select", data[0].teacherNo);
						            //}
								}
							});
							$("#video_videoTime_edit").datetimebox({
								value: video.videoTime,
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
