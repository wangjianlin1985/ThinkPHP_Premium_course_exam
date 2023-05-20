<?php
namespace app\front\controller;
use app\common\model\PaperSubjectModel;
use app\common\model\ScoreModel;
use app\common\model\SubjectModel;
use think\Request;
use think\Exception;
use app\common\model\PaperModel;

class Paper extends Base {
    protected $paperModel;
    protected $scoreModel;
    protected $paperSubjectModel;
    protected $subjectModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->paperModel = new PaperModel();
        $this->scoreModel = new ScoreModel();
        $this->paperSubjectModel = new PaperSubjectModel();
        $this->subjectModel = new SubjectModel();
    }

    /*添加测试试卷信息*/
    public function frontAdd(){
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
            return $this->fetch('paper/paper_frontAdd');
        }
    }

    /*前台修改测试试卷信息*/
    public function frontModify() {
        $this->assign("paperId",input("paperId"));
        return $this->fetch("paper/paper_frontModify");
    }

    /*前台按照查询条件分页查询测试试卷信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $paperName = input("paperName")==null?"":input("paperName");
        $paperRs = $this->paperModel->queryPaper($paperName, $this->currentPage);
        $this->assign("paperRs",$paperRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->paperModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->paperModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->paperModel->rows);
        $this->assign("paperName",$paperName);
        return $this->fetch('paper/paper_frontlist');
    }

    /*ajax方式查询测试试卷信息*/
    public function listAll() {
        $paperRs = $this->paperModel->queryAllPaper();
        echo json_encode($paperRs);
    }
    /*前台查询根据主键查询一条测试试卷信息*/
    public function frontshow() {
        if(session("user_name") == null) {
            $this->error("请先登录","Index/index");
            return;
        }
        $paperId = input("paperId");
        $studentObj['user_name'] = session("user_name");
        $paperObj['paperId'] = $paperId;

        if(count($this->scoreModel->queryOutputScore($studentObj,$paperObj,"")) > 0) {
            $this->error("你已经参加过此门考试了！");
            return;
        }

        //查询这门测试试卷下面的所有题目信息
        $paperObj['paperId'] = $paperId;
        //$subjectObj['subjectId'] = 0;
        $paperSubjectRs = $this->paperSubjectModel->queryOutputPaperSubject($paperObj,null,"");
        $subjects = [];
        foreach($paperSubjectRs as $paperSubject) {
            $subjectId = $paperSubject["subjectObj"];
            $subjects[] = $this->subjectModel->getSubject($subjectId);
        }
        $paper = $this->paperModel->getPaper($paperId);
        $this->assign("paper",$paper);
        $this->assign("subjects",$subjects);
        return $this->fetch("paper/paper_frontshow");
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

}

