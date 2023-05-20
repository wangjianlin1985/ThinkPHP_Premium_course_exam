$(function () {
	$.ajax({
		url :  backURL + getVisitPath("Paper") + "/update",
		type : "get",
		data : {
			paperId : $("#paper_paperId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (paper, response, status) {
			$.messager.progress("close");
			if (paper) { 
				$("#paper_paperId_edit").val(paper.paperId);
				$("#paper_paperId_edit").validatebox({
					required : true,
					missingMessage : "请输入试卷id",
					editable: false
				});
				$("#paper_paperName_edit").val(paper.paperName);
				$("#paper_paperName_edit").validatebox({
					required : true,
					missingMessage : "请输入试卷名称",
				});
				$("#paper_purpose_edit").val(paper.purpose);
				$("#paper_purpose_edit").validatebox({
					required : true,
					missingMessage : "请输入测试目标",
				});
				$("#paper_examTime_edit").val(paper.examTime);
				$("#paper_examTime_edit").validatebox({
					required : true,
					validType : "integer",
					missingMessage : "请输入考试时间(分钟)",
					invalidMessage : "考试时间(分钟)输入不对",
				});
				$("#paper_totalScore_edit").val(paper.totalScore);
				$("#paper_totalScore_edit").validatebox({
					required : true,
					missingMessage : "请输入试卷满分",
				});
				$("#paper_paperMemo_edit").val(paper.paperMemo);
			} else {
				$.messager.alert("获取失败！", "未知错误导致失败，请重试！", "warning");
				$(".messager-window").css("z-index",10000);
			}
		}
	});

	$("#paperModifyButton").click(function(){ 
		if ($("#paperEditForm").form("validate")) {
			$("#paperEditForm").form({
			    url: backURL + getVisitPath("Paper") + "/update",
			    onSubmit: function(){
					if($("#paperEditForm").form("validate"))  {
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
			$("#paperEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
