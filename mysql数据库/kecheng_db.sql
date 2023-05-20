/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : kecheng_db

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2019-06-21 00:02:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_admin`
-- ----------------------------
DROP TABLE IF EXISTS `t_admin`;
CREATE TABLE `t_admin` (
  `username` varchar(20) NOT NULL default '',
  `password` varchar(32) default NULL,
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_admin
-- ----------------------------
INSERT INTO `t_admin` VALUES ('a', 'a');

-- ----------------------------
-- Table structure for `t_classinfo`
-- ----------------------------
DROP TABLE IF EXISTS `t_classinfo`;
CREATE TABLE `t_classinfo` (
  `classNo` varchar(20) NOT NULL COMMENT 'classNo',
  `className` varchar(20) NOT NULL COMMENT '班级名称',
  `bornDate` varchar(20) default NULL COMMENT '成立日期',
  `mainTeacher` varchar(20) default NULL COMMENT '班主任',
  `classMemo` varchar(500) default NULL COMMENT '班级备注',
  PRIMARY KEY  (`classNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_classinfo
-- ----------------------------
INSERT INTO `t_classinfo` VALUES ('BJ001', '2019级计算机2班', '2019-06-12', '李向阳', '测试');
INSERT INTO `t_classinfo` VALUES ('BJ002', '2019级计算机1班', '2019-06-01', '王章', '测试');

-- ----------------------------
-- Table structure for `t_homework`
-- ----------------------------
DROP TABLE IF EXISTS `t_homework`;
CREATE TABLE `t_homework` (
  `homeworkId` int(11) NOT NULL auto_increment COMMENT '作业id',
  `taskTitle` varchar(80) NOT NULL COMMENT '作业任务',
  `taskContent` varchar(8000) NOT NULL COMMENT '作业要求',
  `teacherObj` varchar(20) NOT NULL COMMENT '布置的老师',
  `homeworkDate` varchar(20) default NULL COMMENT '作业日期',
  PRIMARY KEY  (`homeworkId`),
  KEY `teacherObj` (`teacherObj`),
  CONSTRAINT `t_homework_ibfk_1` FOREIGN KEY (`teacherObj`) REFERENCES `t_teacher` (`teacherNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_homework
-- ----------------------------
INSERT INTO `t_homework` VALUES ('1', '完成教科书第23页题目', '<p>完成其中的第4题和第8题，将做题过程发到我的邮箱xxxxx@qq.com</p>', 'TH001', '2019-06-19');
INSERT INTO `t_homework` VALUES ('2', '完成教科书25页编程', '<p>写一个测试程序，下次上课点名演示效果<br/></p>', 'TH002', '2019-06-20');

-- ----------------------------
-- Table structure for `t_kejian`
-- ----------------------------
DROP TABLE IF EXISTS `t_kejian`;
CREATE TABLE `t_kejian` (
  `kejianId` int(11) NOT NULL auto_increment COMMENT '课件id',
  `title` varchar(20) NOT NULL COMMENT '课件标题',
  `kejianFile` varchar(60) NOT NULL COMMENT '课件文件',
  `kejianDesc` varchar(8000) NOT NULL COMMENT '课件描述',
  `teacherObj` varchar(20) NOT NULL COMMENT '发布老师',
  `addTime` varchar(20) default NULL COMMENT '发布时间',
  PRIMARY KEY  (`kejianId`),
  KEY `teacherObj` (`teacherObj`),
  CONSTRAINT `t_kejian_ibfk_1` FOREIGN KEY (`teacherObj`) REFERENCES `t_teacher` (`teacherNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_kejian
-- ----------------------------
INSERT INTO `t_kejian` VALUES ('1', 'word里面怎么使用表格课件', 'upload/839c4883d3eb9ecf239821a5934b636e.ppt', '<p>这个课件教会你怎么用word里面插入表格使用</p>', 'TH001', '2019-06-19 22:42:10');
INSERT INTO `t_kejian` VALUES ('2', 'excel怎么统计常用表格数据', 'upload/4002cdc5054c76508b0354cfae78a1f3.ppt', '<p>学习常用的excel报表统计方法！<br/></p>', 'TH002', '2019-06-20 17:37:10');

-- ----------------------------
-- Table structure for `t_notice`
-- ----------------------------
DROP TABLE IF EXISTS `t_notice`;
CREATE TABLE `t_notice` (
  `noticeId` int(11) NOT NULL auto_increment COMMENT '公告id',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `content` varchar(5000) NOT NULL COMMENT '公告内容',
  `publishDate` varchar(20) default NULL COMMENT '发布时间',
  PRIMARY KEY  (`noticeId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_notice
-- ----------------------------
INSERT INTO `t_notice` VALUES ('1', 'php精品网站成立了', '<p>同学们可以来这里学习知识，老师不定期的发送学习资料到网站上，还有好多测试试卷，可以通过考试了解自己对知识的了解程度哦！</p>', '2019-06-19 22:45:20');

-- ----------------------------
-- Table structure for `t_paper`
-- ----------------------------
DROP TABLE IF EXISTS `t_paper`;
CREATE TABLE `t_paper` (
  `paperId` int(11) NOT NULL auto_increment COMMENT '试卷id',
  `paperName` varchar(50) NOT NULL COMMENT '试卷名称',
  `purpose` varchar(500) NOT NULL COMMENT '测试目标',
  `examTime` int(11) NOT NULL COMMENT '考试时间(分钟)',
  `totalScore` varchar(20) NOT NULL COMMENT '试卷满分',
  `paperMemo` varchar(500) default NULL COMMENT '试卷备注',
  PRIMARY KEY  (`paperId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_paper
-- ----------------------------
INSERT INTO `t_paper` VALUES ('1', '2019年中期计算机基础测试', '掌握计算机基础知识', '60', '100', '测试');
INSERT INTO `t_paper` VALUES ('2', '平时习题测试练习', '掌握计算机基础知识', '50', '80', '测试');

-- ----------------------------
-- Table structure for `t_papersubject`
-- ----------------------------
DROP TABLE IF EXISTS `t_papersubject`;
CREATE TABLE `t_papersubject` (
  `psId` int(11) NOT NULL auto_increment COMMENT '试卷题目id',
  `paperObj` int(11) NOT NULL COMMENT '测试试卷',
  `subjectObj` int(11) NOT NULL COMMENT '题库题目',
  `addTime` varchar(20) default NULL COMMENT '添加时间',
  PRIMARY KEY  (`psId`),
  KEY `paperObj` (`paperObj`),
  KEY `subjectObj` (`subjectObj`),
  CONSTRAINT `t_papersubject_ibfk_2` FOREIGN KEY (`subjectObj`) REFERENCES `t_subject` (`subjectId`),
  CONSTRAINT `t_papersubject_ibfk_1` FOREIGN KEY (`paperObj`) REFERENCES `t_paper` (`paperId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_papersubject
-- ----------------------------
INSERT INTO `t_papersubject` VALUES ('1', '1', '1', '2019-06-19 22:43:54');
INSERT INTO `t_papersubject` VALUES ('2', '1', '2', '2019-06-20 12:25:18');
INSERT INTO `t_papersubject` VALUES ('3', '1', '3', '2019-06-20 12:33:34');
INSERT INTO `t_papersubject` VALUES ('4', '1', '4', '2019-06-20 12:33:41');
INSERT INTO `t_papersubject` VALUES ('5', '2', '5', '2019-06-20 23:54:51');
INSERT INTO `t_papersubject` VALUES ('6', '2', '4', '2019-06-20 23:54:58');
INSERT INTO `t_papersubject` VALUES ('7', '2', '3', '2019-06-20 23:55:04');

-- ----------------------------
-- Table structure for `t_question`
-- ----------------------------
DROP TABLE IF EXISTS `t_question`;
CREATE TABLE `t_question` (
  `questionId` int(11) NOT NULL auto_increment COMMENT '问题id',
  `questionTitle` varchar(80) NOT NULL COMMENT '提问标题',
  `questionContent` varchar(8000) NOT NULL COMMENT '提问内容',
  `userObj` varchar(30) NOT NULL COMMENT '提问学生',
  `questionTime` varchar(20) default NULL COMMENT '提问时间',
  `replyContent` varchar(8000) default NULL COMMENT '答疑回复',
  `replyTime` varchar(20) default NULL COMMENT '答疑时间',
  PRIMARY KEY  (`questionId`),
  KEY `userObj` (`userObj`),
  CONSTRAINT `t_question_ibfk_1` FOREIGN KEY (`userObj`) REFERENCES `t_student` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_question
-- ----------------------------
INSERT INTO `t_question` VALUES ('1', ' 怎么才能成为计算机高手', '<p>老师你好，我对计算机很感兴趣，我要怎么才能成为一个计算机高手，我对网站开发很感兴趣</p>', 'STU001', '2019-06-19 22:44:44', '<p>先打好计算机基础，然后选一门网站开发语言学习吧</p>', '2019-06-19 22:44:48');
INSERT INTO `t_question` VALUES ('2', 'bbbb', '<p>ccccc</p>', 'STU001', '2019-06-20 16:43:18', '<p>--</p>', '--');

-- ----------------------------
-- Table structure for `t_score`
-- ----------------------------
DROP TABLE IF EXISTS `t_score`;
CREATE TABLE `t_score` (
  `scoreId` int(11) NOT NULL auto_increment COMMENT '成绩id',
  `studentObj` varchar(30) NOT NULL COMMENT '考试学生',
  `paperObj` int(11) NOT NULL COMMENT '测试试卷',
  `chengji` float NOT NULL COMMENT '考试成绩',
  `examTime` varchar(20) default NULL COMMENT '考试时间',
  PRIMARY KEY  (`scoreId`),
  KEY `studentObj` (`studentObj`),
  KEY `paperObj` (`paperObj`),
  CONSTRAINT `t_score_ibfk_2` FOREIGN KEY (`paperObj`) REFERENCES `t_paper` (`paperId`),
  CONSTRAINT `t_score_ibfk_1` FOREIGN KEY (`studentObj`) REFERENCES `t_student` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_score
-- ----------------------------
INSERT INTO `t_score` VALUES ('6', 'STU001', '1', '5', '2019-06-20 15:31:08');
INSERT INTO `t_score` VALUES ('7', 'STU001', '2', '7', '2019-06-20 23:59:50');

-- ----------------------------
-- Table structure for `t_student`
-- ----------------------------
DROP TABLE IF EXISTS `t_student`;
CREATE TABLE `t_student` (
  `user_name` varchar(30) NOT NULL COMMENT 'user_name',
  `password` varchar(30) NOT NULL COMMENT '登录密码',
  `classObj` varchar(20) NOT NULL COMMENT '所在班级',
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `gender` varchar(4) NOT NULL COMMENT '性别',
  `birthDate` varchar(20) default NULL COMMENT '出生日期',
  `userPhoto` varchar(60) NOT NULL COMMENT '学生照片',
  `telephone` varchar(20) NOT NULL COMMENT '联系电话',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `address` varchar(80) default NULL COMMENT '家庭地址',
  `regTime` varchar(20) default NULL COMMENT '注册时间',
  PRIMARY KEY  (`user_name`),
  KEY `classObj` (`classObj`),
  CONSTRAINT `t_student_ibfk_1` FOREIGN KEY (`classObj`) REFERENCES `t_classinfo` (`classNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_student
-- ----------------------------
INSERT INTO `t_student` VALUES ('STU001', '123', 'BJ001', '王夏红', '女', '2019-06-13', 'upload/b5d0e34ef4a7223fd04d5e49dbcc0fbd.jpg', '13058200843', 'wangxiah@163.com', '四川南充航空路12号', '2019-06-19 22:41:36');
INSERT INTO `t_student` VALUES ('STU002', '123', 'BJ001', '张晓丽', '女', '2019-06-07', 'upload/459dbff1bc7c48082561ec30ea15c230.jpg', '13985083941', 'xiaoli@163.com', '四川成都红星路', '2019-06-20 11:27:52');

-- ----------------------------
-- Table structure for `t_studentanswer`
-- ----------------------------
DROP TABLE IF EXISTS `t_studentanswer`;
CREATE TABLE `t_studentanswer` (
  `answerId` int(11) NOT NULL auto_increment COMMENT '学生答案id',
  `paperObj` int(11) NOT NULL COMMENT '测试试卷',
  `subjectObj` int(11) NOT NULL COMMENT '考试题目',
  `studentOption` varchar(20) NOT NULL COMMENT '学生答案',
  `studentObj` varchar(30) NOT NULL COMMENT '测试学生',
  `examTime` varchar(20) default NULL COMMENT '考试时间',
  PRIMARY KEY  (`answerId`),
  KEY `paperObj` (`paperObj`),
  KEY `subjectObj` (`subjectObj`),
  KEY `studentObj` (`studentObj`),
  CONSTRAINT `t_studentanswer_ibfk_1` FOREIGN KEY (`paperObj`) REFERENCES `t_paper` (`paperId`),
  CONSTRAINT `t_studentanswer_ibfk_2` FOREIGN KEY (`subjectObj`) REFERENCES `t_subject` (`subjectId`),
  CONSTRAINT `t_studentanswer_ibfk_3` FOREIGN KEY (`studentObj`) REFERENCES `t_student` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_studentanswer
-- ----------------------------
INSERT INTO `t_studentanswer` VALUES ('1', '1', '1', 'A', 'STU001', '2019-06-20 15:31:08');
INSERT INTO `t_studentanswer` VALUES ('2', '1', '2', 'B', 'STU001', '2019-06-20 15:31:08');
INSERT INTO `t_studentanswer` VALUES ('3', '1', '3', 'C', 'STU001', '2019-06-20 15:31:08');
INSERT INTO `t_studentanswer` VALUES ('4', '1', '4', 'D', 'STU001', '2019-06-20 15:31:08');
INSERT INTO `t_studentanswer` VALUES ('5', '2', '5', 'D', 'STU001', '2019-06-20 23:59:50');
INSERT INTO `t_studentanswer` VALUES ('6', '2', '4', 'D', 'STU001', '2019-06-20 23:59:50');
INSERT INTO `t_studentanswer` VALUES ('7', '2', '3', 'A', 'STU001', '2019-06-20 23:59:50');

-- ----------------------------
-- Table structure for `t_subject`
-- ----------------------------
DROP TABLE IF EXISTS `t_subject`;
CREATE TABLE `t_subject` (
  `subjectId` int(11) NOT NULL auto_increment COMMENT '题目id',
  `title` varchar(60) NOT NULL COMMENT '题目标题',
  `a_option` varchar(50) NOT NULL COMMENT 'A',
  `b_option` varchar(50) NOT NULL COMMENT 'B',
  `c_option` varchar(50) NOT NULL COMMENT 'C',
  `d_option` varchar(50) default NULL COMMENT 'D',
  `rightOption` varchar(20) NOT NULL COMMENT '正确答案',
  `score` float NOT NULL COMMENT '得分',
  PRIMARY KEY  (`subjectId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_subject
-- ----------------------------
INSERT INTO `t_subject` VALUES ('1', '800万像素相机拍出的照片最大分辨率大概是__________。', '1600*1200', '2048*1600', '3200*2400', '1024*768', 'C', '2');
INSERT INTO `t_subject` VALUES ('2', '以.txt为扩展名的文件通常是________。', '音频信号文件', '文本文件', '视频信号文件', '图像文件', 'B', '3');
INSERT INTO `t_subject` VALUES ('3', '声音和视频信息在计算机中的表现形式是__________。', '二进制数据', '模拟', '调制', '模拟或数字', 'A', '3');
INSERT INTO `t_subject` VALUES ('4', '对声音波形采样时，采样频率越高，声音文件的数据量______。', '无法确定', '越小', '不变', '越大', 'D', '2');
INSERT INTO `t_subject` VALUES ('5', '现代微型计算机中所采用的电子器件是______________。', '电子管', '小规模集成电路', '晶体管', '大规模和超大规模集成电路', 'D', '2');

-- ----------------------------
-- Table structure for `t_teacher`
-- ----------------------------
DROP TABLE IF EXISTS `t_teacher`;
CREATE TABLE `t_teacher` (
  `teacherNo` varchar(20) NOT NULL COMMENT 'teacherNo',
  `password` varchar(20) NOT NULL COMMENT '登录密码',
  `teacherName` varchar(20) NOT NULL COMMENT '教师姓名',
  `teacherSex` varchar(4) NOT NULL COMMENT '教师性别',
  `teacherAge` int(11) NOT NULL COMMENT '教师年龄',
  `teacherPhoto` varchar(60) NOT NULL COMMENT '教师照片',
  `comeDate` varchar(20) default NULL COMMENT '入职日期',
  `teacherDesc` varchar(8000) NOT NULL COMMENT '教师介绍',
  PRIMARY KEY  (`teacherNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_teacher
-- ----------------------------
INSERT INTO `t_teacher` VALUES ('TH001', '123', '王雨露', '女', '28', 'upload/67bd964108e0ad009f9a8cce0df6cf5a.jpg', '2019-06-06', '<p>老师从事多年的计算机教学经验，代课认真</p>');
INSERT INTO `t_teacher` VALUES ('TH002', '123', '李夏曦', '女', '29', 'upload/c01b44e9fa4c1f07101abd96b30d5295.jpg', '2019-01-29', '<p>工作认真负责，已经有10年经验<br/></p>');

-- ----------------------------
-- Table structure for `t_video`
-- ----------------------------
DROP TABLE IF EXISTS `t_video`;
CREATE TABLE `t_video` (
  `videoId` int(11) NOT NULL auto_increment COMMENT '视频id',
  `title` varchar(20) NOT NULL COMMENT '视频标题',
  `videoFile` varchar(60) NOT NULL COMMENT '视频文件',
  `videoDesc` varchar(8000) NOT NULL COMMENT '视频介绍',
  `teacherObj` varchar(20) NOT NULL COMMENT '发布老师',
  `videoTime` varchar(20) default NULL COMMENT '发布时间',
  PRIMARY KEY  (`videoId`),
  KEY `teacherObj` (`teacherObj`),
  CONSTRAINT `t_video_ibfk_1` FOREIGN KEY (`teacherObj`) REFERENCES `t_teacher` (`teacherNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_video
-- ----------------------------
INSERT INTO `t_video` VALUES ('1', 'excel操作技巧视频', 'upload/74b17893de4b65260c49e6b0fd236bb8.mp4', '<p>教大家如何操作excel的常用快捷方法</p>', 'TH001', '2019-06-19 22:42:20');
INSERT INTO `t_video` VALUES ('2', 'word常用操作方法教学', 'upload/18c4e5bd216d3f5d02a7d50a51315c9e.mp4', '<p>教大家如何成为高手使用word的方法！</p>', 'TH002', '2019-06-20 20:58:45');
