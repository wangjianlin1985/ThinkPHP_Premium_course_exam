<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\TeacherModel;
use app\common\model\VideoModel;

class Video extends BackBase {
    protected $teacherModel;
    protected $videoModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->teacherModel = new TeacherModel();
        $this->videoModel = new VideoModel();
    }

    /*添加学习视频信息*/
    public function add(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $video = $this->getVideoForm(true);
            $this->uploadFile($video,"videoFile","videoFileFile"); //处理视频文件上传
            try {
                $this->videoModel->addVideo($video);
                $message = "学习视频添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "学习视频添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return view('video/video_add');
        }
    }


    /*添加学习视频信息*/
    public function teacherAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $video = $this->getVideoForm(true);
            $this->uploadFile($video,"videoFile","videoFileFile"); //处理视频文件上传
            try {
                $video["teacherObj"] = session("username");
                $this->videoModel->addVideo($video);
                $message = "学习视频添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "学习视频添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return view('video/video_teacherAdd');
        }
    }


    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("videoId",input("videoId"));
        return view("video/video_modify");
    }

    /*ajax方式按照查询条件分页查询学习视频信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->videoModel->setRows($this->request->param("rows"));
            $title = input("title")==null?"":input("title");
            $teacherObj["teacherNo"] = input("teacherObj_teacherNo")==null?"":input("teacherObj_teacherNo");
            $videoTime = input("videoTime")==null?"":input("videoTime");
            $videoRs = $this->videoModel->queryVideo($title, $teacherObj, $videoTime, $this->currentPage);
            $expTableData = [];
            foreach($videoRs as $videoRow) {
                $videoRow["teacherObj"] = $this->teacherModel->getTeacher($videoRow["teacherObj"])["teacherName"];
                $expTableData[] = $videoRow;
            }
            $data["rows"] = $videoRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->videoModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("video/video_query");
        }
    }


    /*ajax方式按照查询条件分页查询学习视频信息*/
    public function teacherBackList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->videoModel->setRows($this->request->param("rows"));
            $title = input("title")==null?"":input("title");
            $teacherObj["teacherNo"] = session("username");
            $videoTime = input("videoTime")==null?"":input("videoTime");
            $videoRs = $this->videoModel->queryVideo($title, $teacherObj, $videoTime, $this->currentPage);
            $expTableData = [];
            foreach($videoRs as $videoRow) {
                $videoRow["teacherObj"] = $this->teacherModel->getTeacher($videoRow["teacherObj"])["teacherName"];
                $expTableData[] = $videoRow;
            }
            $data["rows"] = $videoRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->videoModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("video/video_teacher_query");
        }
    }


    /*ajax方式查询学习视频信息*/
    public function listAll() {
        $videoRs = $this->videoModel->queryAllVideo();
        echo json_encode($videoRs);
    }
    /*更新学习视频信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $video = $this->getVideoForm(false);
            $this->uploadFile($video,"videoFile","videoFileFile"); //处理视频文件上传
            try {
                $this->videoModel->updateVideo($video);
                $message = "学习视频更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "学习视频更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取学习视频对象*/
            $videoId = input("videoId");
            $video = $this->videoModel->getVideo($videoId);
            echo json_encode($video);
        }
    }

    /*删除多条学习视频记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $videoIds = input("videoIds");
        try {
            $count = $this->videoModel->deleteVideos($videoIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

    /*按照查询条件导出学习视频信息到Excel*/
    public function outToExcel() {
        $title = input("title")==null?"":input("title");
        $teacherObj["teacherNo"] = input("teacherObj_teacherNo")==null?"":input("teacherObj_teacherNo");
        $videoTime = input("videoTime")==null?"":input("videoTime");
        $videoRs = $this->videoModel->queryOutputVideo($title,$teacherObj,$videoTime);
        $expTableData = [];
        foreach($videoRs as $videoRow) {
            $videoRow["teacherObj"] = $this->teacherModel->getTeacher($videoRow["teacherObj"])["teacherName"];
            $expTableData[] = $videoRow;
        }
        $xlsName = "Video";
        $xlsCell = array(
            array('videoId','视频id','int'),
            array('title','视频标题','string'),
            array('teacherObj','发布老师','string'),
            array('videoTime','发布时间','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

