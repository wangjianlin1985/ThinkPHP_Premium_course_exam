$(function () {
	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	UE.delEditor('video_videoDesc_edit');
	var video_videoDesc_edit = UE.getEditor('video_videoDesc_edit'); //视频介绍编辑器
	video_videoDesc_edit.addListener("ready", function () {
		 // editor准备好之后才可以使用 
		 ajaxModifyQuery();
	}); 
  function ajaxModifyQuery() {	
	$.ajax({
		url :  backURL + getVisitPath("Video") + "/update",
		type : "get",
		data : {
			videoId : $("#video_videoId_edit").val(),
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
				$("#video_videoFileA").html(video.videoFile == ""?"暂无文件":video.videoFile);
				$("#video_videoFileA").attr("href", publicURL + video.videoFile);
				video_videoDesc_edit.setContent(video.videoDesc);
				$("#video_teacherObj_teacherNo_edit").combobox({
					url: backURL + getVisitPath("Teacher") + "/listAll",
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
				$(".messager-window").css("z-index",10000);
			}
		}
	});

  }

	$("#videoModifyButton").click(function(){ 
		if ($("#videoEditForm").form("validate")) {
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
                	var obj = jQuery.parseJSON(data);
                    if(obj.success){
                        $.messager.alert("消息","信息修改成功！");
                        $(".messager-window").css("z-index",10000);
                        //location.href="frontlist";
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    } 
			    }
			});
			//提交表单
			$("#videoEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
