<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\SubjectModel;

class Subject extends BackBase {
    protected $subjectModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->subjectModel = new SubjectModel();
    }

    /*添加题库题目信息*/
    public function add(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $subject = $this->getSubjectForm(true);
            try {
                $this->subjectModel->addSubject($subject);
                $message = "题库题目添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "题库题目添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return view('subject/subject_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("subjectId",input("subjectId"));
        return view("subject/subject_modify");
    }

    /*ajax方式按照查询条件分页查询题库题目信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->subjectModel->setRows($this->request->param("rows"));
            $title = input("title")==null?"":input("title");
            $subjectRs = $this->subjectModel->querySubject($title, $this->currentPage);
            $expTableData = [];
            foreach($subjectRs as $subjectRow) {
                $expTableData[] = $subjectRow;
            }
            $data["rows"] = $subjectRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->subjectModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("subject/subject_query");
        }
    }

    /*ajax方式查询题库题目信息*/
    public function listAll() {
        $subjectRs = $this->subjectModel->queryAllSubject();
        echo json_encode($subjectRs);
    }
    /*更新题库题目信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $subject = $this->getSubjectForm(false);
            try {
                $this->subjectModel->updateSubject($subject);
                $message = "题库题目更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "题库题目更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取题库题目对象*/
            $subjectId = input("subjectId");
            $subject = $this->subjectModel->getSubject($subjectId);
            echo json_encode($subject);
        }
    }

    /*删除多条题库题目记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $subjectIds = input("subjectIds");
        try {
            $count = $this->subjectModel->deleteSubjects($subjectIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

    /*按照查询条件导出题库题目信息到Excel*/
    public function outToExcel() {
        $title = input("title")==null?"":input("title");
        $subjectRs = $this->subjectModel->queryOutputSubject($title);
        $expTableData = [];
        foreach($subjectRs as $subjectRow) {
            $expTableData[] = $subjectRow;
        }
        $xlsName = "Subject";
        $xlsCell = array(
            array('subjectId','题目id','int'),
            array('title','题目标题','string'),
            array('a_option','A','string'),
            array('b_option','B','string'),
            array('c_option','C','string'),
            array('d_option','D','string'),
            array('rightOption','正确答案','string'),
            array('score','得分','float'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

