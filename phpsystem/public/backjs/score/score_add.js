$(function () {
	$("#score_studentObj_user_name").combobox({
	    url: backURL + getVisitPath("Student") + '/listAll',
	    valueField: "user_name",
	    textField: "name",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#score_studentObj_user_name").combobox("getData"); 
            if (data.length > 0) {
                $("#score_studentObj_user_name").combobox("select", data[0].user_name);
            }
        }
	});
	$("#score_paperObj_paperId").combobox({
	    url: backURL + getVisitPath("Paper") + '/listAll',
	    valueField: "paperId",
	    textField: "paperName",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#score_paperObj_paperId").combobox("getData"); 
            if (data.length > 0) {
                $("#score_paperObj_paperId").combobox("select", data[0].paperId);
            }
        }
	});
	$("#score_chengji").validatebox({
		required : true,
		validType : "number",
		missingMessage : '请输入考试成绩',
		invalidMessage : '考试成绩输入不对',
	});

	$("#score_examTime").datetimebox({
	    required : true, 
	    showSeconds: true,
	    editable: false
	});

	//单击添加按钮
	$("#scoreAddButton").click(function () {
		//验证表单 
		if(!$("#scoreAddForm").form("validate")) {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		} else {
			$("#scoreAddForm").form({
			    url: backURL + getVisitPath("Score") + "/add",
			    onSubmit: function(){
					if($("#scoreAddForm").form("validate"))  { 
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
                        $("#scoreAddForm").form("clear");
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    }
			    }
			});
			//提交表单
			$("#scoreAddForm").submit();
		}
	});

	//单击清空按钮
	$("#scoreClearButton").click(function () { 
		$("#scoreAddForm").form("clear"); 
	});
});
