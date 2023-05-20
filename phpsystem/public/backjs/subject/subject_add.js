$(function () {
	$("#subject_title").validatebox({
		required : true, 
		missingMessage : '请输入题目标题',
	});

	$("#subject_a_option").validatebox({
		required : true, 
		missingMessage : '请输入A',
	});

	$("#subject_b_option").validatebox({
		required : true, 
		missingMessage : '请输入B',
	});

	$("#subject_c_option").validatebox({
		required : true, 
		missingMessage : '请输入C',
	});

	$("#subject_rightOption").validatebox({
		required : true, 
		missingMessage : '请输入正确答案',
	});

	$("#subject_score").validatebox({
		required : true,
		validType : "number",
		missingMessage : '请输入得分',
		invalidMessage : '得分输入不对',
	});

	//单击添加按钮
	$("#subjectAddButton").click(function () {
		//验证表单 
		if(!$("#subjectAddForm").form("validate")) {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		} else {
			$("#subjectAddForm").form({
			    url: backURL + getVisitPath("Subject") + "/add",
			    onSubmit: function(){
					if($("#subjectAddForm").form("validate"))  { 
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
                        $("#subjectAddForm").form("clear");
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    }
			    }
			});
			//提交表单
			$("#subjectAddForm").submit();
		}
	});

	//单击清空按钮
	$("#subjectClearButton").click(function () { 
		$("#subjectAddForm").form("clear"); 
	});
});
