<?php
namespace app\common\model;
use think\Model;

class PaperSubjectModel extends Model {
    /*关联表名*/
    protected $table  = 't_paperSubject';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    //测试试卷复合属性的获取: 多对一关系
    public function paperObjF(){
        return $this->belongsTo('PaperModel','paperObj');
    }

    //题库题目复合属性的获取: 多对一关系
    public function subjectObjF(){
        return $this->belongsTo('SubjectModel','subjectObj');
    }

    /*添加试卷题目记录*/
    public function addPaperSubject($paperSubject) {
        $this->insert($paperSubject);
    }

    /*更新试卷题目记录*/
    public function updatePaperSubject($paperSubject) {
        $this->update($paperSubject);
    }

    /*删除多条试卷题目信息*/
    public function deletePaperSubjects($psIds){
        $psIdArray = explode(",",$psIds);
        foreach ($psIdArray as $psId) {
            $this->psId = $psId;
            $this->delete();
        }
        return count($psIdArray);
    }
    /*根据主键获取试卷题目记录*/
    public function getPaperSubject($psId) {
        $paperSubject = PaperSubjectModel::where("psId",$psId)->find();
        return $paperSubject;
    }

    /*按照查询条件分页查询试卷题目信息*/
    public function queryPaperSubject($paperObj, $subjectObj, $addTime, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($paperObj['paperId'] != 0) $where['paperObj'] = $paperObj['paperId'];
        if($subjectObj['subjectId'] != 0) $where['subjectObj'] = $subjectObj['subjectId'];
        if($addTime != "") $where['addTime'] = array('like','%'.$addTime.'%');
        $paperSubjectRs = PaperSubjectModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = PaperSubjectModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $paperSubjectRs;
    }

    /*按照查询条件查询所有试卷题目记录*/
  public function queryOutputPaperSubject( $paperObj,  $subjectObj,  $addTime) {
        $where = null;
        if($paperObj['paperId'] != 0) $where['paperObj'] = $paperObj['paperId'];
        if($subjectObj['subjectId'] != 0) $where['subjectObj'] = $subjectObj['subjectId'];
        if($addTime != "") $where['addTime'] = array('like','%'.$addTime.'%');
        $paperSubjectRs = PaperSubjectModel::where($where)->select();
        return $paperSubjectRs;
    }

    /*查询所有试卷题目记录*/
    public function queryAllPaperSubject(){
        $paperSubjectRs = PaperSubjectModel::where(null)->select();
        return $paperSubjectRs;

    }

}
