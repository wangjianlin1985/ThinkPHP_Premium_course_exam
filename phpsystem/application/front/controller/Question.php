<?php
namespace app\front\controller;
use think\Request;
use think\Exception;
use app\common\model\StudentModel;
use app\common\model\QuestionModel;

class Question extends Base {
    protected $studentModel;
    protected $questionModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->studentModel = new StudentModel();
        $this->questionModel = new QuestionModel();
    }

    /*添加问题答疑信息*/
    public function frontAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $question = $this->getQuestionForm(true);
            try {
                $this->questionModel->addQuestion($question);
                $message = "问题答疑添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "问题答疑添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('question/question_frontAdd');
        }
    }

    /*添加问题答疑信息*/
    public function frontStudentAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $question = $this->getQuestionForm(true);
            try {
                $question["userObj"] = session("user_name");
                $question["questionTime"] = date('Y-m-d H:i:s');
                $this->questionModel->addQuestion($question);
                $message = "问题答疑添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "问题答疑添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('question/question_frontStudentAdd');
        }
    }


    /*前台修改问题答疑信息*/
    public function frontModify() {
        $this->assign("questionId",input("questionId"));
        return $this->fetch("question/question_frontModify");
    }

    /*前台按照查询条件分页查询问题答疑信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $questionTitle = input("questionTitle")==null?"":input("questionTitle");
        $userObj["user_name"] = input("userObj_user_name")==null?"":input("userObj_user_name");
        $questionTime = input("questionTime")==null?"":input("questionTime");
        $questionRs = $this->questionModel->queryQuestion($questionTitle, $userObj, $questionTime, $this->currentPage);
        $this->assign("questionRs",$questionRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->questionModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->questionModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->questionModel->rows);
        $this->assign("questionTitle",$questionTitle);
        $this->assign("userObj",$userObj);
        $this->assign("studentList",$this->studentModel->queryAllStudent());
        $this->assign("questionTime",$questionTime);
        return $this->fetch('question/question_frontlist');
    }


    /*前台按照查询条件分页查询问题答疑信息*/
    public function studentFrontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $questionTitle = input("questionTitle")==null?"":input("questionTitle");
        $userObj["user_name"] = session("user_name");
        $questionTime = input("questionTime")==null?"":input("questionTime");
        $questionRs = $this->questionModel->queryQuestion($questionTitle, $userObj, $questionTime, $this->currentPage);
        $this->assign("questionRs",$questionRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->questionModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->questionModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->questionModel->rows);
        $this->assign("questionTitle",$questionTitle);
        $this->assign("userObj",$userObj);
        $this->assign("studentList",$this->studentModel->queryAllStudent());
        $this->assign("questionTime",$questionTime);
        return $this->fetch('question/question_studentFrontlist');
    }



    /*ajax方式查询问题答疑信息*/
    public function listAll() {
        $questionRs = $this->questionModel->queryAllQuestion();
        echo json_encode($questionRs);
    }
    /*前台查询根据主键查询一条问题答疑信息*/
    public function frontshow() {
        $questionId = input("questionId");
        $question = $this->questionModel->getQuestion($questionId);
       $this->assign("question",$question);
        return $this->fetch("question/question_frontshow");
    }

    /*更新问题答疑信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $question = $this->getQuestionForm(false);
            try {
                $this->questionModel->updateQuestion($question);
                $message = "问题答疑更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "问题答疑更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取问题答疑对象*/
            $questionId = input("questionId");
            $question = $this->questionModel->getQuestion($questionId);
            echo json_encode($question);
        }
    }

    /*删除多条问题答疑记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $questionIds = input("questionIds");
        try {
            $count = $this->questionModel->deleteQuestions($questionIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

}

