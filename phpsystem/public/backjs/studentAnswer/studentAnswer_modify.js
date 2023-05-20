$(function () {
	$.ajax({
		url :  backURL + getVisitPath("StudentAnswer") + "/update",
		type : "get",
		data : {
			answerId : $("#studentAnswer_answerId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (studentAnswer, response, status) {
			$.messager.progress("close");
			if (studentAnswer) { 
				$("#studentAnswer_answerId_edit").val(studentAnswer.answerId);
				$("#studentAnswer_answerId_edit").validatebox({
					required : true,
					missingMessage : "请输入学生答案id",
					editable: false
				});
				$("#studentAnswer_paperObj_paperId_edit").combobox({
					url: backURL + getVisitPath("Paper") + "/listAll",
					valueField:"paperId",
					textField:"paperName",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#studentAnswer_paperObj_paperId_edit").combobox("select", studentAnswer.paperObj);
						//var data = $("#studentAnswer_paperObj_paperId_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#studentAnswer_paperObj_paperId_edit").combobox("select", data[0].paperId);
						//}
					}
				});
				$("#studentAnswer_subjectObj_subjectId_edit").combobox({
					url: backURL + getVisitPath("Subject") + "/listAll",
					valueField:"subjectId",
					textField:"title",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#studentAnswer_subjectObj_subjectId_edit").combobox("select", studentAnswer.subjectObj);
						//var data = $("#studentAnswer_subjectObj_subjectId_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#studentAnswer_subjectObj_subjectId_edit").combobox("select", data[0].subjectId);
						//}
					}
				});
				$("#studentAnswer_studentOption_edit").val(studentAnswer.studentOption);
				$("#studentAnswer_studentOption_edit").validatebox({
					required : true,
					missingMessage : "请输入学生答案",
				});
				$("#studentAnswer_studentObj_user_name_edit").combobox({
					url: backURL + getVisitPath("Student") + "/listAll",
					valueField:"user_name",
					textField:"name",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#studentAnswer_studentObj_user_name_edit").combobox("select", studentAnswer.studentObj);
						//var data = $("#studentAnswer_studentObj_user_name_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#studentAnswer_studentObj_user_name_edit").combobox("select", data[0].user_name);
						//}
					}
				});
				$("#studentAnswer_examTime_edit").datetimebox({
					value: studentAnswer.examTime,
					required: true,
					showSeconds: true,
				});
			} else {
				$.messager.alert("获取失败！", "未知错误导致失败，请重试！", "warning");
				$(".messager-window").css("z-index",10000);
			}
		}
	});

	$("#studentAnswerModifyButton").click(function(){ 
		if ($("#studentAnswerEditForm").form("validate")) {
			$("#studentAnswerEditForm").form({
			    url: backURL + getVisitPath("StudentAnswer") + "/update",
			    onSubmit: function(){
					if($("#studentAnswerEditForm").form("validate"))  {
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
			$("#studentAnswerEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
