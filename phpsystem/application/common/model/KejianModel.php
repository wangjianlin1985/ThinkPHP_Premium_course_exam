<?php
namespace app\common\model;
use think\Model;

class KejianModel extends Model {
    /*关联表名*/
    protected $table  = 't_kejian';
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

    /*添加课件记录*/
    public function addKejian($kejian) {
        $this->insert($kejian);
    }

    /*更新课件记录*/
    public function updateKejian($kejian) {
        $this->update($kejian);
    }

    /*删除多条课件信息*/
    public function deleteKejians($kejianIds){
        $kejianIdArray = explode(",",$kejianIds);
        foreach ($kejianIdArray as $kejianId) {
            $this->kejianId = $kejianId;
            $this->delete();
        }
        return count($kejianIdArray);
    }
    /*根据主键获取课件记录*/
    public function getKejian($kejianId) {
        $kejian = KejianModel::where("kejianId",$kejianId)->find();
        return $kejian;
    }

    /*按照查询条件分页查询课件信息*/
    public function queryKejian($title, $teacherObj, $addTime, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($title != "") $where['title'] = array('like','%'.$title.'%');
        if($teacherObj['teacherNo'] != "") $where['teacherObj'] = $teacherObj['teacherNo'];
        if($addTime != "") $where['addTime'] = array('like','%'.$addTime.'%');
        $kejianRs = KejianModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = KejianModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $kejianRs;
    }

    /*按照查询条件查询所有课件记录*/
  public function queryOutputKejian( $title,  $teacherObj,  $addTime) {
        $where = null;
        if($title != "") $where['title'] = array('like','%'.$title.'%');
        if($teacherObj['teacherNo'] != "") $where['teacherObj'] = $teacherObj['teacherNo'];
        if($addTime != "") $where['addTime'] = array('like','%'.$addTime.'%');
        $kejianRs = KejianModel::where($where)->select();
        return $kejianRs;
    }

    /*查询所有课件记录*/
    public function queryAllKejian(){
        $kejianRs = KejianModel::where(null)->select();
        return $kejianRs;

    }

}
