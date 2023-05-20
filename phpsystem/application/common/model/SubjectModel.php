<?php
namespace app\common\model;
use think\Model;

class SubjectModel extends Model {
    /*关联表名*/
    protected $table  = 't_subject';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    /*添加题库题目记录*/
    public function addSubject($subject) {
        $this->insert($subject);
    }

    /*更新题库题目记录*/
    public function updateSubject($subject) {
        $this->update($subject);
    }

    /*删除多条题库题目信息*/
    public function deleteSubjects($subjectIds){
        $subjectIdArray = explode(",",$subjectIds);
        foreach ($subjectIdArray as $subjectId) {
            $this->subjectId = $subjectId;
            $this->delete();
        }
        return count($subjectIdArray);
    }
    /*根据主键获取题库题目记录*/
    public function getSubject($subjectId) {
        $subject = SubjectModel::where("subjectId",$subjectId)->find();
        return $subject;
    }

    /*按照查询条件分页查询题库题目信息*/
    public function querySubject($title, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($title != "") $where['title'] = array('like','%'.$title.'%');
        $subjectRs = SubjectModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = SubjectModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $subjectRs;
    }

    /*按照查询条件查询所有题库题目记录*/
  public function queryOutputSubject( $title) {
        $where = null;
        if($title != "") $where['title'] = array('like','%'.$title.'%');
        $subjectRs = SubjectModel::where($where)->select();
        return $subjectRs;
    }

    /*查询所有题库题目记录*/
    public function queryAllSubject(){
        $subjectRs = SubjectModel::where(null)->select();
        return $subjectRs;

    }

}
