<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\PaperModel;
use app\common\model\SubjectModel;
use app\common\model\PaperSubjectModel;

class PaperSubject extends BackBase {
    protected $paperModel;
    protected $subjectModel;
    protected $paperSubjectModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->paperModel = new PaperModel();
        $this->subjectModel = new SubjectModel();
        $this->paperSubjectModel = new PaperSubjectModel();
    }

    /*添加试卷题目信息*/
    public function add(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $paperSubject = $this->getPaperSubjectForm(true);
            try {
                $paperObj['paperId'] = $paperSubject["paperObj"];
                $subjectObj['subjectId'] = $paperSubject["subjectObj"];
                if(count($this->paperSubjectModel->queryOutputPaperSubject($paperObj,$subjectObj,"")) > 0) {
                    $message = "试卷题目已经登记过!";
                    $this->writeJsonResponse($success,$message);
                    return;
                }
                $this->paperSubjectModel->addPaperSubject($paperSubject);
                $message = "试卷题目添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "试卷题目添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return view('paperSubject/paperSubject_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("psId",input("psId"));
        return view("paperSubject/paperSubject_modify");
    }

    /*ajax方式按照查询条件分页查询试卷题目信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->paperSubjectModel->setRows($this->request->param("rows"));
            $paperObj["paperId"] = input("paperObj_paperId")==null?0:input("paperObj_paperId");
            $subjectObj["subjectId"] = input("subjectObj_subjectId")==null?0:input("subjectObj_subjectId");
            $addTime = input("addTime")==null?"":input("addTime");
            $paperSubjectRs = $this->paperSubjectModel->queryPaperSubject($paperObj, $subjectObj, $addTime, $this->currentPage);
            $expTableData = [];
            foreach($paperSubjectRs as $paperSubjectRow) {
                $paperSubjectRow["paperObj"] = $this->paperModel->getPaper($paperSubjectRow["paperObj"])["paperName"];
                $paperSubjectRow["subjectObj"] = $this->subjectModel->getSubject($paperSubjectRow["subjectObj"])["title"];
                $expTableData[] = $paperSubjectRow;
            }
            $data["rows"] = $paperSubjectRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->paperSubjectModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("paperSubject/paperSubject_query");
        }
    }

    /*ajax方式查询试卷题目信息*/
    public function listAll() {
        $paperSubjectRs = $this->paperSubjectModel->queryAllPaperSubject();
        echo json_encode($paperSubjectRs);
    }
    /*更新试卷题目信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $paperSubject = $this->getPaperSubjectForm(false);
            try {
                $this->paperSubjectModel->updatePaperSubject($paperSubject);
                $message = "试卷题目更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "试卷题目更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取试卷题目对象*/
            $psId = input("psId");
            $paperSubject = $this->paperSubjectModel->getPaperSubject($psId);
            echo json_encode($paperSubject);
        }
    }

    /*删除多条试卷题目记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $psIds = input("psIds");
        try {
            $count = $this->paperSubjectModel->deletePaperSubjects($psIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

    /*按照查询条件导出试卷题目信息到Excel*/
    public function outToExcel() {
        $paperObj["paperId"] = input("paperObj_paperId")==null?0:input("paperObj_paperId");
        $subjectObj["subjectId"] = input("subjectObj_subjectId")==null?0:input("subjectObj_subjectId");
        $addTime = input("addTime")==null?"":input("addTime");
        $paperSubjectRs = $this->paperSubjectModel->queryOutputPaperSubject($paperObj,$subjectObj,$addTime);
        $expTableData = [];
        foreach($paperSubjectRs as $paperSubjectRow) {
            $paperSubjectRow["paperObj"] = $this->paperModel->getPaper($paperSubjectRow["paperObj"])["paperName"];
            $paperSubjectRow["subjectObj"] = $this->subjectModel->getSubject($paperSubjectRow["subjectObj"])["title"];
            $expTableData[] = $paperSubjectRow;
        }
        $xlsName = "PaperSubject";
        $xlsCell = array(
            array('psId','试卷题目id','int'),
            array('paperObj','测试试卷','string'),
            array('subjectObj','题库题目','string'),
            array('addTime','添加时间','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

