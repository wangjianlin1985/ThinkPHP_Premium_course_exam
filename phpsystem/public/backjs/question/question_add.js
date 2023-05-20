$(function () {
	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	UE.delEditor('question_questionContent');
	var question_questionContent_editor = UE.getEditor('question_questionContent'); //提问内容编辑框
	UE.delEditor('question_replyContent');
	var question_replyContent_editor = UE.getEditor('question_replyContent'); //答疑回复编辑框
	$("#question_questionTitle").validatebox({
		required : true, 
		missingMessage : '请输入提问标题',
	});

	$("#question_userObj_user_name").combobox({
	    url: backURL + getVisitPath("Student") + '/listAll',
	    valueField: "user_name",
	    textField: "name",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#question_userObj_user_name").combobox("getData"); 
            if (data.length > 0) {
                $("#question_userObj_user_name").combobox("select", data[0].user_name);
            }
        }
	});
	$("#question_questionTime").datetimebox({
	    required : true, 
	    showSeconds: true,
	    editable: false
	});

	$("#question_replyTime").datetimebox({
	    required : true, 
	    showSeconds: true,
	    editable: false
	});

	//单击添加按钮
	$("#questionAddButton").click(function () {
		if(question_questionContent_editor.getContent() == "") {
			alert("请输入提问内容");
			return;
		}
		//验证表单 
		if(!$("#questionAddForm").form("validate")) {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		} else {
			$("#questionAddForm").form({
			    url: backURL + getVisitPath("Question") + "/add",
			    onSubmit: function(){
					if($("#questionAddForm").form("validate"))  { 
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
                        $("#questionAddForm").form("clear");
                        question_questionContent_editor.setContent("");
                        question_replyContent_editor.setContent("");
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    }
			    }
			});
			//提交表单
			$("#questionAddForm").submit();
		}
	});

	//单击清空按钮
	$("#questionClearButton").click(function () { 
		$("#questionAddForm").form("clear"); 
	});
});
