<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:88:"C:\xampp\htdocs\phpsystem\public/../application/front\view\student\student_frontAdd.html";i:1550633159;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\header.html";i:1550633034;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\footer.html";i:1538061378;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
<title>学生添加</title>
<link href="__PUBLIC__/plugins/bootstrap.css" rel="stylesheet">
<link href="__PUBLIC__/plugins/bootstrap-dashen.css" rel="stylesheet">
<link href="__PUBLIC__/plugins/font-awesome.css" rel="stylesheet">
<link href="__PUBLIC__/plugins/animate.css" rel="stylesheet">
<link href="__PUBLIC__/plugins/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
</head>
<body style="margin-top:70px;">
<div class="container">
<!--导航开始-->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!--小屏幕导航按钮和logo-->
        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="__PUBLIC__/index.php" class="navbar-brand">php设计网</a>
        </div>
        <!--小屏幕导航按钮和logo-->
        <!--导航-->
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">
                <!--
               <li><a href="__PUBLIC__/index.php">首页</a></li>
               <li><a href="<?php echo url('Student/frontlist'); ?>">学生</a></li>
               <li><a href="<?php echo url('ClassInfo/frontlist'); ?>">班级</a></li> -->
                <li><a href="<?php echo url('Teacher/frontlist'); ?>">师资力量</a></li>
                <li><a href="<?php echo url('Kejian/frontlist'); ?>">课件下载</a></li>
                <li><a href="<?php echo url('Video/frontlist'); ?>">学习视频</a></li>
                <li><a href="<?php echo url('Paper/frontlist'); ?>">在线测试</a></li>
                <!--
                <li><a href="<?php echo url('Subject/frontlist'); ?>">题库题目</a></li>
                <li><a href="<?php echo url('PaperSubject/frontlist'); ?>">试卷题目</a></li>
                <li><a href="<?php echo url('StudentAnswer/frontlist'); ?>">学生答案</a></li> -->
                <li><a href="<?php echo url('Score/frontlist'); ?>">学生成绩</a></li>
                <li><a href="<?php echo url('Question/frontlist'); ?>">问题答疑</a></li>
                <li><a href="<?php echo url('Homework/frontlist'); ?>">家庭作业</a></li>
                <li><a href="<?php echo url('Notice/frontlist'); ?>">新闻公告</a></li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if(\think\Session::get('user_name') == null): ?>
                <li><a href="<?php echo url('Student/frontAdd'); ?>"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;注册</a></li>
                <li><a href="#" onclick="login();"><i class="fa fa-user"></i>&nbsp;&nbsp;登录</a></li>
                    <?php else: ?>
                <li class="dropdown">
                    <a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo \think\Session::get('user_name'); ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li><a href="__PUBLIC__/index.php"><span class="glyphicon glyphicon-screenshot"></span>&nbsp;&nbsp;首页</a></li>
                        <li><a href="<?php echo url('BookType/frontlist'); ?>"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;发布信息</a></li>
                        <li><a href="<?php echo url('Book/frontlist'); ?>"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;我发布的信息</a></li>
                        <li><a href="<?php echo url('Book/frontlist'); ?>"><span class="glyphicon glyphicon-credit-card"></span>&nbsp;&nbsp;修改个人资料</a></li>
                        <li><a href="<?php echo url('Book/frontlist'); ?>"><span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;我的收藏</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo url('Index/logout'); ?>"><span class="glyphicon glyphicon-off"></span>&nbsp;&nbsp;退出</a></li>
                <?php endif; ?>
            </ul>

        </div>
        <!--导航-->
    </div>
</nav>
<!--导航结束-->


<div id="loginDialog" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-key"></i>&nbsp;系统登录</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="loginForm" id="loginForm" enctype="multipart/form-data" method="post"  class="mar_t15">

                    <div class="form-group">
                        <label for="userName" class="col-md-3 text-right">用户名:</label>
                        <div class="col-md-9">
                            <input type="text" id="userName" name="userName" class="form-control" placeholder="请输入用户名">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-3 text-right">密码:</label>
                        <div class="col-md-9">
                            <input type="password" id="password" name="password" class="form-control" placeholder="登录密码">
                        </div>
                    </div>

                </form>
                <style>#bookTypeAddForm .form-group {margin-bottom:10px;}  </style>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="ajaxLogin();">登录</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





<div id="registerDialog" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-sign-in"></i>&nbsp;用户注册</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="registerForm" id="registerForm" enctype="multipart/form-data" method="post"  class="mar_t15">



                </form>
                <style>#bookTypeAddForm .form-group {margin-bottom:10px;}  </style>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="ajaxRegister();">注册</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->






<script>

    function register() {
        $("#registerDialog input").val("");
        $("#registerDialog textarea").val("");
        $('#registerDialog').modal('show');
    }
    function ajaxRegister() {
        $("#registerForm").data('bootstrapValidator').validate();
        if(!$("#registerForm").data('bootstrapValidator').isValid()){
            return;
        }

        jQuery.ajax({
            type : "post" ,
            url : basePath + "UserInfo/add",
            dataType : "json" ,
            data: new FormData($("#registerForm")[0]),
            success : function(obj) {
                if(obj.success){
                    alert("注册成功！");
                    $("#registerForm").find("input").val("");
                    $("#registerForm").find("textarea").val("");
                }else{
                    alert(obj.message);
                }
            },
            processData: false,
            contentType: false,
        });
    }


    function login() {
        $("#loginDialog input").val("");
        $('#loginDialog').modal('show');
    }
    function ajaxLogin() {
        $.ajax({
            url : "<?php echo url('Index/frontLogin'); ?>",
            type : 'post',
            dataType: "json",
            data : {
                "userName" : $('#userName').val(),
                "password" : $('#password').val(),
            },
            success : function (obj, response, status) {
                if (obj.success) {
                    location.href = "__PUBLIC__/index.php";
                } else {
                    alert(obj.message);
                }
            }
        });
    }


</script>

	<div class="col-md-12 wow fadeInLeft">
		<ul class="breadcrumb">
  			<li><a href="__PUBLIC__/index.php">首页</a></li>
  			<li><a href="__PUBLIC__/Student/frontlist">学生管理</a></li>
  			<li class="active">添加学生</li>
		</ul>
		<div class="row">
			<div class="col-md-10">
		      	<form class="form-horizontal" name="studentAddForm" id="studentAddForm" enctype="multipart/form-data" method="post"  class="mar_t15">
				  <div class="form-group">
					 <label for="student_user_name" class="col-md-2 text-right">学号:</label>
					 <div class="col-md-8"> 
					 	<input type="text" id="student_user_name" name="student_user_name" class="form-control" placeholder="请输入学号">
					 </div>
				  </div> 
				  <div class="form-group">
				  	 <label for="student_password" class="col-md-2 text-right">登录密码:</label>
				  	 <div class="col-md-8">
					    <input type="text" id="student_password" name="student_password" class="form-control" placeholder="请输入登录密码">
					 </div>
				  </div>
				  <div class="form-group">
				  	 <label for="student_classObj_classNo" class="col-md-2 text-right">所在班级:</label>
				  	 <div class="col-md-8">
					    <select id="student_classObj_classNo" name="student.classObj.classNo" class="form-control">
					    </select>
				  	 </div>
				  </div>
				  <div class="form-group">
				  	 <label for="student_name" class="col-md-2 text-right">姓名:</label>
				  	 <div class="col-md-8">
					    <input type="text" id="student_name" name="student_name" class="form-control" placeholder="请输入姓名">
					 </div>
				  </div>
				  <div class="form-group">
				  	 <label for="student_gender" class="col-md-2 text-right">性别:</label>
				  	 <div class="col-md-8">
					    <input type="text" id="student_gender" name="student_gender" class="form-control" placeholder="请输入性别">
					 </div>
				  </div>
				  <div class="form-group">
				  	 <label for="student_birthDateDiv" class="col-md-2 text-right">出生日期:</label>
				  	 <div class="col-md-8">
		                <div id="student_birthDateDiv" class="input-group date student_birthDate col-md-12" data-link-field="student_birthDate" data-link-format="yyyy-mm-dd">
		                    <input class="form-control" id="student_birthDate" name="student_birthDate" size="16" type="text" value="" placeholder="请选择出生日期" readonly>
		                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
		                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		                </div>
				  	 </div>
				  </div>
				  <div class="form-group">
				  	 <label for="student_userPhoto" class="col-md-2 text-right">学生照片:</label>
				  	 <div class="col-md-8">
					    <img  class="img-responsive" id="student_userPhotoImg" border="0px"/><br/>
					    <input type="hidden" id="student_userPhoto" name="student_userPhoto"/>
					    <input id="userPhotoFile" name="userPhotoFile" type="file" size="50" />
				  	 </div>
				  </div>
				  <div class="form-group">
				  	 <label for="student_telephone" class="col-md-2 text-right">联系电话:</label>
				  	 <div class="col-md-8">
					    <input type="text" id="student_telephone" name="student_telephone" class="form-control" placeholder="请输入联系电话">
					 </div>
				  </div>
				  <div class="form-group">
				  	 <label for="student_email" class="col-md-2 text-right">邮箱:</label>
				  	 <div class="col-md-8">
					    <input type="text" id="student_email" name="student_email" class="form-control" placeholder="请输入邮箱">
					 </div>
				  </div>
				  <div class="form-group">
				  	 <label for="student_address" class="col-md-2 text-right">家庭地址:</label>
				  	 <div class="col-md-8">
					    <input type="text" id="student_address" name="student_address" class="form-control" placeholder="请输入家庭地址">
					 </div>
				  </div>
				  <div class="form-group" style="display:none;">
				  	 <label for="student_regTimeDiv" class="col-md-2 text-right">注册时间:</label>
				  	 <div class="col-md-8">
		                <div id="student_regTimeDiv" class="input-group date student_regTime col-md-12" data-link-field="student_regTime">
		                    <input class="form-control" id="student_regTime" name="student_regTime" size="16" type="text" value="" placeholder="请选择注册时间" readonly>
		                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
		                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		                </div>
				  	 </div>
				  </div>
		          <div class="form-group">
		             <span class="col-md-2"></span>
		             <span onclick="ajaxStudentAdd();" class="btn btn-primary bottom5 top5">学生注册</span>
		          </div> 
		          <style>#studentAddForm .form-group {margin:5px;}  </style>  
				</form> 
			</div>
			<div class="col-md-2"></div> 
	    </div>
	</div>
</div>
<!--footer-->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="http://www.baidu.com" target=_blank>© 大神开发网 from 2020</a> |
                <a href="http://www.baidu.com">本站招聘</a> |
                <a href="http://www.baidu.com">联系站长</a> |
                <a href="http://www.baidu.com">意见与建议</a> |
                <a href="http://www.baidu.com" target=_blank>蜀ICP备0343346号</a> |
                <a href="__PUBLIC__/back/login">后台登录</a>
            </div>
        </div>
    </div>
</footer>
<!--footer-->





<script src="__PUBLIC__/plugins/jquery.min.js"></script>
<script src="__PUBLIC__/plugins/bootstrap.js"></script>
<script src="__PUBLIC__/plugins/wow.min.js"></script>
<script src="__PUBLIC__/plugins/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/plugins/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="__PUBLIC__/plugins/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script>
	//提交添加学生信息
	function ajaxStudentAdd() { 
		//提交之前先验证表单
		$("#studentAddForm").data('bootstrapValidator').validate();
		if(!$("#studentAddForm").data('bootstrapValidator').isValid()){
			return;
		}
		jQuery.ajax({
			type : "post",
			url : "<?php echo url('Student/frontAdd'); ?>",
			dataType : "json" , 
			data: new FormData($("#studentAddForm")[0]),
			success : function(obj) {
				if(obj.success){ 
					alert("保存成功！");
					$("#studentAddForm").find("input").val("");
					$("#studentAddForm").find("textarea").val("");
				} else {
					alert(obj.message);
				}
			},
			processData: false, 
			contentType: false, 
		});
	} 
$(function(){
	/*小屏幕导航点击关闭菜单*/
    $('.navbar-collapse a').click(function(){
        $('.navbar-collapse').collapse('hide');
    });
    new WOW().init();
	//验证学生添加表单字段
	$('#studentAddForm').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			"student_user_name": {
				validators: {
					notEmpty: {
						message: "学号不能为空",
					}
				}
			},
			"student_password": {
				validators: {
					notEmpty: {
						message: "登录密码不能为空",
					}
				}
			},
			"student_name": {
				validators: {
					notEmpty: {
						message: "姓名不能为空",
					}
				}
			},
			"student_gender": {
				validators: {
					notEmpty: {
						message: "性别不能为空",
					}
				}
			},
			"student_birthDate": {
				validators: {
					notEmpty: {
						message: "出生日期不能为空",
					}
				}
			},
			"student_telephone": {
				validators: {
					notEmpty: {
						message: "联系电话不能为空",
					}
				}
			},
			"student_email": {
				validators: {
					notEmpty: {
						message: "邮箱不能为空",
					}
				}
			},

		}
	}); 
	//初始化所在班级下拉框值 
	$.ajax({
		url: "<?php echo url('ClassInfo/listAll'); ?>",
		type: "get",
		dataType : "json" ,
		success: function(classInfos,response,status) { 
			$("#student_classObj_classNo").empty();
			var html="";
    		$(classInfos).each(function(i,classInfo){
    			html += "<option value='" + classInfo.classNo + "'>" + classInfo.className + "</option>";
    		});
    		$("#student_classObj_classNo").html(html);
    	}
	});
	//出生日期组件
	$('#student_birthDateDiv').datetimepicker({
		language:  'zh-CN',  //显示语言
		format: 'yyyy-mm-dd',
		minView: 2,
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		minuteStep: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0
	}).on('hide',function(e) {
		//下面这行代码解决日期组件改变日期后不验证的问题
		$('#studentAddForm').data('bootstrapValidator').updateStatus('student_birthDate', 'NOT_VALIDATED',null).validateField('student_birthDate');
	});
	//注册时间组件
	$('#student_regTimeDiv').datetimepicker({
		language:  'zh-CN',  //显示语言
		format: 'yyyy-mm-dd hh:ii:ss',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		minuteStep: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0
	}).on('hide',function(e) {
		//下面这行代码解决日期组件改变日期后不验证的问题
		$('#studentAddForm').data('bootstrapValidator').updateStatus('student_regTime', 'NOT_VALIDATED',null).validateField('student_regTime');
	});
})
</script>
</body>
</html>
