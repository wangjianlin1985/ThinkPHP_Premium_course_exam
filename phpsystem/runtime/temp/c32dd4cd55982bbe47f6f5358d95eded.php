<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:89:"C:\xampp\htdocs\phpsystem\public/../application/front\view\subject\subject_frontlist.html";i:1550587160;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\header.html";i:1550642460;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\footer.html";i:1538061378;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
<title>题库题目查询</title>
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
                <li><a href="<?php echo url('Subject/frontlist'); ?>">题库题目</a></li>
                <!--
                <li><a href="<?php echo url('Notice/frontlist'); ?>">新闻公告</a></li>
                <li><a href="<?php echo url('PaperSubject/frontlist'); ?>">试卷题目</a></li>
                <li><a href="<?php echo url('StudentAnswer/frontlist'); ?>">学生答案</a></li> -->
                <li><a href="<?php echo url('Score/frontlist'); ?>">学生成绩</a></li>
                <li><a href="<?php echo url('Question/frontlist'); ?>">问题答疑</a></li>
                <li><a href="<?php echo url('Homework/frontlist'); ?>">家庭作业</a></li>


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
                        <li><a href="<?php echo url('BookType/frontlist'); ?>"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;我要提问</a></li>
                        <li><a href="<?php echo url('Book/frontlist'); ?>"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;我的问题答疑</a></li>
                        <li><a href="<?php echo url('Book/frontlist'); ?>"><span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;我的成绩查询</a></li>
                        <li><a href="<?php echo url('Book/frontlist'); ?>"><span class="glyphicon glyphicon-credit-card"></span>&nbsp;&nbsp;修改个人资料</a></li>
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

	<div class="row"> 
		<div class="col-md-9 wow fadeInDown" data-wow-duration="0.5s">
			<div>
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
			    	<li><a href="__PUBLIC__/index.php">首页</a></li>
			    	<li role="presentation" class="active"><a href="#subjectListPanel" aria-controls="subjectListPanel" role="tab" data-toggle="tab">题库题目列表</a></li>
			    	<li role="presentation" ><a href="<?php echo url('Subject/frontAdd'); ?>" style="display:none;">添加题库题目</a></li>
				</ul>
			  	<!-- Tab panes -->
			  	<div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="subjectListPanel">
				    		<div class="row">
				    			<div class="col-md-12 top5">
				    				<div class="table-responsive">
				    				<table class="table table-condensed table-hover">
				    					<tr class="success bold"><td>序号</td><td>题目id</td><td>题目标题</td><td>A</td><td>B</td><td>C</td><td>D</td><td>正确答案</td><td>得分</td><td>操作</td></tr>
				    					<?php
				    						/*计算起始序号*/
				    	            		$startIndex = ($currentPage-1) * $rows;
				    	            		$currentIndex = $startIndex+1;
				    	            		/*遍历记录*/
				    					if(is_array($subjectRs) || $subjectRs instanceof \think\Collection): $i = 0; $__LIST__ = $subjectRs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subject): $mod = ($i % 2 );++$i;?>
 										<tr>
 											<td><?php echo $currentIndex++; ?></td>
 											<td><?php echo $subject['subjectId']; ?></td>
 											<td><?php echo $subject['title']; ?></td>
 											<td><?php echo $subject['a_option']; ?></td>
 											<td><?php echo $subject['b_option']; ?></td>
 											<td><?php echo $subject['c_option']; ?></td>
 											<td><?php echo $subject['d_option']; ?></td>
 											<td><?php echo $subject['rightOption']; ?></td>
 											<td><?php echo $subject['score']; ?></td>
 											<td>
 												<a href="<?php echo url('Subject/frontshow',array('subjectId'=>$subject['subjectId'])); ?>"><i class="fa fa-info"></i>&nbsp;查看</a>&nbsp;
 												<a href="#" onclick="subjectEdit('<?php echo $subject['subjectId']; ?>');" style="display:none;"><i class="fa fa-pencil fa-fw"></i>编辑</a>&nbsp;
 												<a href="#" onclick="subjectDelete('<?php echo $subject['subjectId']; ?>');" style="display:none;"><i class="fa fa-trash-o fa-fw"></i>删除</a>
 											</td> 
 										</tr>
 										<?php endforeach; endif; else: echo "" ;endif; ?>
				    				</table>
				    				</div>
				    			</div>
				    		</div>

				    		<div class="row">
					            <div class="col-md-12">
						            <nav class="pull-left">
						                <ul class="pagination">
						                    <li><a href="#" onclick="GoToPage(<%=currentPage-1 %>,<%=totalPage %>);" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
						                     <?php
						                    	$startPage = $currentPage - 5;
						                    	$endPage = $currentPage + 5;
						                    	if($startPage < 1) $startPage=1;
						                    	if($endPage > $totalPage) $endPage = $totalPage;
						                    	for($i=$startPage;$i<=$endPage;$i++) {
						                    ?>
						                    <li class="<?php echo $currentPage==$i?"active":""; ?>"><a href="#"  onclick="GoToPage(<?php echo $i; ?>,<?php echo $totalPage; ?>);"><?php echo $i; ?></a></li>
						                    <?php } ?>
						                    <li><a href="#" onclick="GoToPage(<?php echo $currentPage + 1; ?>,<?php echo $totalPage; ?>);"><span aria-hidden="true">&raquo;</span></a></li>
						                </ul>
						            </nav>
						            <div class="pull-right" style="line-height:75px;" >共有<?php echo $recordNumber; ?>条记录，当前第<?php echo $currentPage; ?>/<?php echo $totalPage; ?>页</div>
					            </div>
				            </div> 
				    </div>
				</div>
			</div>
		</div>
	<div class="col-md-3 wow fadeInRight">
		<div class="page-header">
    		<h1>题库题目查询</h1>
		</div>
		<form name="subjectQueryForm" id="subjectQueryForm" action="<?php echo url('Subject/frontlist'); ?>" class="mar_t15" method="post">
			<div class="form-group">
				<label for="title">题目标题:</label>
				<input type="text" id="title" name="title" value="<?php echo $title; ?>" class="form-control" placeholder="请输入题目标题">
			</div>
            <input type=hidden name=currentPage id="currentPage" value="<%=currentPage %>" />
            <button type="submit" class="btn btn-primary" onclick="$('#currentPage').val(1);return true;">查询</button>
        </form>
	</div>

		</div>
	</div> 
<div id="subjectEditDialog" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;题库题目信息编辑</h4>
      </div>
      <div class="modal-body" style="height:450px; overflow: scroll;">
      	<form class="form-horizontal" name="subjectEditForm" id="subjectEditForm" enctype="multipart/form-data" method="post"  class="mar_t15">
		  <div class="form-group">
			 <label for="subject_subjectId_edit" class="col-md-3 text-right">题目id:</label>
			 <div class="col-md-9"> 
			 	<input type="text" id="subject_subjectId_edit" name="subject.subjectId" class="form-control" placeholder="请输入题目id" readOnly>
			 </div>
		  </div> 
		  <div class="form-group">
		  	 <label for="subject_title_edit" class="col-md-3 text-right">题目标题:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="subject_title_edit" name="subject_title" class="form-control" placeholder="请输入题目标题">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="subject_a_option_edit" class="col-md-3 text-right">A:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="subject_a_option_edit" name="subject_a_option" class="form-control" placeholder="请输入A">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="subject_b_option_edit" class="col-md-3 text-right">B:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="subject_b_option_edit" name="subject_b_option" class="form-control" placeholder="请输入B">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="subject_c_option_edit" class="col-md-3 text-right">C:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="subject_c_option_edit" name="subject_c_option" class="form-control" placeholder="请输入C">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="subject_d_option_edit" class="col-md-3 text-right">D:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="subject_d_option_edit" name="subject_d_option" class="form-control" placeholder="请输入D">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="subject_rightOption_edit" class="col-md-3 text-right">正确答案:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="subject_rightOption_edit" name="subject_rightOption" class="form-control" placeholder="请输入正确答案">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="subject_score_edit" class="col-md-3 text-right">得分:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="subject_score_edit" name="subject_score" class="form-control" placeholder="请输入得分">
			 </div>
		  </div>
		</form> 
	    <style>#subjectEditForm .form-group {margin-bottom:5px;}  </style>
      </div>
      <div class="modal-footer"> 
      	<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      	<button type="button" class="btn btn-primary" onclick="ajaxSubjectModify();">提交</button>
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
<script>
/*跳转到查询结果的某页*/
function GoToPage(currentPage,totalPage) {
    if(currentPage==0) return;
    if(currentPage>totalPage) return;
    document.subjectQueryForm.currentPage.value = currentPage;
    document.subjectQueryForm.submit();
}

/*可以直接跳转到某页*/
function changepage(totalPage)
{
    var pageValue=document.subjectQueryForm.pageValue.value;
    if(pageValue>totalPage) {
        alert('你输入的页码超出了总页数!');
        return ;
    }
    document.subjectQueryForm.currentPage.value = pageValue;
    documentsubjectQueryForm.submit();
}

/*弹出修改题库题目界面并初始化数据*/
function subjectEdit(subjectId) {
	$.ajax({
		url :  "<?php echo url('Subject/update'); ?>?subjectId=" + subjectId ,
		type : "get",
		dataType: "json",
		success : function (subject, response, status) {
			if (subject) {
				$("#subject_subjectId_edit").val(subject.subjectId);
				$("#subject_title_edit").val(subject.title);
				$("#subject_a_option_edit").val(subject.a_option);
				$("#subject_b_option_edit").val(subject.b_option);
				$("#subject_c_option_edit").val(subject.c_option);
				$("#subject_d_option_edit").val(subject.d_option);
				$("#subject_rightOption_edit").val(subject.rightOption);
				$("#subject_score_edit").val(subject.score);
				$('#subjectEditDialog').modal('show');
			} else {
				alert("获取信息失败！");
			}
		}
	});
}

/*删除题库题目信息*/
function subjectDelete(subjectId) {
	if(confirm("确认删除这个记录")) {
		$.ajax({
			type : "POST",
			url: "<?php echo url('Subject/deletes'); ?>",
			data : {
				subjectIds : subjectId,
			},
			dataType: "json",
			success : function (obj) {
				if (obj.success) {
					alert("删除成功");
					$("#subjectQueryForm").submit();
					//location.href="<?php echo url('Subject/frontlist'); ?>";
				}
				else 
					alert(obj.message);
			},
		});
	}
}

/*ajax方式提交题库题目信息表单给服务器端修改*/
function ajaxSubjectModify() {
	$.ajax({
		url :  "<?php echo url('Subject/update'); ?>",
		type : "post",
		dataType: "json",
		data: new FormData($("#subjectEditForm")[0]),
		success : function (obj, response, status) {
            if(obj.success){
                alert("信息修改成功！");
                $("#subjectQueryForm").submit();
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

})
</script>
</body>
</html>

