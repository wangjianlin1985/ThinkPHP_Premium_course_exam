<?php
namespace app\common\model;
use think\Model;

class StudentAnswerModel extends Model {
    /*关联表名*/
    protected $table  = 't_studentAnswer';
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

    //考试题目复合属性的获取: 多对一关系
    public function subjectObjF(){
        return $this->belongsTo('SubjectModel','subjectObj');
    }

    //测试学生复合属性的获取: 多对一关系
    public function studentObjF(){
        return $this->belongsTo('StudentModel','studentObj');
    }

    /*添加学生答案记录*/
    public function addStudentAnswer($studentAnswer) {
        $this->insert($studentAnswer);
    }

    /*更新学生答案记录*/
    public function updateStudentAnswer($studentAnswer) {
        $this->update($studentAnswer);
    }

    /*删除多条学生答案信息*/
    public function deleteStudentAnswers($answerIds){
        $answerIdArray = explode(",",$answerIds);
        foreach ($answerIdArray as $answerId) {
            $this->answerId = $answerId;
            $this->delete();
        }
        return count($answerIdArray);
    }
    /*根据主键获取学生答案记录*/
    public function getStudentAnswer($answerId) {
        $studentAnswer = StudentAnswerModel::where("answerId",$answerId)->find();
        return $studentAnswer;
    }

    /*按照查询条件分页查询学生答案信息*/
    public function queryStudentAnswer($paperObj, $subjectObj, $studentObj, $examTime, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($paperObj['paperId'] != 0) $where['paperObj'] = $paperObj['paperId'];
        if($subjectObj['subjectId'] != 0) $where['subjectObj'] = $subjectObj['subjectId'];
        if($studentObj['user_name'] != "") $where['studentObj'] = $studentObj['user_name'];
        if($examTime != "") $where['examTime'] = array('like','%'.$examTime.'%');
        $studentAnswerRs = StudentAnswerModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = StudentAnswerModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $studentAnswerRs;
    }

    /*按照查询条件查询所有学生答案记录*/
  public function queryOutputStudentAnswer( $paperObj,  $subjectObj,  $studentObj,  $examTime) {
        $where = null;
        if($paperObj['paperId'] != 0) $where['paperObj'] = $paperObj['paperId'];
        if($subjectObj['subjectId'] != 0) $where['subjectObj'] = $subjectObj['subjectId'];
        if($studentObj['user_name'] != "") $where['studentObj'] = $studentObj['user_name'];
        if($examTime != "") $where['examTime'] = array('like','%'.$examTime.'%');
        $studentAnswerRs = StudentAnswerModel::where($where)->select();
        return $studentAnswerRs;
    }

    /*查询所有学生答案记录*/
    public function queryAllStudentAnswer(){
        $studentAnswerRs = StudentAnswerModel::where(null)->select();
        return $studentAnswerRs;

    }

}
