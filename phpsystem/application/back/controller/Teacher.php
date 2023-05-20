<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\TeacherModel;

class Teacher extends BackBase {
    protected $teacherModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->teacherModel = new TeacherModel();
    }

    /*添加教师信息*/
    public function add(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $teacher = $this->getTeacherForm(true);
            $this->uploadPhoto($teacher,"teacherPhoto","teacherPhotoFile"); //处理教师照片上传
            try {
                $this->teacherModel->addTeacher($teacher);
                $message = "教师添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "教师添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return view('teacher/teacher_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("teacherNo",session("username"));
        return view("teacher/teacher_modify");
    }

    /*ajax方式按照查询条件分页查询教师信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->teacherModel->setRows($this->request->param("rows"));
            $teacherNo = input("teacherNo")==null?"":input("teacherNo");
            $teacherName = input("teacherName")==null?"":input("teacherName");
            $comeDate = input("comeDate")==null?"":input("comeDate");
            $teacherRs = $this->teacherModel->queryTeacher($teacherNo, $teacherName, $comeDate, $this->currentPage);
            $expTableData = [];
            foreach($teacherRs as $teacherRow) {
                $expTableData[] = $teacherRow;
            }
            $data["rows"] = $teacherRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->teacherModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("teacher/teacher_query");
        }
    }

    /*ajax方式查询教师信息*/
    public function listAll() {
        $teacherRs = $this->teacherModel->queryAllTeacher();
        echo json_encode($teacherRs);
    }
    /*更新教师信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $teacher = $this->getTeacherForm(false);
            $this->uploadPhoto($teacher,"teacherPhoto","teacherPhotoFile"); //处理教师照片上传
            try {
                $this->teacherModel->updateTeacher($teacher);
                $message = "教师更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "教师更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取教师对象*/
            $teacherNo = input("teacherNo");
            $teacher = $this->teacherModel->getTeacher($teacherNo);
            echo json_encode($teacher);
        }
    }

    /*删除多条教师记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $teacherNos = input("teacherNos");
        try {
            $count = $this->teacherModel->deleteTeachers($teacherNos);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

    /*按照查询条件导出教师信息到Excel*/
    public function outToExcel() {
        $teacherNo = input("teacherNo")==null?"":input("teacherNo");
        $teacherName = input("teacherName")==null?"":input("teacherName");
        $comeDate = input("comeDate")==null?"":input("comeDate");
        $teacherRs = $this->teacherModel->queryOutputTeacher($teacherNo,$teacherName,$comeDate);
        $expTableData = [];
        foreach($teacherRs as $teacherRow) {
            $expTableData[] = $teacherRow;
        }
        $xlsName = "Teacher";
        $xlsCell = array(
            array('teacherNo','教师工号','string'),
            array('teacherName','教师姓名','string'),
            array('teacherSex','教师性别','string'),
            array('teacherAge','教师年龄','int'),
            array('teacherPhoto','教师照片','photo'),
            array('comeDate','入职日期','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

