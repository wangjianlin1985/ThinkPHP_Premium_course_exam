<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\TeacherModel;
use app\common\model\KejianModel;

class Kejian extends BackBase {
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
    public function add(){
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
            return view('kejian/kejian_add');
        }
    }


    /*添加课件信息*/
    public function teacherAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $kejian = $this->getKejianForm(true);
            $this->uploadFile($kejian,"kejianFile","kejianFileFile"); //处理课件文件上传
            try {
                $kejian["teacherObj"] = session("username");
                $this->kejianModel->addKejian($kejian);
                $message = "课件添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "课件添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return view('kejian/kejian_teacherAdd');
        }
    }


    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("kejianId",input("kejianId"));
        return view("kejian/kejian_modify");
    }

    /*ajax方式按照查询条件分页查询课件信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->kejianModel->setRows($this->request->param("rows"));
            $title = input("title")==null?"":input("title");
            $teacherObj["teacherNo"] = input("teacherObj_teacherNo")==null?"":input("teacherObj_teacherNo");
            $addTime = input("addTime")==null?"":input("addTime");
            $kejianRs = $this->kejianModel->queryKejian($title, $teacherObj, $addTime, $this->currentPage);
            $expTableData = [];
            foreach($kejianRs as $kejianRow) {
                $kejianRow["teacherObj"] = $this->teacherModel->getTeacher($kejianRow["teacherObj"])["teacherName"];
                $expTableData[] = $kejianRow;
            }
            $data["rows"] = $kejianRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->kejianModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("kejian/kejian_query");
        }
    }


    /*ajax方式按照查询条件分页查询课件信息*/
    public function teacherBackList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->kejianModel->setRows($this->request->param("rows"));
            $title = input("title")==null?"":input("title");
            $teacherObj["teacherNo"] = session("username");
            $addTime = input("addTime")==null?"":input("addTime");
            $kejianRs = $this->kejianModel->queryKejian($title, $teacherObj, $addTime, $this->currentPage);
            $expTableData = [];
            foreach($kejianRs as $kejianRow) {
                $kejianRow["teacherObj"] = $this->teacherModel->getTeacher($kejianRow["teacherObj"])["teacherName"];
                $expTableData[] = $kejianRow;
            }
            $data["rows"] = $kejianRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->kejianModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("kejian/kejian_teacher_query");
        }
    }



    /*ajax方式查询课件信息*/
    public function listAll() {
        $kejianRs = $this->kejianModel->queryAllKejian();
        echo json_encode($kejianRs);
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

    /*按照查询条件导出课件信息到Excel*/
    public function outToExcel() {
        $title = input("title")==null?"":input("title");
        $teacherObj["teacherNo"] = input("teacherObj_teacherNo")==null?"":input("teacherObj_teacherNo");
        $addTime = input("addTime")==null?"":input("addTime");
        $kejianRs = $this->kejianModel->queryOutputKejian($title,$teacherObj,$addTime);
        $expTableData = [];
        foreach($kejianRs as $kejianRow) {
            $kejianRow["teacherObj"] = $this->teacherModel->getTeacher($kejianRow["teacherObj"])["teacherName"];
            $expTableData[] = $kejianRow;
        }
        $xlsName = "Kejian";
        $xlsCell = array(
            array('kejianId','课件id','int'),
            array('title','课件标题','string'),
            array('teacherObj','发布老师','string'),
            array('addTime','发布时间','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

