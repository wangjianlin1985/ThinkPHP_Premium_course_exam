function savePaw() {
	if (!$("#saveid").prop("checked")) {
		$.cookie('manager', '', {
			expires : -1
		});
		$("#manager").val('');
	}
}


function saveCookie() {
	if ($("#saveid").prop("checked")) {
		$.cookie('manager', $("#manager").val(), {
			expires : 7
		});
	}
}

$(function () {
	//登录界面
	$('#login').dialog({
		title : '登录后台',
		width : 300,
		height : 285,
		modal : true,
		iconCls : 'icon-login',
		buttons : '#btn',
	});
	
	//管理员帐号验证
	$('#manager').validatebox({
		required : true,
		missingMessage : '请输入管理员帐号',
		invalidMessage : '管理员帐号不得为空',
	});
	
	//管理员密码验证
	$('#password').validatebox({
		required : true,
		validType : 'length[1,30]',
		missingMessage : '请输入管理员密码',
		invalidMessage : '管理员密码长度1-30',
	});
	
	//加载时判断验证
	if (!$('#manager').validatebox('isValid')) {
		$('#manager').focus();
	} else if (!$('#password').validatebox('isValid')) {
		$('#password').focus();
	}
	
	
	//单击登录
	$('#btn a').click(function () {
		if (!$('#manager').validatebox('isValid')) {
			$('#manager').focus();
		} else if (!$('#password').validatebox('isValid')) {
			$('#password').focus();
		} else {
			$.ajax({
				url : authUrl,
				type : 'post',
				data : {
					"username" : $('#manager').val(),
					"password" : $('#password').val(),
					"identify": $("#identify").val(),
					"code": $("#checkCode").val()
				},
				dataType: "json",
				beforeSend : function () {
					$.messager.progress({
						text : '正在登录中...',
					});
				},
				success : function (data, response, status) {
					$.messager.progress('close');
					if (data.success) {
						saveCookie();
						if($("#identify").val() == "admin")
							location.href = mainUrl;
						else
							location .href = teacherMainUrl;
					} else {
						$.messager.alert('登录失败！', data.message, 'warning', function () {
							$('#password').select();
						});
					}
				}
			});
		}
	});
	
});







