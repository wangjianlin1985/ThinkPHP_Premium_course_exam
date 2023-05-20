$(function () {
	$.ajax({
		url :  backURL + getVisitPath("PaperSubject") + "/update",
		type : "get",
		data : {
			psId : $("#paperSubject_psId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (paperSubject, response, status) {
			$.messager.progress("close");
			if (paperSubject) { 
				$("#paperSubject_psId_edit").val(paperSubject.psId);
				$("#paperSubject_psId_edit").validatebox({
					required : true,
					missingMessage : "请输入试卷题目id",
					editable: false
				});
				$("#paperSubject_paperObj_paperId_edit").combobox({
					url: backURL + getVisitPath("Paper") + "/listAll",
					valueField:"paperId",
					textField:"paperName",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#paperSubject_paperObj_paperId_edit").combobox("select", paperSubject.paperObj);
						//var data = $("#paperSubject_paperObj_paperId_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#paperSubject_paperObj_paperId_edit").combobox("select", data[0].paperId);
						//}
					}
				});
				$("#paperSubject_subjectObj_subjectId_edit").combobox({
					url: backURL + getVisitPath("Subject") + "/listAll",
					valueField:"subjectId",
					textField:"title",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#paperSubject_subjectObj_subjectId_edit").combobox("select", paperSubject.subjectObj);
						//var data = $("#paperSubject_subjectObj_subjectId_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#paperSubject_subjectObj_subjectId_edit").combobox("select", data[0].subjectId);
						//}
					}
				});
				$("#paperSubject_addTime_edit").datetimebox({
					value: paperSubject.addTime,
					required: true,
					showSeconds: true,
				});
			} else {
				$.messager.alert("获取失败！", "未知错误导致失败，请重试！", "warning");
				$(".messager-window").css("z-index",10000);
			}
		}
	});

	$("#paperSubjectModifyButton").click(function(){ 
		if ($("#paperSubjectEditForm").form("validate")) {
			$("#paperSubjectEditForm").form({
			    url: backURL + getVisitPath("PaperSubject") + "/update",
			    onSubmit: function(){
					if($("#paperSubjectEditForm").form("validate"))  {
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
			$("#paperSubjectEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
