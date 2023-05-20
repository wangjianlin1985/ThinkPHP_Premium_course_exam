$(function () {
	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	UE.delEditor('kejian_kejianDesc');
	var kejian_kejianDesc_editor = UE.getEditor('kejian_kejianDesc'); //课件描述编辑框
	$("#kejian_title").validatebox({
		required : true, 
		missingMessage : '请输入课件标题',
	});

	$("#kejian_teacherObj_teacherNo").combobox({
	    url: backURL + getVisitPath("Teacher") + '/listAll',
	    valueField: "teacherNo",
	    textField: "teacherName",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#kejian_teacherObj_teacherNo").combobox("getData"); 
            if (data.length > 0) {
                $("#kejian_teacherObj_teacherNo").combobox("select", data[0].teacherNo);
            }
        }
	});
	$("#kejian_addTime").datetimebox({
	    required : true, 
	    showSeconds: true,
	    editable: false
	});

	//单击添加按钮
	$("#kejianAddButton").click(function () {
		if(kejian_kejianDesc_editor.getContent() == "") {
			alert("请输入课件描述");
			return;
		}
		//验证表单 
		if(!$("#kejianAddForm").form("validate")) {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		} else {
			$("#kejianAddForm").form({
			    url: backURL + getVisitPath("Kejian") + "/add",
			    onSubmit: function(){
					if($("#kejianAddForm").form("validate"))  { 
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
                        $("#kejianAddForm").form("clear");
                        kejian_kejianDesc_editor.setContent("");
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    }
			    }
			});
			//提交表单
			$("#kejianAddForm").submit();
		}
	});

	//单击清空按钮
	$("#kejianClearButton").click(function () { 
		$("#kejianAddForm").form("clear"); 
	});
});
