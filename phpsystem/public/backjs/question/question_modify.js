$(function () {
	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	UE.delEditor('question_questionContent_edit');
	var question_questionContent_edit = UE.getEditor('question_questionContent_edit'); //提问内容编辑器
	question_questionContent_edit.addListener("ready", function () {
		 // editor准备好之后才可以使用 
		 ajaxModifyQuery();
	}); 
	UE.delEditor('question_replyContent_edit');
	var question_replyContent_edit = UE.getEditor('question_replyContent_edit'); //答疑回复编辑器
	question_replyContent_edit.addListener("ready", function () {
		 // editor准备好之后才可以使用 
		 ajaxModifyQuery();
	}); 
  function ajaxModifyQuery() {	
	$.ajax({
		url :  backURL + getVisitPath("Question") + "/update",
		type : "get",
		data : {
			questionId : $("#question_questionId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (question, response, status) {
			$.messager.progress("close");
			if (question) { 
				$("#question_questionId_edit").val(question.questionId);
				$("#question_questionId_edit").validatebox({
					required : true,
					missingMessage : "请输入问题id",
					editable: false
				});
				$("#question_questionTitle_edit").val(question.questionTitle);
				$("#question_questionTitle_edit").validatebox({
					required : true,
					missingMessage : "请输入提问标题",
				});
				question_questionContent_edit.setContent(question.questionContent);
				$("#question_userObj_user_name_edit").combobox({
					url: backURL + getVisitPath("Student") + "/listAll",
					valueField:"user_name",
					textField:"name",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#question_userObj_user_name_edit").combobox("select", question.userObj);
						//var data = $("#question_userObj_user_name_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#question_userObj_user_name_edit").combobox("select", data[0].user_name);
						//}
					}
				});
				$("#question_questionTime_edit").datetimebox({
					value: question.questionTime,
					required: true,
					showSeconds: true,
				});
				question_replyContent_edit.setContent(question.replyContent);
				$("#question_replyTime_edit").datetimebox({
					value: question.replyTime,
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

	$("#questionModifyButton").click(function(){ 
		if ($("#questionEditForm").form("validate")) {
			$("#questionEditForm").form({
			    url: backURL + getVisitPath("Question") + "/update",
			    onSubmit: function(){
					if($("#questionEditForm").form("validate"))  {
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
			$("#questionEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
