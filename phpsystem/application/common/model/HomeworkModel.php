<?php
namespace app\common\model;
use think\Model;

class HomeworkModel extends Model {
    /*关联表名*/
    protected $table  = 't_homework';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    //布置的老师复合属性的获取: 多对一关系
    public function teacherObjF(){
        return $this->belongsTo('TeacherModel','teacherObj');
    }

    /*添加家庭作业记录*/
    public function addHomework($homework) {
        $this->insert($homework);
    }

    /*更新家庭作业记录*/
    public function updateHomework($homework) {
        $this->update($homework);
    }

    /*删除多条家庭作业信息*/
    public function deleteHomeworks($homeworkIds){
        $homeworkIdArray = explode(",",$homeworkIds);
        foreach ($homeworkIdArray as $homeworkId) {
            $this->homeworkId = $homeworkId;
            $this->delete();
        }
        return count($homeworkIdArray);
    }
    /*根据主键获取家庭作业记录*/
    public function getHomework($homeworkId) {
        $homework = HomeworkModel::where("homeworkId",$homeworkId)->find();
        return $homework;
    }

    /*按照查询条件分页查询家庭作业信息*/
    public function queryHomework($taskTitle, $teacherObj, $homeworkDate, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($taskTitle != "") $where['taskTitle'] = array('like','%'.$taskTitle.'%');
        if($teacherObj['teacherNo'] != "") $where['teacherObj'] = $teacherObj['teacherNo'];
        if($homeworkDate != "") $where['homeworkDate'] = array('like','%'.$homeworkDate.'%');
        $homeworkRs = HomeworkModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = HomeworkModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $homeworkRs;
    }

    /*按照查询条件查询所有家庭作业记录*/
  public function queryOutputHomework( $taskTitle,  $teacherObj,  $homeworkDate) {
        $where = null;
        if($taskTitle != "") $where['taskTitle'] = array('like','%'.$taskTitle.'%');
        if($teacherObj['teacherNo'] != "") $where['teacherObj'] = $teacherObj['teacherNo'];
        if($homeworkDate != "") $where['homeworkDate'] = array('like','%'.$homeworkDate.'%');
        $homeworkRs = HomeworkModel::where($where)->select();
        return $homeworkRs;
    }

    /*查询所有家庭作业记录*/
    public function queryAllHomework(){
        $homeworkRs = HomeworkModel::where(null)->select();
        return $homeworkRs;

    }

}
