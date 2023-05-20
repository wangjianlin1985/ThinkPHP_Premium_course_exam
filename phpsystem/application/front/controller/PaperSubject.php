<?php
namespace app\front\controller;
use think\Request;
use think\Exception;
use app\common\model\PaperModel;
use app\common\model\SubjectModel;
use app\common\model\PaperSubjectModel;

class PaperSubject extends Base {
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
    public function frontAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $paperSubject = $this->getPaperSubjectForm(true);
            try {
                $this->paperSubjectModel->addPaperSubject($paperSubject);
                $message = "试卷题目添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "试卷题目添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('paperSubject/paperSubject_frontAdd');
        }
    }

    /*前台修改试卷题目信息*/
    public function frontModify() {
        $this->assign("psId",input("psId"));
        return $this->fetch("paperSubject/paperSubject_frontModify");
    }

    /*前台按照查询条件分页查询试卷题目信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $paperObj["paperId"] = input("paperObj_paperId")==null?0:input("paperObj_paperId");
        $subjectObj["subjectId"] = input("subjectObj_subjectId")==null?0:input("subjectObj_subjectId");
        $addTime = input("addTime")==null?"":input("addTime");
        $paperSubjectRs = $this->paperSubjectModel->queryPaperSubject($paperObj, $subjectObj, $addTime, $this->currentPage);
        $this->assign("paperSubjectRs",$paperSubjectRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->paperSubjectModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->paperSubjectModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->paperSubjectModel->rows);
        $this->assign("paperObj",$paperObj);
        $this->assign("paperList",$this->paperModel->queryAllPaper());
        $this->assign("subjectObj",$subjectObj);
        $this->assign("subjectList",$this->subjectModel->queryAllSubject());
        $this->assign("addTime",$addTime);
        return $this->fetch('paperSubject/paperSubject_frontlist');
    }

    /*ajax方式查询试卷题目信息*/
    public function listAll() {
        $paperSubjectRs = $this->paperSubjectModel->queryAllPaperSubject();
        echo json_encode($paperSubjectRs);
    }
    /*前台查询根据主键查询一条试卷题目信息*/
    public function frontshow() {
        $psId = input("psId");
        $paperSubject = $this->paperSubjectModel->getPaperSubject($psId);
       $this->assign("paperSubject",$paperSubject);
        return $this->fetch("paperSubject/paperSubject_frontshow");
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

}

