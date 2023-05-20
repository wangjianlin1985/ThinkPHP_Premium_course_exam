$(function () {
	$("#studentAnswer_paperObj_paperId").combobox({
	    url: backURL + getVisitPath("Paper") + '/listAll',
	    valueField: "paperId",
	    textField: "paperName",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#studentAnswer_paperObj_paperId").combobox("getData"); 
            if (data.length > 0) {
                $("#studentAnswer_paperObj_paperId").combobox("select", data[0].paperId);
            }
        }
	});
	$("#studentAnswer_subjectObj_subjectId").combobox({
	    url: backURL + getVisitPath("Subject") + '/listAll',
	    valueField: "subjectId",
	    textField: "title",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#studentAnswer_subjectObj_subjectId").combobox("getData"); 
            if (data.length > 0) {
                $("#studentAnswer_subjectObj_subjectId").combobox("select", data[0].subjectId);
            }
        }
	});
	$("#studentAnswer_studentOption").validatebox({
		required : true, 
		missingMessage : '请输入学生答案',
	});

	$("#studentAnswer_studentObj_user_name").combobox({
	    url: backURL + getVisitPath("Student") + '/listAll',
	    valueField: "user_name",
	    textField: "name",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#studentAnswer_studentObj_user_name").combobox("getData"); 
            if (data.length > 0) {
                $("#studentAnswer_studentObj_user_name").combobox("select", data[0].user_name);
            }
        }
	});
	$("#studentAnswer_examTime").datetimebox({
	    required : true, 
	    showSeconds: true,
	    editable: false
	});

	//单击添加按钮
	$("#studentAnswerAddButton").click(function () {
		//验证表单 
		if(!$("#studentAnswerAddForm").form("validate")) {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		} else {
			$("#studentAnswerAddForm").form({
			    url: backURL + getVisitPath("StudentAnswer") + "/add",
			    onSubmit: function(){
					if($("#studentAnswerAddForm").form("validate"))  { 
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
                        $("#studentAnswerAddForm").form("clear");
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    }
			    }
			});
			//提交表单
			$("#studentAnswerAddForm").submit();
		}
	});

	//单击清空按钮
	$("#studentAnswerClearButton").click(function () { 
		$("#studentAnswerAddForm").form("clear"); 
	});
});
