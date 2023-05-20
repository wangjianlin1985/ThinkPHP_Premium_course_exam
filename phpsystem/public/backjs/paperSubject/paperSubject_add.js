$(function () {
	$("#paperSubject_paperObj_paperId").combobox({
	    url: backURL + getVisitPath("Paper") + '/listAll',
	    valueField: "paperId",
	    textField: "paperName",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#paperSubject_paperObj_paperId").combobox("getData"); 
            if (data.length > 0) {
                $("#paperSubject_paperObj_paperId").combobox("select", data[0].paperId);
            }
        }
	});
	$("#paperSubject_subjectObj_subjectId").combobox({
	    url: backURL + getVisitPath("Subject") + '/listAll',
	    valueField: "subjectId",
	    textField: "title",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#paperSubject_subjectObj_subjectId").combobox("getData"); 
            if (data.length > 0) {
                $("#paperSubject_subjectObj_subjectId").combobox("select", data[0].subjectId);
            }
        }
	});
	$("#paperSubject_addTime").datetimebox({
	    required : true, 
	    showSeconds: true,
	    editable: false
	});

	//单击添加按钮
	$("#paperSubjectAddButton").click(function () {
		//验证表单 
		if(!$("#paperSubjectAddForm").form("validate")) {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		} else {
			$("#paperSubjectAddForm").form({
			    url: backURL + getVisitPath("PaperSubject") + "/add",
			    onSubmit: function(){
					if($("#paperSubjectAddForm").form("validate"))  { 
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
                        $("#paperSubjectAddForm").form("clear");
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    }
			    }
			});
			//提交表单
			$("#paperSubjectAddForm").submit();
		}
	});

	//单击清空按钮
	$("#paperSubjectClearButton").click(function () { 
		$("#paperSubjectAddForm").form("clear"); 
	});
});
