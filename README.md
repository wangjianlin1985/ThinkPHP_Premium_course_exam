# ThinkPHP_Premium_course_exam
ThinkPHP精品课程在线考试答疑网毕业源码案例设计

## 开发软件：VSCode或PHPStorm或DW等  数据库：mysql
## 程序后台技术框架：ThinkPHP(一个MVC框架)
## 后台界面采用EasyUI框架，前台界面采用Bootstrap框架，用户浏览器和服务器全程几乎采用jquery异步加载技术！
1、学生模块的功能主要包括：登录、项目学习（项目分析、视频学习、理论测试）、在线答疑、公告浏览等。

2、教师模块的功能主要包括：项目添加发布修改删除、理论测试、在线答疑、学生管理等。

3、后台管理模块的功能主要包括：用户管理、公告发布、在线考试、在线答疑、数据库管理等
## 实体ER属性：
学生: 学号,登录密码,所在班级,姓名,性别,出生日期,学生照片,联系电话,邮箱,家庭地址,注册时间

班级: 班级编号,班级名称,成立日期,班主任,班级备注

教师: 教师工号,登录密码,教师姓名,教师性别,教师年龄,教师照片,入职日期,教师介绍

课件: 课件id,课件标题,课件文件,课件描述,发布老师,发布时间

学习视频: 视频id,视频标题,视频文件,视频介绍,发布老师,发布时间

测试试卷: 试卷id,试卷名称,测试目标,考试时间(分钟),试卷满分,试卷备注

题库题目: 题目id,题目标题,A,B,C,D,正确答案,得分

试卷题目: 试卷题目id,测试试卷,题库题目,添加时间

学生答案: 学生答案id,测试试卷,考试题目,学生答案,测试学生,考试时间

学生成绩: 成绩id,考试学生,测试试卷,考试成绩,考试时间

问题答疑: 问题id,提问标题,提问内容,提问学生,提问时间,答疑回复,答疑时间

家庭作业: 作业id,作业任务,作业要求,布置的老师,作业日期

新闻公告: 公告id,标题,公告内容,发布时间
