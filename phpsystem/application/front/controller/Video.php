<?php
namespace app\front\controller;
use think\Request;
use think\Exception;
use app\common\model\TeacherModel;
use app\common\model\VideoModel;

class Video extends Base {
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
    public function frontAdd(){
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
            return $this->fetch('video/video_frontAdd');
        }
    }

    /*前台修改学习视频信息*/
    public function frontModify() {
        $this->assign("videoId",input("videoId"));
        return $this->fetch("video/video_frontModify");
    }

    /*前台按照查询条件分页查询学习视频信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $title = input("title")==null?"":input("title");
        $teacherObj["teacherNo"] = input("teacherObj_teacherNo")==null?"":input("teacherObj_teacherNo");
        $videoTime = input("videoTime")==null?"":input("videoTime");
        $videoRs = $this->videoModel->queryVideo($title, $teacherObj, $videoTime, $this->currentPage);
        $this->assign("videoRs",$videoRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->videoModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->videoModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->videoModel->rows);
        $this->assign("title",$title);
        $this->assign("teacherObj",$teacherObj);
        $this->assign("teacherList",$this->teacherModel->queryAllTeacher());
        $this->assign("videoTime",$videoTime);
        return $this->fetch('video/video_frontlist');
    }

    /*ajax方式查询学习视频信息*/
    public function listAll() {
        $videoRs = $this->videoModel->queryAllVideo();
        echo json_encode($videoRs);
    }
    /*前台查询根据主键查询一条学习视频信息*/
    public function frontshow() {
        $videoId = input("videoId");
        $video = $this->videoModel->getVideo($videoId);
       $this->assign("video",$video);
        return $this->fetch("video/video_frontshow");
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

}

