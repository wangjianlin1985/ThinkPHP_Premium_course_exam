<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\PaperModel;

class Paper extends BackBase {
    protected $paperModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->paperModel = new PaperModel();
    }

    /*添加测试试卷信息*/
    public function add(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $paper = $this->getPaperForm(true);
            try {
                $this->paperModel->addPaper($paper);
                $message = "测试试卷添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "测试试卷添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return view('paper/paper_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("paperId",input("paperId"));
        return view("paper/paper_modify");
    }

    /*ajax方式按照查询条件分页查询测试试卷信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->paperModel->setRows($this->request->param("rows"));
            $paperName = input("paperName")==null?"":input("paperName");
            $paperRs = $this->paperModel->queryPaper($paperName, $this->currentPage);
            $expTableData = [];
            foreach($paperRs as $paperRow) {
                $expTableData[] = $paperRow;
            }
            $data["rows"] = $paperRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->paperModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("paper/paper_query");
        }
    }

    /*ajax方式查询测试试卷信息*/
    public function listAll() {
        $paperRs = $this->paperModel->queryAllPaper();
        echo json_encode($paperRs);
    }
    /*更新测试试卷信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $paper = $this->getPaperForm(false);
            try {
                $this->paperModel->updatePaper($paper);
                $message = "测试试卷更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "测试试卷更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取测试试卷对象*/
            $paperId = input("paperId");
            $paper = $this->paperModel->getPaper($paperId);
            echo json_encode($paper);
        }
    }

    /*删除多条测试试卷记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $paperIds = input("paperIds");
        try {
            $count = $this->paperModel->deletePapers($paperIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

    /*按照查询条件导出测试试卷信息到Excel*/
    public function outToExcel() {
        $paperName = input("paperName")==null?"":input("paperName");
        $paperRs = $this->paperModel->queryOutputPaper($paperName);
        $expTableData = [];
        foreach($paperRs as $paperRow) {
            $expTableData[] = $paperRow;
        }
        $xlsName = "Paper";
        $xlsCell = array(
            array('paperId','试卷id','int'),
            array('paperName','试卷名称','string'),
            array('examTime','考试时间(分钟)','int'),
            array('totalScore','试卷满分','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

