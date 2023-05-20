<?php
namespace app\front\controller;
use app\common\model\PaperSubjectModel;
use app\common\model\ScoreModel;
use think\Request;
use think\Exception;
use app\common\model\PaperModel;
use app\common\model\StudentModel;
use app\common\model\SubjectModel;
use app\common\model\StudentAnswerModel;

class StudentAnswer extends Base {
    protected $paperModel;
    protected $studentModel;
    protected $subjectModel;
    protected $studentAnswerModel;
    protected $paperSubjectModel;
    protected $scoreModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->paperModel = new PaperModel();
        $this->studentModel = new StudentModel();
        $this->subjectModel = new SubjectModel();
        $this->studentAnswerModel = new StudentAnswerModel();
        $this->paperSubjectModel = new PaperSubjectModel();
        $this->scoreModel = new ScoreModel();
    }

    /*添加学生答案信息*/
    public function frontAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $studentAnswer = $this->getStudentAnswerForm(true);
            try {
                $this->studentAnswerModel->addStudentAnswer($studentAnswer);
                $message = "学生答案添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "学生答案添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('studentAnswer/studentAnswer_frontAdd');
        }
    }


    /*前台学生提交考试答案*/
    public function submitAnswer(){

        $chengji = 0.0;
        $studentNumber = session("user_name");
        $examTime = date('Y-m-d H:i:s');
        $paperId = input("paperId");
        $paperObj['paperId'] = $paperId;
        //$subjectObj['subjectId'] = 0;
        $psList = $this->paperSubjectModel->queryOutputPaperSubject($paperObj,null,"");
        foreach ($psList as $ps) {
            $subjectId = $ps["subjectObj"];
            //echo input("s_".$subjectId);

            $subject = $this->subjectModel->getSubject($subjectId);
            $studentAnswer = [
                'paperObj'=> $paperId, //测试试卷
                'subjectObj'=> $ps["subjectObj"], //考试题目
                'studentOption'=> input("s_".$subjectId), //学生答案
                'studentObj'=> $studentNumber, //测试学生
                'examTime'=> $examTime, //考试时间
            ];
            $this->studentAnswerModel->addStudentAnswer($studentAnswer);

            if($studentAnswer["studentOption"] == $subject["rightOption"]) {
                $chengji += $subject["score"];
            }
        }

        $score = [
            'studentObj'=> $studentNumber, //考试学生
            'paperObj'=> $paperId, //测试试卷
            'chengji'=> $chengji, //考试成绩
            'examTime'=> $examTime, //考试时间
        ];

        $this->scoreModel->addScore($score);

        $this->success("考试完毕","Score/frontlist");




    }



    /*前台修改学生答案信息*/
    public function frontModify() {
        $this->assign("answerId",input("answerId"));
        return $this->fetch("studentAnswer/studentAnswer_frontModify");
    }

    /*前台按照查询条件分页查询学生答案信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $paperObj["paperId"] = input("paperObj_paperId")==null?0:input("paperObj_paperId");
        $subjectObj["subjectId"] = input("subjectObj_subjectId")==null?0:input("subjectObj_subjectId");
        $studentObj["user_name"] = input("studentObj_user_name")==null?"":input("studentObj_user_name");
        $examTime = input("examTime")==null?"":input("examTime");
        $studentAnswerRs = $this->studentAnswerModel->queryStudentAnswer($paperObj, $subjectObj, $studentObj, $examTime, $this->currentPage);
        $this->assign("studentAnswerRs",$studentAnswerRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->studentAnswerModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->studentAnswerModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->studentAnswerModel->rows);
        $this->assign("paperObj",$paperObj);
        $this->assign("paperList",$this->paperModel->queryAllPaper());
        $this->assign("subjectObj",$subjectObj);
        $this->assign("subjectList",$this->subjectModel->queryAllSubject());
        $this->assign("studentObj",$studentObj);
        $this->assign("studentList",$this->studentModel->queryAllStudent());
        $this->assign("examTime",$examTime);
        return $this->fetch('studentAnswer/studentAnswer_frontlist');
    }

    /*ajax方式查询学生答案信息*/
    public function listAll() {
        $studentAnswerRs = $this->studentAnswerModel->queryAllStudentAnswer();
        echo json_encode($studentAnswerRs);
    }
    /*前台查询根据主键查询一条学生答案信息*/
    public function frontshow() {
        $answerId = input("answerId");
        $studentAnswer = $this->studentAnswerModel->getStudentAnswer($answerId);
       $this->assign("studentAnswer",$studentAnswer);
        return $this->fetch("studentAnswer/studentAnswer_frontshow");
    }

    /*更新学生答案信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $studentAnswer = $this->getStudentAnswerForm(false);
            try {
                $this->studentAnswerModel->updateStudentAnswer($studentAnswer);
                $message = "学生答案更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "学生答案更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取学生答案对象*/
            $answerId = input("answerId");
            $studentAnswer = $this->studentAnswerModel->getStudentAnswer($answerId);
            echo json_encode($studentAnswer);
        }
    }

    /*删除多条学生答案记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $answerIds = input("answerIds");
        try {
            $count = $this->studentAnswerModel->deleteStudentAnswers($answerIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

}

