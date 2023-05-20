<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\StudentModel;
use app\common\model\QuestionModel;

class Question extends BackBase {
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
    public function add(){
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
            return view('question/question_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("questionId",input("questionId"));
        return view("question/question_modify");
    }

    /*ajax方式按照查询条件分页查询问题答疑信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->questionModel->setRows($this->request->param("rows"));
            $questionTitle = input("questionTitle")==null?"":input("questionTitle");
            $userObj["user_name"] = input("userObj_user_name")==null?"":input("userObj_user_name");
            $questionTime = input("questionTime")==null?"":input("questionTime");
            $questionRs = $this->questionModel->queryQuestion($questionTitle, $userObj, $questionTime, $this->currentPage);
            $expTableData = [];
            foreach($questionRs as $questionRow) {
                $questionRow["userObj"] = $this->studentModel->getStudent($questionRow["userObj"])["name"];
                $expTableData[] = $questionRow;
            }
            $data["rows"] = $questionRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->questionModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("question/question_query");
        }
    }

    /*ajax方式查询问题答疑信息*/
    public function listAll() {
        $questionRs = $this->questionModel->queryAllQuestion();
        echo json_encode($questionRs);
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

    /*按照查询条件导出问题答疑信息到Excel*/
    public function outToExcel() {
        $questionTitle = input("questionTitle")==null?"":input("questionTitle");
        $userObj["user_name"] = input("userObj_user_name")==null?"":input("userObj_user_name");
        $questionTime = input("questionTime")==null?"":input("questionTime");
        $questionRs = $this->questionModel->queryOutputQuestion($questionTitle,$userObj,$questionTime);
        $expTableData = [];
        foreach($questionRs as $questionRow) {
            $questionRow["userObj"] = $this->studentModel->getStudent($questionRow["userObj"])["name"];
            $expTableData[] = $questionRow;
        }
        $xlsName = "Question";
        $xlsCell = array(
            array('questionId','问题id','int'),
            array('questionTitle','提问标题','string'),
            array('userObj','提问学生','string'),
            array('questionTime','提问时间','string'),
            array('replyContent','答疑回复','string'),
            array('replyTime','答疑时间','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

