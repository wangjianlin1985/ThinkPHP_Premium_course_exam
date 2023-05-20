<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\PaperModel;
use app\common\model\StudentModel;
use app\common\model\SubjectModel;
use app\common\model\StudentAnswerModel;

class StudentAnswer extends BackBase {
    protected $paperModel;
    protected $studentModel;
    protected $subjectModel;
    protected $studentAnswerModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->paperModel = new PaperModel();
        $this->studentModel = new StudentModel();
        $this->subjectModel = new SubjectModel();
        $this->studentAnswerModel = new StudentAnswerModel();
    }

    /*添加学生答案信息*/
    public function add(){
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
            return view('studentAnswer/studentAnswer_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("answerId",input("answerId"));
        return view("studentAnswer/studentAnswer_modify");
    }

    /*ajax方式按照查询条件分页查询学生答案信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->studentAnswerModel->setRows($this->request->param("rows"));
            $paperObj["paperId"] = input("paperObj_paperId")==null?0:input("paperObj_paperId");
            $subjectObj["subjectId"] = input("subjectObj_subjectId")==null?0:input("subjectObj_subjectId");
            $studentObj["user_name"] = input("studentObj_user_name")==null?"":input("studentObj_user_name");
            $examTime = input("examTime")==null?"":input("examTime");
            $studentAnswerRs = $this->studentAnswerModel->queryStudentAnswer($paperObj, $subjectObj, $studentObj, $examTime, $this->currentPage);
            $expTableData = [];
            foreach($studentAnswerRs as $studentAnswerRow) {
                $studentAnswerRow["paperObj"] = $this->paperModel->getPaper($studentAnswerRow["paperObj"])["paperName"];
                $studentAnswerRow["subjectObj"] = $this->subjectModel->getSubject($studentAnswerRow["subjectObj"])["title"];
                $studentAnswerRow["studentObj"] = $this->studentModel->getStudent($studentAnswerRow["studentObj"])["name"];
                $expTableData[] = $studentAnswerRow;
            }
            $data["rows"] = $studentAnswerRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->studentAnswerModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("studentAnswer/studentAnswer_query");
        }
    }

    /*ajax方式查询学生答案信息*/
    public function listAll() {
        $studentAnswerRs = $this->studentAnswerModel->queryAllStudentAnswer();
        echo json_encode($studentAnswerRs);
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

    /*按照查询条件导出学生答案信息到Excel*/
    public function outToExcel() {
        $paperObj["paperId"] = input("paperObj_paperId")==null?0:input("paperObj_paperId");
        $subjectObj["subjectId"] = input("subjectObj_subjectId")==null?0:input("subjectObj_subjectId");
        $studentObj["user_name"] = input("studentObj_user_name")==null?"":input("studentObj_user_name");
        $examTime = input("examTime")==null?"":input("examTime");
        $studentAnswerRs = $this->studentAnswerModel->queryOutputStudentAnswer($paperObj,$subjectObj,$studentObj,$examTime);
        $expTableData = [];
        foreach($studentAnswerRs as $studentAnswerRow) {
            $studentAnswerRow["paperObj"] = $this->paperModel->getPaper($studentAnswerRow["paperObj"])["paperName"];
            $studentAnswerRow["subjectObj"] = $this->subjectModel->getSubject($studentAnswerRow["subjectObj"])["title"];
            $studentAnswerRow["studentObj"] = $this->studentModel->getStudent($studentAnswerRow["studentObj"])["name"];
            $expTableData[] = $studentAnswerRow;
        }
        $xlsName = "StudentAnswer";
        $xlsCell = array(
            array('answerId','学生答案id','int'),
            array('paperObj','测试试卷','string'),
            array('subjectObj','考试题目','string'),
            array('studentOption','学生答案','string'),
            array('studentObj','测试学生','string'),
            array('examTime','考试时间','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

