$(function () {
	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	UE.delEditor('kejian_kejianDesc_edit');
	var kejian_kejianDesc_edit = UE.getEditor('kejian_kejianDesc_edit'); //课件描述编辑器
	kejian_kejianDesc_edit.addListener("ready", function () {
		 // editor准备好之后才可以使用 
		 ajaxModifyQuery();
	}); 
  function ajaxModifyQuery() {	
	$.ajax({
		url :  backURL + getVisitPath("Kejian") + "/update",
		type : "get",
		data : {
			kejianId : $("#kejian_kejianId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (kejian, response, status) {
			$.messager.progress("close");
			if (kejian) { 
				$("#kejian_kejianId_edit").val(kejian.kejianId);
				$("#kejian_kejianId_edit").validatebox({
					required : true,
					missingMessage : "请输入课件id",
					editable: false
				});
				$("#kejian_title_edit").val(kejian.title);
				$("#kejian_title_edit").validatebox({
					required : true,
					missingMessage : "请输入课件标题",
				});
				$("#kejian_kejianFile").val(kejian.kejianFile);
				$("#kejian_kejianFileA").html(kejian.kejianFile == ""?"暂无文件":kejian.kejianFile);
				$("#kejian_kejianFileA").attr("href", publicURL + kejian.kejianFile);
				kejian_kejianDesc_edit.setContent(kejian.kejianDesc);
				$("#kejian_teacherObj_teacherNo_edit").combobox({
					url: backURL + getVisitPath("Teacher") + "/listAll",
					valueField:"teacherNo",
					textField:"teacherName",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#kejian_teacherObj_teacherNo_edit").combobox("select", kejian.teacherObj);
						//var data = $("#kejian_teacherObj_teacherNo_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#kejian_teacherObj_teacherNo_edit").combobox("select", data[0].teacherNo);
						//}
					}
				});
				$("#kejian_addTime_edit").datetimebox({
					value: kejian.addTime,
					required: true,
					showSeconds: true,
				});
			} else {
				$.messager.alert("获取失败！", "未知错误导致失败，请重试！", "warning");
				$(".messager-window").css("z-index",10000);
			}
		}
	});

  }

	$("#kejianModifyButton").click(function(){ 
		if ($("#kejianEditForm").form("validate")) {
			$("#kejianEditForm").form({
			    url: backURL + getVisitPath("Kejian") + "/update",
			    onSubmit: function(){
					if($("#kejianEditForm").form("validate"))  {
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
			$("#kejianEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
