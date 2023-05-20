$(function () {
	$.ajax({
		url :  backURL + getVisitPath("Score") + "/update",
		type : "get",
		data : {
			scoreId : $("#score_scoreId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (score, response, status) {
			$.messager.progress("close");
			if (score) { 
				$("#score_scoreId_edit").val(score.scoreId);
				$("#score_scoreId_edit").validatebox({
					required : true,
					missingMessage : "请输入成绩id",
					editable: false
				});
				$("#score_studentObj_user_name_edit").combobox({
					url: backURL + getVisitPath("Student") + "/listAll",
					valueField:"user_name",
					textField:"name",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#score_studentObj_user_name_edit").combobox("select", score.studentObj);
						//var data = $("#score_studentObj_user_name_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#score_studentObj_user_name_edit").combobox("select", data[0].user_name);
						//}
					}
				});
				$("#score_paperObj_paperId_edit").combobox({
					url: backURL + getVisitPath("Paper") + "/listAll",
					valueField:"paperId",
					textField:"paperName",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#score_paperObj_paperId_edit").combobox("select", score.paperObj);
						//var data = $("#score_paperObj_paperId_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#score_paperObj_paperId_edit").combobox("select", data[0].paperId);
						//}
					}
				});
				$("#score_chengji_edit").val(score.chengji);
				$("#score_chengji_edit").validatebox({
					required : true,
					validType : "number",
					missingMessage : "请输入考试成绩",
					invalidMessage : "考试成绩输入不对",
				});
				$("#score_examTime_edit").datetimebox({
					value: score.examTime,
					required: true,
					showSeconds: true,
				});
			} else {
				$.messager.alert("获取失败！", "未知错误导致失败，请重试！", "warning");
				$(".messager-window").css("z-index",10000);
			}
		}
	});

	$("#scoreModifyButton").click(function(){ 
		if ($("#scoreEditForm").form("validate")) {
			$("#scoreEditForm").form({
			    url: backURL + getVisitPath("Score") + "/update",
			    onSubmit: function(){
					if($("#scoreEditForm").form("validate"))  {
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
			$("#scoreEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
