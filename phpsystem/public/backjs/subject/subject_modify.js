$(function () {
	$.ajax({
		url :  backURL + getVisitPath("Subject") + "/update",
		type : "get",
		data : {
			subjectId : $("#subject_subjectId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (subject, response, status) {
			$.messager.progress("close");
			if (subject) { 
				$("#subject_subjectId_edit").val(subject.subjectId);
				$("#subject_subjectId_edit").validatebox({
					required : true,
					missingMessage : "请输入题目id",
					editable: false
				});
				$("#subject_title_edit").val(subject.title);
				$("#subject_title_edit").validatebox({
					required : true,
					missingMessage : "请输入题目标题",
				});
				$("#subject_a_option_edit").val(subject.a_option);
				$("#subject_a_option_edit").validatebox({
					required : true,
					missingMessage : "请输入A",
				});
				$("#subject_b_option_edit").val(subject.b_option);
				$("#subject_b_option_edit").validatebox({
					required : true,
					missingMessage : "请输入B",
				});
				$("#subject_c_option_edit").val(subject.c_option);
				$("#subject_c_option_edit").validatebox({
					required : true,
					missingMessage : "请输入C",
				});
				$("#subject_d_option_edit").val(subject.d_option);
				$("#subject_rightOption_edit").val(subject.rightOption);
				$("#subject_rightOption_edit").validatebox({
					required : true,
					missingMessage : "请输入正确答案",
				});
				$("#subject_score_edit").val(subject.score);
				$("#subject_score_edit").validatebox({
					required : true,
					validType : "number",
					missingMessage : "请输入得分",
					invalidMessage : "得分输入不对",
				});
			} else {
				$.messager.alert("获取失败！", "未知错误导致失败，请重试！", "warning");
				$(".messager-window").css("z-index",10000);
			}
		}
	});

	$("#subjectModifyButton").click(function(){ 
		if ($("#subjectEditForm").form("validate")) {
			$("#subjectEditForm").form({
			    url: backURL + getVisitPath("Subject") + "/update",
			    onSubmit: function(){
					if($("#subjectEditForm").form("validate"))  {
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
			$("#subjectEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
