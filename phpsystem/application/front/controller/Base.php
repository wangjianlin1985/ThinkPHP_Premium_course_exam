<?php
namespace app\front\controller;
use think\Controller;

class Base extends Controller
{
    protected $currentPage = 1;
    protected $request = null;

    //向客户端输出ajax响应结果
    public function writeJsonResponse($success, $message) {
        $response = array(
            "success" => $success,
            "message" => $message,
        );
        echo json_encode($response);
    }

    /**
     * @param $obj:  保存图片路径的对象
     * @param $indexName 索引名称
     * @param $photoFiledName 提交的图片表单名称
     */
    public function uploadPhoto(&$obj,$indexName,$photoFiledName) {
        if($_FILES[$photoFiledName]['tmp_name']){
            $file = $this->request->file($photoFiledName);
            //控制上传的文件类型，大小
            if(!(($_FILES[$photoFiledName]["type"]=="image/jpeg"
                    || $_FILES[$photoFiledName]["type"]=="image/jpg"
                    || $_FILES[$photoFiledName]["type"]=="image/png") && $_FILES[$photoFiledName]["size"] < 1024000)) {
                $message = "图书图片请选择jpg或png格式的图片!";
                $this->writeJsonResponse(false,$message);
                exit;
            }
            $file->setRule("short"); //文件路径采用简短方式
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            $obj[$indexName]='upload/'.$info->getSaveName();
        }
    }

    /**
     * @param $obj:  保存文件路径的对象
     * @param $indexName 索引名称
     * @param $resourceFiledName 提交的文件表单名称
     */
    public function uploadFile(&$obj,$indexName,$resourceFiledName) {
        if($_FILES[$resourceFiledName]['tmp_name']){
            $file = $this->request->file($resourceFiledName);
            $file->setRule("short"); //文件路径采用简短方式
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            $obj[$indexName]='upload/'.$info->getSaveName();
        }
    }

    //接收提交的Student信息参数
    public function getStudentForm($insertFlag) {
        $student = [
            'user_name'=> input("student_user_name"), //学号
            'password'=> input("student_password"), //登录密码
            'classObj'=> input("student_classObj_classNo"), //所在班级
            'name'=> input("student_name"), //姓名
            'gender'=> input("student_gender"), //性别
            'birthDate'=> input("student_birthDate"), //出生日期
            'userPhoto' => $insertFlag==true?"upload/NoImage.jpg":input("student_userPhoto"), //学生照片
            'telephone'=> input("student_telephone"), //联系电话
            'email'=> input("student_email"), //邮箱
            'address'=> input("student_address"), //家庭地址
            'regTime'=> input("student_regTime"), //注册时间
        ];
        return $student;
    }

    //接收提交的ClassInfo信息参数
    public function getClassInfoForm($insertFlag) {
        $classInfo = [
            'classNo'=> input("classInfo_classNo"), //班级编号
            'className'=> input("classInfo_className"), //班级名称
            'bornDate'=> input("classInfo_bornDate"), //成立日期
            'mainTeacher'=> input("classInfo_mainTeacher"), //班主任
            'classMemo'=> input("classInfo_classMemo"), //班级备注
        ];
        return $classInfo;
    }

    //接收提交的Teacher信息参数
    public function getTeacherForm($insertFlag) {
        $teacher = [
            'teacherNo'=> input("teacher_teacherNo"), //教师工号
            'password'=> input("teacher_password"), //登录密码
            'teacherName'=> input("teacher_teacherName"), //教师姓名
            'teacherSex'=> input("teacher_teacherSex"), //教师性别
            'teacherAge'=> input("teacher_teacherAge"), //教师年龄
            'teacherPhoto' => $insertFlag==true?"upload/NoImage.jpg":input("teacher_teacherPhoto"), //教师照片
            'comeDate'=> input("teacher_comeDate"), //入职日期
            'teacherDesc'=> input("teacher_teacherDesc"), //教师介绍
        ];
        return $teacher;
    }

    //接收提交的Kejian信息参数
    public function getKejianForm($insertFlag) {
        $kejian = [
            'kejianId'=> input("kejian_kejianId"), //课件id
            'title'=> input("kejian_title"), //课件标题
            'kejianFile' => $insertFlag==true?"":input("kejian_kejianFile"), //课件文件
            'kejianDesc'=> input("kejian_kejianDesc"), //课件描述
            'teacherObj'=> input("kejian_teacherObj_teacherNo"), //发布老师
            'addTime'=> input("kejian_addTime"), //发布时间
        ];
        return $kejian;
    }

    //接收提交的Video信息参数
    public function getVideoForm($insertFlag) {
        $video = [
            'videoId'=> input("video_videoId"), //视频id
            'title'=> input("video_title"), //视频标题
            'videoFile' => $insertFlag==true?"":input("video_videoFile"), //视频文件
            'videoDesc'=> input("video_videoDesc"), //视频介绍
            'teacherObj'=> input("video_teacherObj_teacherNo"), //发布老师
            'videoTime'=> input("video_videoTime"), //发布时间
        ];
        return $video;
    }

    //接收提交的Paper信息参数
    public function getPaperForm($insertFlag) {
        $paper = [
            'paperId'=> input("paper_paperId"), //试卷id
            'paperName'=> input("paper_paperName"), //试卷名称
            'purpose'=> input("paper_purpose"), //测试目标
            'examTime'=> input("paper_examTime"), //考试时间(分钟)
            'totalScore'=> input("paper_totalScore"), //试卷满分
            'paperMemo'=> input("paper_paperMemo"), //试卷备注
        ];
        return $paper;
    }

    //接收提交的Subject信息参数
    public function getSubjectForm($insertFlag) {
        $subject = [
            'subjectId'=> input("subject_subjectId"), //题目id
            'title'=> input("subject_title"), //题目标题
            'a_option'=> input("subject_a_option"), //A
            'b_option'=> input("subject_b_option"), //B
            'c_option'=> input("subject_c_option"), //C
            'd_option'=> input("subject_d_option"), //D
            'rightOption'=> input("subject_rightOption"), //正确答案
            'score'=> input("subject_score"), //得分
        ];
        return $subject;
    }

    //接收提交的PaperSubject信息参数
    public function getPaperSubjectForm($insertFlag) {
        $paperSubject = [
            'psId'=> input("paperSubject_psId"), //试卷题目id
            'paperObj'=> input("paperSubject_paperObj_paperId"), //测试试卷
            'subjectObj'=> input("paperSubject_subjectObj_subjectId"), //题库题目
            'addTime'=> input("paperSubject_addTime"), //添加时间
        ];
        return $paperSubject;
    }

    //接收提交的StudentAnswer信息参数
    public function getStudentAnswerForm($insertFlag) {
        $studentAnswer = [
            'answerId'=> input("studentAnswer_answerId"), //学生答案id
            'paperObj'=> input("studentAnswer_paperObj_paperId"), //测试试卷
            'subjectObj'=> input("studentAnswer_subjectObj_subjectId"), //考试题目
            'studentOption'=> input("studentAnswer_studentOption"), //学生答案
            'studentObj'=> input("studentAnswer_studentObj_user_name"), //测试学生
            'examTime'=> input("studentAnswer_examTime"), //考试时间
        ];
        return $studentAnswer;
    }

    //接收提交的Score信息参数
    public function getScoreForm($insertFlag) {
        $score = [
            'scoreId'=> input("score_scoreId"), //成绩id
            'studentObj'=> input("score_studentObj_user_name"), //考试学生
            'paperObj'=> input("score_paperObj_paperId"), //测试试卷
            'chengji'=> input("score_chengji"), //考试成绩
            'examTime'=> input("score_examTime"), //考试时间
        ];
        return $score;
    }

    //接收提交的Question信息参数
    public function getQuestionForm($insertFlag) {
        $question = [
            'questionId'=> input("question_questionId"), //问题id
            'questionTitle'=> input("question_questionTitle"), //提问标题
            'questionContent'=> input("question_questionContent"), //提问内容
            'userObj'=> input("question_userObj_user_name"), //提问学生
            'questionTime'=> input("question_questionTime"), //提问时间
            'replyContent'=> input("question_replyContent"), //答疑回复
            'replyTime'=> input("question_replyTime"), //答疑时间
        ];
        return $question;
    }

    //接收提交的Homework信息参数
    public function getHomeworkForm($insertFlag) {
        $homework = [
            'homeworkId'=> input("homework_homeworkId"), //作业id
            'taskTitle'=> input("homework_taskTitle"), //作业任务
            'taskContent'=> input("homework_taskContent"), //作业要求
            'teacherObj'=> input("homework_teacherObj_teacherNo"), //布置的老师
            'homeworkDate'=> input("homework_homeworkDate"), //作业日期
        ];
        return $homework;
    }

    //接收提交的Notice信息参数
    public function getNoticeForm($insertFlag) {
        $notice = [
            'noticeId'=> input("notice_noticeId"), //公告id
            'title'=> input("notice_title"), //标题
            'content'=> input("notice_content"), //公告内容
            'publishDate'=> input("notice_publishDate"), //发布时间
        ];
        return $notice;
    }

}

