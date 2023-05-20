<?php
namespace app\front\controller;
use think\Request;
use think\Exception;
use app\common\model\TeacherModel;
use app\common\model\HomeworkModel;

class Homework extends Base {
    protected $teacherModel;
    protected $homeworkModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->teacherModel = new TeacherModel();
        $this->homeworkModel = new HomeworkModel();
    }

    /*添加家庭作业信息*/
    public function frontAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $homework = $this->getHomeworkForm(true);
            try {
                $this->homeworkModel->addHomework($homework);
                $message = "家庭作业添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "家庭作业添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('homework/homework_frontAdd');
        }
    }

    /*前台修改家庭作业信息*/
    public function frontModify() {
        $this->assign("homeworkId",input("homeworkId"));
        return $this->fetch("homework/homework_frontModify");
    }

    /*前台按照查询条件分页查询家庭作业信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $taskTitle = input("taskTitle")==null?"":input("taskTitle");
        $teacherObj["teacherNo"] = input("teacherObj_teacherNo")==null?"":input("teacherObj_teacherNo");
        $homeworkDate = input("homeworkDate")==null?"":input("homeworkDate");
        $homeworkRs = $this->homeworkModel->queryHomework($taskTitle, $teacherObj, $homeworkDate, $this->currentPage);
        $this->assign("homeworkRs",$homeworkRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->homeworkModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->homeworkModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->homeworkModel->rows);
        $this->assign("taskTitle",$taskTitle);
        $this->assign("teacherObj",$teacherObj);
        $this->assign("teacherList",$this->teacherModel->queryAllTeacher());
        $this->assign("homeworkDate",$homeworkDate);
        return $this->fetch('homework/homework_frontlist');
    }

    /*ajax方式查询家庭作业信息*/
    public function listAll() {
        $homeworkRs = $this->homeworkModel->queryAllHomework();
        echo json_encode($homeworkRs);
    }
    /*前台查询根据主键查询一条家庭作业信息*/
    public function frontshow() {
        $homeworkId = input("homeworkId");
        $homework = $this->homeworkModel->getHomework($homeworkId);
       $this->assign("homework",$homework);
        return $this->fetch("homework/homework_frontshow");
    }

    /*更新家庭作业信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $homework = $this->getHomeworkForm(false);
            try {
                $this->homeworkModel->updateHomework($homework);
                $message = "家庭作业更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "家庭作业更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取家庭作业对象*/
            $homeworkId = input("homeworkId");
            $homework = $this->homeworkModel->getHomework($homeworkId);
            echo json_encode($homework);
        }
    }

    /*删除多条家庭作业记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $homeworkIds = input("homeworkIds");
        try {
            $count = $this->homeworkModel->deleteHomeworks($homeworkIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

}

