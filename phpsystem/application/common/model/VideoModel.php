<?php
namespace app\common\model;
use think\Model;

class VideoModel extends Model {
    /*关联表名*/
    protected $table  = 't_video';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    //发布老师复合属性的获取: 多对一关系
    public function teacherObjF(){
        return $this->belongsTo('TeacherModel','teacherObj');
    }

    /*添加学习视频记录*/
    public function addVideo($video) {
        $this->insert($video);
    }

    /*更新学习视频记录*/
    public function updateVideo($video) {
        $this->update($video);
    }

    /*删除多条学习视频信息*/
    public function deleteVideos($videoIds){
        $videoIdArray = explode(",",$videoIds);
        foreach ($videoIdArray as $videoId) {
            $this->videoId = $videoId;
            $this->delete();
        }
        return count($videoIdArray);
    }
    /*根据主键获取学习视频记录*/
    public function getVideo($videoId) {
        $video = VideoModel::where("videoId",$videoId)->find();
        return $video;
    }

    /*按照查询条件分页查询学习视频信息*/
    public function queryVideo($title, $teacherObj, $videoTime, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($title != "") $where['title'] = array('like','%'.$title.'%');
        if($teacherObj['teacherNo'] != "") $where['teacherObj'] = $teacherObj['teacherNo'];
        if($videoTime != "") $where['videoTime'] = array('like','%'.$videoTime.'%');
        $videoRs = VideoModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = VideoModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $videoRs;
    }

    /*按照查询条件查询所有学习视频记录*/
  public function queryOutputVideo( $title,  $teacherObj,  $videoTime) {
        $where = null;
        if($title != "") $where['title'] = array('like','%'.$title.'%');
        if($teacherObj['teacherNo'] != "") $where['teacherObj'] = $teacherObj['teacherNo'];
        if($videoTime != "") $where['videoTime'] = array('like','%'.$videoTime.'%');
        $videoRs = VideoModel::where($where)->select();
        return $videoRs;
    }

    /*查询所有学习视频记录*/
    public function queryAllVideo(){
        $videoRs = VideoModel::where(null)->select();
        return $videoRs;

    }

}
