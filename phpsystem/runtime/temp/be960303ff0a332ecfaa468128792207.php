<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:89:"C:\xampp\htdocs\phpsystem\public/../application/front\view\teacher\teacher_frontlist.html";i:1550587159;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\header.html";i:1550653415;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\footer.html";i:1538061378;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
<title>教师查询</title>
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
            <a href="__PUBLIC__/index.php" class="navbar-brand">php课程网</a>
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
                        <li><a href="<?php echo url('Question/frontStudentAdd'); ?>"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;我要提问</a></li>
                        <li><a href="<?php echo url('Question/studentFrontlist'); ?>"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;我的问题答疑</a></li>
                        <li><a href="<?php echo url('Score/studentFrontlist'); ?>"><span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;我的成绩查询</a></li>
                        <li><a href="<?php echo url('Student/frontModify'); ?>"><span class="glyphicon glyphicon-credit-card"></span>&nbsp;&nbsp;修改个人资料</a></li>
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

	<div class="col-md-9 wow fadeInLeft">
		<ul class="breadcrumb">
  			<li><a href="__PUBLIC__/index.php">首页</a></li>
  			<li><a href="<?php echo url('Teacher/frontlist'); ?>">教师信息列表</a></li>
  			<li class="active">查询结果显示</li>
  			<a class="pull-right" href="<?php echo url('Teacher/frontAdd'); ?>" style="display:none;">添加教师</a>
		</ul>
		<div class="row">
			<?php
				/*计算起始序号*/
				$startIndex = ($currentPage-1) * $rows;
				$currentIndex = $startIndex+1;
				/*遍历记录*/
			if(is_array($teacherRs) || $teacherRs instanceof \think\Collection): $i = 0; $__LIST__ = $teacherRs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$teacher): $mod = ($i % 2 );++$i;
				$clearLeft = "";
				if(($i-1)%4 == 0) $clearLeft = "style=\"clear:left;\"";
			?>
			<div class="col-md-3 bottom15" <?php echo $clearLeft; ?>>
			  <a  href="<?php echo url('Teacher/frontshow',array('teacherNo'=>$teacher['teacherNo'])); ?>"><img class="img-responsive" src="__PUBLIC__/<?php echo $teacher['teacherPhoto']; ?>" /></a>
			     <div class="showFields">
			     	<div class="field">
	            		教师工号:<?php echo $teacher['teacherNo']; ?>
			     	</div>
			     	<div class="field">
	            		教师姓名:<?php echo $teacher['teacherName']; ?>
			     	</div>
			     	<div class="field">
	            		教师性别:<?php echo $teacher['teacherSex']; ?>
			     	</div>
			     	<div class="field">
	            		教师年龄:<?php echo $teacher['teacherAge']; ?>
			     	</div>
			     	<div class="field">
	            		入职日期:<?php echo $teacher['comeDate']; ?>
			     	</div>
			        <a class="btn btn-primary top5" href="<?php echo url('Teacher/frontshow',array('teacherNo'=>$teacher['teacherNo'])); ?>">详情</a>
			        <a class="btn btn-primary top5" onclick="teacherEdit('<?php echo $teacher['teacherNo']; ?>');" style="display:none;">修改</a>
			        <a class="btn btn-primary top5" onclick="teacherDelete('<?php echo $teacher['teacherNo']; ?>');" style="display:none;">删除</a>
			     </div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>

			<div class="row">
				<div class="col-md-12">
					<nav class="pull-left">
						<ul class="pagination">
							<li><a href="#" onclick="GoToPage(<?php echo $currentPage-1; ?>,<?php echo $totalPage; ?>);" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
							<?php
								$startPage = $currentPage - 5;
								$endPage = $currentPage + 5;
								if($startPage < 1) $startPage=1;
								if($endPage > $totalPage) $endPage = $totalPage;
								for($i=$startPage;$i<=$endPage;$i++) {
							?>
							<li class="<?php echo $currentPage==$i?"active":""; ?>"><a href="#"  onclick="GoToPage(<?php echo $i; ?>,<?php echo $totalPage; ?>);"><?php echo $i; ?></a></li>
							<?php } ?>
							<li><a href="#" onclick="GoToPage(<?php echo $currentPage+1; ?>,<?php echo $totalPage; ?>);"><span aria-hidden="true">&raquo;</span></a></li>
						</ul>
					</nav>
					<div class="pull-right" style="line-height:75px;" >共有<?php echo $recordNumber; ?>条记录，当前第 <?php echo $currentPage; ?>/<?php echo $totalPage; ?>  页</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3 wow fadeInRight">
		<div class="page-header">
    		<h1>教师查询</h1>
		</div>
		<form name="teacherQueryForm" id="teacherQueryForm" action="<?php echo url('Teacher/frontlist'); ?>" class="mar_t15" method="post">
			<div class="form-group">
				<label for="teacherNo">教师工号:</label>
				<input type="text" id="teacherNo" name="teacherNo" value="<?php echo $teacherNo; ?>" class="form-control" placeholder="请输入教师工号">
			</div>
			<div class="form-group">
				<label for="teacherName">教师姓名:</label>
				<input type="text" id="teacherName" name="teacherName" value="<?php echo $teacherName; ?>" class="form-control" placeholder="请输入教师姓名">
			</div>
			<div class="form-group">
				<label for="comeDate">入职日期:</label>
				<input type="text" id="comeDate" name="comeDate" class="form-control"  placeholder="请选择入职日期" value="<?php echo $comeDate; ?>" onclick="SelectDate(this,'yyyy-MM-dd')" />
			</div>
            <input type=hidden name=currentPage id="currentPage" value="<?php echo $currentPage; ?>" />
            <button type="submit" class="btn btn-primary" onclick="$('#currentPage').val(1);return true;">查询</button>
        </form>
	</div>

		</div>
</div>
<div id="teacherEditDialog" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:900px;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;教师信息编辑</h4>
      </div>
      <div class="modal-body" style="height:450px; overflow: scroll;">
      	<form class="form-horizontal" name="teacherEditForm" id="teacherEditForm" enctype="multipart/form-data" method="post"  class="mar_t15">
		  <div class="form-group">
			 <label for="teacher_teacherNo_edit" class="col-md-3 text-right">教师工号:</label>
			 <div class="col-md-9"> 
			 	<input type="text" id="teacher_teacherNo_edit" name="teacher.teacherNo" class="form-control" placeholder="请输入教师工号" readOnly>
			 </div>
		  </div> 
		  <div class="form-group">
		  	 <label for="teacher_password_edit" class="col-md-3 text-right">登录密码:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="teacher_password_edit" name="teacher_password" class="form-control" placeholder="请输入登录密码">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="teacher_teacherName_edit" class="col-md-3 text-right">教师姓名:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="teacher_teacherName_edit" name="teacher_teacherName" class="form-control" placeholder="请输入教师姓名">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="teacher_teacherSex_edit" class="col-md-3 text-right">教师性别:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="teacher_teacherSex_edit" name="teacher_teacherSex" class="form-control" placeholder="请输入教师性别">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="teacher_teacherAge_edit" class="col-md-3 text-right">教师年龄:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="teacher_teacherAge_edit" name="teacher_teacherAge" class="form-control" placeholder="请输入教师年龄">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="teacher_teacherPhoto_edit" class="col-md-3 text-right">教师照片:</label>
		  	 <div class="col-md-9">
			    <img  class="img-responsive" id="teacher_teacherPhotoImg" border="0px"/><br/>
			    <input type="hidden" id="teacher_teacherPhoto_edit" name="teacher_teacherPhoto"/>
			    <input id="teacherPhotoFile" name="teacherPhotoFile" type="file" size="50" />
		  	 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="teacher_comeDate_edit" class="col-md-3 text-right">入职日期:</label>
		  	 <div class="col-md-9">
                <div class="input-group date teacher_comeDate_edit col-md-12" data-link-field="teacher_comeDate_edit" data-link-format="yyyy-mm-dd">
                    <input class="form-control" id="teacher_comeDate_edit" name="teacher_comeDate" size="16" type="text" value="" placeholder="请选择入职日期" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
		  	 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="teacher_teacherDesc_edit" class="col-md-3 text-right">教师介绍:</label>
		  	 <div class="col-md-9">
			 	<textarea name="teacher_teacherDesc" id="teacher_teacherDesc_edit" style="width:100%;height:500px;"></textarea>
			 </div>
		  </div>
		</form> 
	    <style>#teacherEditForm .form-group {margin-bottom:5px;}  </style>
      </div>
      <div class="modal-footer"> 
      	<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      	<button type="button" class="btn btn-primary" onclick="ajaxTeacherModify();">提交</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
<script src="__PUBLIC__/plugins/bootstrap-datetimepicker.min.js"></script>
<script src="__PUBLIC__/plugins/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jsdate.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/ueditor/ueditor.all.js"> </script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/ueditor/lang/zh-cn/zh-cn.js"></script>
<script>
//实例化编辑器
var teacher_teacherDesc_edit = UE.getEditor('teacher_teacherDesc_edit'); //教师介绍编辑器
/*跳转到查询结果的某页*/
function GoToPage(currentPage,totalPage) {
    if(currentPage==0) return;
    if(currentPage>totalPage) return;
    document.teacherQueryForm.currentPage.value = currentPage;
    document.teacherQueryForm.submit();
}

/*可以直接跳转到某页*/
function changepage(totalPage)
{
    var pageValue=document.teacherQueryForm.pageValue.value;
    if(pageValue>totalPage) {
        alert('你输入的页码超出了总页数!');
        return ;
    }
    document.teacherQueryForm.currentPage.value = pageValue;
    documentteacherQueryForm.submit();
}

/*弹出修改教师界面并初始化数据*/
function teacherEdit(teacherNo) {
	$.ajax({
		url :  "<?php echo url('Teacher/update'); ?>?teacherNo=" + teacherNo ,
		type : "get",
		dataType: "json",
		success : function (teacher, response, status) {
			if (teacher) {
				$("#teacher_teacherNo_edit").val(teacher.teacherNo);
				$("#teacher_password_edit").val(teacher.password);
				$("#teacher_teacherName_edit").val(teacher.teacherName);
				$("#teacher_teacherSex_edit").val(teacher.teacherSex);
				$("#teacher_teacherAge_edit").val(teacher.teacherAge);
				$("#teacher_teacherPhoto_edit").val(teacher.teacherPhoto);
				$("#teacher_teacherPhotoImg").attr("src", "__PUBLIC__/" + teacher.teacherPhoto);
				$("#teacher_comeDate_edit").val(teacher.comeDate);
				teacher_teacherDesc_edit.setContent(teacher.teacherDesc, false);
				$('#teacherEditDialog').modal('show');
			} else {
				alert("获取信息失败！");
			}
		}
	});
}

/*删除教师信息*/
function teacherDelete(teacherNo) {
	if(confirm("确认删除这个记录")) {
		$.ajax({
			type : "POST",
			url: "<?php echo url('Teacher/deletes'); ?>",
			data : {
				teacherNos : teacherNo,
			},
			dataType: "json",
			success : function (obj) {
				if (obj.success) {
					alert("删除成功");
					$("#teacherQueryForm").submit();
					//location.href= "<?php echo url('Teacher/frontlist'); ?>";
				}
				else 
					alert(obj.message);
			},
		});
	}
}

/*ajax方式提交教师信息表单给服务器端修改*/
function ajaxTeacherModify() {
	$.ajax({
		url :  "<?php echo url('Teacher/update'); ?>",
		type : "post",
		dataType: "json",
		data: new FormData($("#teacherEditForm")[0]),
		success : function (obj, response, status) {
            if(obj.success){
                alert("信息修改成功！");
                $("#teacherQueryForm").submit();
            }else{
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

    /*入职日期组件*/
    $('.teacher_comeDate_edit').datetimepicker({
    	language:  'zh-CN',  //语言
    	format: 'yyyy-mm-dd',
    	minView: 2,
    	weekStart: 1,
    	todayBtn:  1,
    	autoclose: 1,
    	minuteStep: 1,
    	todayHighlight: 1,
    	startView: 2,
    	forceParse: 0
    });
})
</script>
</body>
</html>

