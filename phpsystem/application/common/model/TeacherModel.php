<?php
namespace app\common\model;
use think\Model;

class TeacherModel extends Model {
    /*关联表名*/
    protected $table  = 't_teacher';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    /*添加教师记录*/
    public function addTeacher($teacher) {
        $this->insert($teacher);
    }

    /*更新教师记录*/
    public function updateTeacher($teacher) {
        $this->update($teacher);
    }

    /*删除多条教师信息*/
    public function deleteTeachers($teacherNos){
        $teacherNoArray = explode(",",$teacherNos);
        foreach ($teacherNoArray as $teacherNo) {
            $this->teacherNo = $teacherNo;
            $this->delete();
        }
        return count($teacherNoArray);
    }
    /*根据主键获取教师记录*/
    public function getTeacher($teacherNo) {
        $teacher = TeacherModel::where("teacherNo",$teacherNo)->find();
        return $teacher;
    }

    /*按照查询条件分页查询教师信息*/
    public function queryTeacher($teacherNo, $teacherName, $comeDate, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($teacherNo != "") $where['teacherNo'] = array('like','%'.$teacherNo.'%');
        if($teacherName != "") $where['teacherName'] = array('like','%'.$teacherName.'%');
        if($comeDate != "") $where['comeDate'] = array('like','%'.$comeDate.'%');
        $teacherRs = TeacherModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = TeacherModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $teacherRs;
    }

    /*按照查询条件查询所有教师记录*/
  public function queryOutputTeacher( $teacherNo,  $teacherName,  $comeDate) {
        $where = null;
        if($teacherNo != "") $where['teacherNo'] = array('like','%'.$teacherNo.'%');
        if($teacherName != "") $where['teacherName'] = array('like','%'.$teacherName.'%');
        if($comeDate != "") $where['comeDate'] = array('like','%'.$comeDate.'%');
        $teacherRs = TeacherModel::where($where)->select();
        return $teacherRs;
    }

    /*查询所有教师记录*/
    public function queryAllTeacher(){
        $teacherRs = TeacherModel::where(null)->select();
        return $teacherRs;

    }

}
