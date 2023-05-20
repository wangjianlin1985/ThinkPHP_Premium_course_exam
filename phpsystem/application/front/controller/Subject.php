<?php
namespace app\front\controller;
use think\Request;
use think\Exception;
use app\common\model\SubjectModel;

class Subject extends Base {
    protected $subjectModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->subjectModel = new SubjectModel();
    }

    /*添加题库题目信息*/
    public function frontAdd(){
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
            return $this->fetch('subject/subject_frontAdd');
        }
    }

    /*前台修改题库题目信息*/
    public function frontModify() {
        $this->assign("subjectId",input("subjectId"));
        return $this->fetch("subject/subject_frontModify");
    }

    /*前台按照查询条件分页查询题库题目信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $title = input("title")==null?"":input("title");
        $subjectRs = $this->subjectModel->querySubject($title, $this->currentPage);
        $this->assign("subjectRs",$subjectRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->subjectModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->subjectModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->subjectModel->rows);
        $this->assign("title",$title);
        return $this->fetch('subject/subject_frontlist');
    }

    /*ajax方式查询题库题目信息*/
    public function listAll() {
        $subjectRs = $this->subjectModel->queryAllSubject();
        echo json_encode($subjectRs);
    }
    /*前台查询根据主键查询一条题库题目信息*/
    public function frontshow() {
        $subjectId = input("subjectId");
        $subject = $this->subjectModel->getSubject($subjectId);
       $this->assign("subject",$subject);
        return $this->fetch("subject/subject_frontshow");
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

}

