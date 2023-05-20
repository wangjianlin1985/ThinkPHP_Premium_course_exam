<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"C:\xampp\htdocs\phpsystem\public/../application/front\view\paper\paper_frontshow.html";i:1550648179;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\header.html";i:1550653415;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\footer.html";i:1538061378;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
  <TITLE>查看测试试卷详情</TITLE>
  <link href="__PUBLIC__/plugins/bootstrap.css" rel="stylesheet">
  <link href="__PUBLIC__/plugins/bootstrap-dashen.css" rel="stylesheet">
  <link href="__PUBLIC__/plugins/font-awesome.css" rel="stylesheet">
  <link href="__PUBLIC__/plugins/animate.css" rel="stylesheet"> 
</head>
<body style="margin-top:70px;"> 
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

<form action="<?php echo url('StudentAnswer/submitAnswer'); ?>" method="post" onsubmit="return checkRadios();" enctype="multipart/form-data" name="form1">
<div class="container">
	<ul class="breadcrumb">
  		<li><a href="__PUBLIC__/index.php">首页</a></li>
  		<li><a href="<?php echo url('Paper/frontlist'); ?>">测试试卷信息</a></li>
  		<li class="active">详情查看</li>
	</ul>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">试卷id:</div>
		<div class="col-md-10 col-xs-6"><?php echo $paper['paperId']; ?></div>
	</div>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">试卷名称:</div>
		<div class="col-md-10 col-xs-6"><?php echo $paper['paperName']; ?></div>
	</div>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">测试目标:</div>
		<div class="col-md-10 col-xs-6"><?php echo $paper['purpose']; ?></div>
	</div>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">考试时间:</div>
		<div class="col-md-10 col-xs-6"><?php echo $paper['examTime']; ?>分钟</div>
	</div>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">试卷满分:</div>
		<div class="col-md-10 col-xs-6"><?php echo $paper['totalScore']; ?>分</div>
	</div>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">试卷备注:</div>
		<div class="col-md-10 col-xs-6"><?php echo $paper['paperMemo']; ?></div>
	</div>

	<?php
		$currentIndex = 1;
	if(is_array($subjects) || $subjects instanceof \think\Collection): $i = 0; $__LIST__ = $subjects;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subject): $mod = ($i % 2 );++$i;?>
	<div class="row bottom15">
		<div class="col-md-2 col-xs-4 text-right bold">题目<?php echo $currentIndex++; ?>:</div>
		<div class="col-md-10 col-xs-6"><?php echo $subject['title']; ?>&nbsp;&nbsp;（分值:<?php echo $subject['score']; ?>分）</div>
	</div>
	<div class="row bottom15">

		<div class="col-md-2 col-xs-4 text-right bold">A:</div>
		<div class="col-md-10 col-xs-6">
			<input style="margin:5px;" type="radio" name="s_<?php echo $subject['subjectId']; ?>" value="A"/><?php echo $subject['a_option']; ?>
		</div>
	</div>
	<div class="row bottom15">
		<div class="col-md-2 col-xs-4 text-right bold">B:</div>
		<div class="col-md-10 col-xs-6">
			<input style="margin:5px;" type="radio" name="s_<?php echo $subject['subjectId']; ?>" value="B"/><?php echo $subject['b_option']; ?>
		</div>
	</div>
	<div class="row bottom15">
		<div class="col-md-2 col-xs-4 text-right bold">C:</div>
		<div class="col-md-10 col-xs-6">
			<input style="margin:5px;" type="radio" name="s_<?php echo $subject['subjectId']; ?>" value="C"/><?php echo $subject['c_option']; ?>
		</div>
	</div>
	<div class="row bottom15">
		<div class="col-md-2 col-xs-4 text-right bold">D:</div>
		<div class="col-md-10 col-xs-6">
			<input style="margin:5px;" type="radio" name="s_<?php echo $subject['subjectId']; ?>" value="D"/><?php echo $subject['d_option']; ?>
		</div>
	</div>
	<?php endforeach; endif; else: echo "" ;endif; ?>


	<div class="row bottom15">
		<div class="col-md-2 col-xs-4"></div>
		<div class="col-md-6 col-xs-6">
			<input type="hidden" name="paperId" value="<?php echo $paper['paperId']; ?>"/>
			<input type="submit" class="btn btn-primary" value="提交答案"/>
			<button onclick="history.back();" class="btn btn-info">返回</button>
		</div>
	</div>
</div>
</form>

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
<script>

    function checkRadios(){
        //取得所有input标签
        var radios = document.getElementsByTagName("input");
        var arr = [];
        var radioArray = [];
        //循环标签
        for(var i=0;i<radios.length;i++){
            //判断标签是否是单选框标签
            if (radios[i].type=="radio"){
                var radio = radios[i].checked;
                radioArray.push(radios[i]); //把所有单选框装入数组
                if(radio){
                    arr.push(radios[i]); //判断单选框是否为选中状态, 选中的装入数组
                }
            }
        }
        //如果所有单选框/4的个数==选中的个数,就返回true ,
        if((radioArray.length/4)==arr.length){
            return true;
        }else{
            alert("请作答所有试题!");
            return false;
        }
    }


$(function(){
        /*小屏幕导航点击关闭菜单*/
        $('.navbar-collapse a').click(function(){
            $('.navbar-collapse').collapse('hide');
        });
        new WOW().init();
 })
 </script> 
</body>
</html>

