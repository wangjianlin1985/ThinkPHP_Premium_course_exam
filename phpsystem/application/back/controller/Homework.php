<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\TeacherModel;
use app\common\model\HomeworkModel;

class Homework extends BackBase {
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
    public function add(){
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
            return view('homework/homework_add');
        }
    }


    /*添加家庭作业信息*/
    public function teacherAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $homework = $this->getHomeworkForm(true);
            try {
                $homework["teacherObj"] = session("username");
                $this->homeworkModel->addHomework($homework);
                $message = "家庭作业添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "家庭作业添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return view('homework/homework_teacherAdd');
        }
    }


    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("homeworkId",input("homeworkId"));
        return view("homework/homework_modify");
    }

    /*ajax方式按照查询条件分页查询家庭作业信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->homeworkModel->setRows($this->request->param("rows"));
            $taskTitle = input("taskTitle")==null?"":input("taskTitle");
            $teacherObj["teacherNo"] = input("teacherObj_teacherNo")==null?"":input("teacherObj_teacherNo");
            $homeworkDate = input("homeworkDate")==null?"":input("homeworkDate");
            $homeworkRs = $this->homeworkModel->queryHomework($taskTitle, $teacherObj, $homeworkDate, $this->currentPage);
            $expTableData = [];
            foreach($homeworkRs as $homeworkRow) {
                $homeworkRow["teacherObj"] = $this->teacherModel->getTeacher($homeworkRow["teacherObj"])["teacherName"];
                $expTableData[] = $homeworkRow;
            }
            $data["rows"] = $homeworkRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->homeworkModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("homework/homework_query");
        }
    }


    /*ajax方式按照查询条件分页查询家庭作业信息*/
    public function teacherBackList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->homeworkModel->setRows($this->request->param("rows"));
            $taskTitle = input("taskTitle")==null?"":input("taskTitle");
            $teacherObj["teacherNo"] = session("username");
            $homeworkDate = input("homeworkDate")==null?"":input("homeworkDate");
            $homeworkRs = $this->homeworkModel->queryHomework($taskTitle, $teacherObj, $homeworkDate, $this->currentPage);
            $expTableData = [];
            foreach($homeworkRs as $homeworkRow) {
                $homeworkRow["teacherObj"] = $this->teacherModel->getTeacher($homeworkRow["teacherObj"])["teacherName"];
                $expTableData[] = $homeworkRow;
            }
            $data["rows"] = $homeworkRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->homeworkModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("homework/homework_teacher_query");
        }
    }


    /*ajax方式查询家庭作业信息*/
    public function listAll() {
        $homeworkRs = $this->homeworkModel->queryAllHomework();
        echo json_encode($homeworkRs);
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

    /*按照查询条件导出家庭作业信息到Excel*/
    public function outToExcel() {
        $taskTitle = input("taskTitle")==null?"":input("taskTitle");
        $teacherObj["teacherNo"] = input("teacherObj_teacherNo")==null?"":input("teacherObj_teacherNo");
        $homeworkDate = input("homeworkDate")==null?"":input("homeworkDate");
        $homeworkRs = $this->homeworkModel->queryOutputHomework($taskTitle,$teacherObj,$homeworkDate);
        $expTableData = [];
        foreach($homeworkRs as $homeworkRow) {
            $homeworkRow["teacherObj"] = $this->teacherModel->getTeacher($homeworkRow["teacherObj"])["teacherName"];
            $expTableData[] = $homeworkRow;
        }
        $xlsName = "Homework";
        $xlsCell = array(
            array('homeworkId','作业id','int'),
            array('taskTitle','作业任务','string'),
            array('teacherObj','布置的老师','string'),
            array('homeworkDate','作业日期','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

