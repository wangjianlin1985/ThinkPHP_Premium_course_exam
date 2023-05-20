$(function () {
	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	UE.delEditor('homework_taskContent');
	var homework_taskContent_editor = UE.getEditor('homework_taskContent'); //作业要求编辑框
	$("#homework_taskTitle").validatebox({
		required : true, 
		missingMessage : '请输入作业任务',
	});

	$("#homework_teacherObj_teacherNo").combobox({
	    url: backURL + getVisitPath("Teacher") + '/listAll',
	    valueField: "teacherNo",
	    textField: "teacherName",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#homework_teacherObj_teacherNo").combobox("getData"); 
            if (data.length > 0) {
                $("#homework_teacherObj_teacherNo").combobox("select", data[0].teacherNo);
            }
        }
	});
	$("#homework_homeworkDate").datebox({
	    required : true, 
	    showSeconds: true,
	    editable: false
	});

	//单击添加按钮
	$("#homeworkAddButton").click(function () {
		if(homework_taskContent_editor.getContent() == "") {
			alert("请输入作业要求");
			return;
		}
		//验证表单 
		if(!$("#homeworkAddForm").form("validate")) {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		} else {
			$("#homeworkAddForm").form({
			    url: backURL + getVisitPath("Homework") + "/add",
			    onSubmit: function(){
					if($("#homeworkAddForm").form("validate"))  { 
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
                        $("#homeworkAddForm").form("clear");
                        homework_taskContent_editor.setContent("");
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    }
			    }
			});
			//提交表单
			$("#homeworkAddForm").submit();
		}
	});

	//单击清空按钮
	$("#homeworkClearButton").click(function () { 
		$("#homeworkAddForm").form("clear"); 
	});
});
