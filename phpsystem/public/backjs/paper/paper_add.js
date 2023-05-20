$(function () {
	$("#paper_paperName").validatebox({
		required : true, 
		missingMessage : '请输入试卷名称',
	});

	$("#paper_purpose").validatebox({
		required : true, 
		missingMessage : '请输入测试目标',
	});

	$("#paper_examTime").validatebox({
		required : true,
		validType : "integer",
		missingMessage : '请输入考试时间(分钟)',
		invalidMessage : '考试时间(分钟)输入不对',
	});

	$("#paper_totalScore").validatebox({
		required : true, 
		missingMessage : '请输入试卷满分',
	});

	//单击添加按钮
	$("#paperAddButton").click(function () {
		//验证表单 
		if(!$("#paperAddForm").form("validate")) {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		} else {
			$("#paperAddForm").form({
			    url: backURL + getVisitPath("Paper") + "/add",
			    onSubmit: function(){
					if($("#paperAddForm").form("validate"))  { 
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
                        $("#paperAddForm").form("clear");
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    }
			    }
			});
			//提交表单
			$("#paperAddForm").submit();
		}
	});

	//单击清空按钮
	$("#paperClearButton").click(function () { 
		$("#paperAddForm").form("clear"); 
	});
});
