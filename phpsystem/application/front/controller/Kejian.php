<?php
namespace app\front\controller;
use think\Request;
use think\Exception;
use app\common\model\TeacherModel;
use app\common\model\KejianModel;

class Kejian extends Base {
    protected $teacherModel;
    protected $kejianModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->teacherModel = new TeacherModel();
        $this->kejianModel = new KejianModel();
    }

    /*添加课件信息*/
    public function frontAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $kejian = $this->getKejianForm(true);
            $this->uploadFile($kejian,"kejianFile","kejianFileFile"); //处理课件文件上传
            try {
                $this->kejianModel->addKejian($kejian);
                $message = "课件添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "课件添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('kejian/kejian_frontAdd');
        }
    }

    /*前台修改课件信息*/
    public function frontModify() {
        $this->assign("kejianId",input("kejianId"));
        return $this->fetch("kejian/kejian_frontModify");
    }

    /*前台按照查询条件分页查询课件信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $title = input("title")==null?"":input("title");
        $teacherObj["teacherNo"] = input("teacherObj_teacherNo")==null?"":input("teacherObj_teacherNo");
        $addTime = input("addTime")==null?"":input("addTime");
        $kejianRs = $this->kejianModel->queryKejian($title, $teacherObj, $addTime, $this->currentPage);
        $this->assign("kejianRs",$kejianRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->kejianModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->kejianModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->kejianModel->rows);
        $this->assign("title",$title);
        $this->assign("teacherObj",$teacherObj);
        $this->assign("teacherList",$this->teacherModel->queryAllTeacher());
        $this->assign("addTime",$addTime);
        return $this->fetch('kejian/kejian_frontlist');
    }

    /*ajax方式查询课件信息*/
    public function listAll() {
        $kejianRs = $this->kejianModel->queryAllKejian();
        echo json_encode($kejianRs);
    }
    /*前台查询根据主键查询一条课件信息*/
    public function frontshow() {
        $kejianId = input("kejianId");
        $kejian = $this->kejianModel->getKejian($kejianId);
       $this->assign("kejian",$kejian);
        return $this->fetch("kejian/kejian_frontshow");
    }

    /*更新课件信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $kejian = $this->getKejianForm(false);
            $this->uploadFile($kejian,"kejianFile","kejianFileFile"); //处理课件文件上传
            try {
                $this->kejianModel->updateKejian($kejian);
                $message = "课件更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "课件更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取课件对象*/
            $kejianId = input("kejianId");
            $kejian = $this->kejianModel->getKejian($kejianId);
            echo json_encode($kejian);
        }
    }

    /*删除多条课件记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $kejianIds = input("kejianIds");
        try {
            $count = $this->kejianModel->deleteKejians($kejianIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

}

