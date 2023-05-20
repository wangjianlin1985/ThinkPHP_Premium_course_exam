$(function () {
	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	UE.delEditor('video_videoDesc');
	var video_videoDesc_editor = UE.getEditor('video_videoDesc'); //视频介绍编辑框
	$("#video_title").validatebox({
		required : true, 
		missingMessage : '请输入视频标题',
	});

	$("#video_teacherObj_teacherNo").combobox({
	    url: backURL + getVisitPath("Teacher") + '/listAll',
	    valueField: "teacherNo",
	    textField: "teacherName",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#video_teacherObj_teacherNo").combobox("getData"); 
            if (data.length > 0) {
                $("#video_teacherObj_teacherNo").combobox("select", data[0].teacherNo);
            }
        }
	});
	$("#video_videoTime").datetimebox({
	    required : true, 
	    showSeconds: true,
	    editable: false
	});

	//单击添加按钮
	$("#videoAddButton").click(function () {
		if(video_videoDesc_editor.getContent() == "") {
			alert("请输入视频介绍");
			return;
		}
		//验证表单 
		if(!$("#videoAddForm").form("validate")) {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		} else {
			$("#videoAddForm").form({
			    url: backURL + getVisitPath("Video") + "/teacherAdd",
			    onSubmit: function(){
					if($("#videoAddForm").form("validate"))  { 
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
                    //此处data={"Success":true}是字符串
                	var obj = jQuery.parseJSON(data); 
                    if(obj.success){ 
                        $.messager.alert("消息","保存成功！");
                        $(".messager-window").css("z-index",10000);
                        $("#videoAddForm").form("clear");
                        video_videoDesc_editor.setContent("");
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    }
			    }
			});
			//提交表单
			$("#videoAddForm").submit();
		}
	});

	//单击清空按钮
	$("#videoClearButton").click(function () { 
		$("#videoAddForm").form("clear"); 
	});
});
