<?php
namespace app\common\model;
use think\Model;

class ScoreModel extends Model {
    /*关联表名*/
    protected $table  = 't_score';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    //考试学生复合属性的获取: 多对一关系
    public function studentObjF(){
        return $this->belongsTo('StudentModel','studentObj');
    }

    //测试试卷复合属性的获取: 多对一关系
    public function paperObjF(){
        return $this->belongsTo('PaperModel','paperObj');
    }

    /*添加学生成绩记录*/
    public function addScore($score) {
        $this->insert($score);
    }

    /*更新学生成绩记录*/
    public function updateScore($score) {
        $this->update($score);
    }

    /*删除多条学生成绩信息*/
    public function deleteScores($scoreIds){
        $scoreIdArray = explode(",",$scoreIds);
        foreach ($scoreIdArray as $scoreId) {
            $this->scoreId = $scoreId;
            $this->delete();
        }
        return count($scoreIdArray);
    }
    /*根据主键获取学生成绩记录*/
    public function getScore($scoreId) {
        $score = ScoreModel::where("scoreId",$scoreId)->find();
        return $score;
    }

    /*按照查询条件分页查询学生成绩信息*/
    public function queryScore($studentObj, $paperObj, $examTime, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($studentObj['user_name'] != "") $where['studentObj'] = $studentObj['user_name'];
        if($paperObj['paperId'] != 0) $where['paperObj'] = $paperObj['paperId'];
        if($examTime != "") $where['examTime'] = array('like','%'.$examTime.'%');
        $scoreRs = ScoreModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = ScoreModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $scoreRs;
    }

    /*按照查询条件查询所有学生成绩记录*/
  public function queryOutputScore( $studentObj,  $paperObj,  $examTime) {
        $where = null;
        if($studentObj['user_name'] != "") $where['studentObj'] = $studentObj['user_name'];
        if($paperObj['paperId'] != 0) $where['paperObj'] = $paperObj['paperId'];
        if($examTime != "") $where['examTime'] = array('like','%'.$examTime.'%');
        $scoreRs = ScoreModel::where($where)->select();
        return $scoreRs;
    }

    /*查询所有学生成绩记录*/
    public function queryAllScore(){
        $scoreRs = ScoreModel::where(null)->select();
        return $scoreRs;

    }

}
