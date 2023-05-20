$(function () {
	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	UE.delEditor('homework_taskContent_edit');
	var homework_taskContent_edit = UE.getEditor('homework_taskContent_edit'); //作业要求编辑器
	homework_taskContent_edit.addListener("ready", function () {
		 // editor准备好之后才可以使用 
		 ajaxModifyQuery();
	}); 
  function ajaxModifyQuery() {	
	$.ajax({
		url :  backURL + getVisitPath("Homework") + "/update",
		type : "get",
		data : {
			homeworkId : $("#homework_homeworkId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (homework, response, status) {
			$.messager.progress("close");
			if (homework) { 
				$("#homework_homeworkId_edit").val(homework.homeworkId);
				$("#homework_homeworkId_edit").validatebox({
					required : true,
					missingMessage : "请输入作业id",
					editable: false
				});
				$("#homework_taskTitle_edit").val(homework.taskTitle);
				$("#homework_taskTitle_edit").validatebox({
					required : true,
					missingMessage : "请输入作业任务",
				});
				homework_taskContent_edit.setContent(homework.taskContent);
				$("#homework_teacherObj_teacherNo_edit").combobox({
					url: backURL + getVisitPath("Teacher") + "/listAll",
					valueField:"teacherNo",
					textField:"teacherName",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#homework_teacherObj_teacherNo_edit").combobox("select", homework.teacherObj);
						//var data = $("#homework_teacherObj_teacherNo_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#homework_teacherObj_teacherNo_edit").combobox("select", data[0].teacherNo);
						//}
					}
				});
				$("#homework_homeworkDate_edit").datebox({
					value: homework.homeworkDate,
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

	$("#homeworkModifyButton").click(function(){ 
		if ($("#homeworkEditForm").form("validate")) {
			$("#homeworkEditForm").form({
			    url: backURL + getVisitPath("Homework") + "/update",
			    onSubmit: function(){
					if($("#homeworkEditForm").form("validate"))  {
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
			$("#homeworkEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
