<?php
namespace app\common\model;
use think\Model;

class QuestionModel extends Model {
    /*关联表名*/
    protected $table  = 't_question';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    //提问学生复合属性的获取: 多对一关系
    public function userObjF(){
        return $this->belongsTo('StudentModel','userObj');
    }

    /*添加问题答疑记录*/
    public function addQuestion($question) {
        $this->insert($question);
    }

    /*更新问题答疑记录*/
    public function updateQuestion($question) {
        $this->update($question);
    }

    /*删除多条问题答疑信息*/
    public function deleteQuestions($questionIds){
        $questionIdArray = explode(",",$questionIds);
        foreach ($questionIdArray as $questionId) {
            $this->questionId = $questionId;
            $this->delete();
        }
        return count($questionIdArray);
    }
    /*根据主键获取问题答疑记录*/
    public function getQuestion($questionId) {
        $question = QuestionModel::where("questionId",$questionId)->find();
        return $question;
    }

    /*按照查询条件分页查询问题答疑信息*/
    public function queryQuestion($questionTitle, $userObj, $questionTime, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($questionTitle != "") $where['questionTitle'] = array('like','%'.$questionTitle.'%');
        if($userObj['user_name'] != "") $where['userObj'] = $userObj['user_name'];
        if($questionTime != "") $where['questionTime'] = array('like','%'.$questionTime.'%');
        $questionRs = QuestionModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = QuestionModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $questionRs;
    }

    /*按照查询条件查询所有问题答疑记录*/
  public function queryOutputQuestion( $questionTitle,  $userObj,  $questionTime) {
        $where = null;
        if($questionTitle != "") $where['questionTitle'] = array('like','%'.$questionTitle.'%');
        if($userObj['user_name'] != "") $where['userObj'] = $userObj['user_name'];
        if($questionTime != "") $where['questionTime'] = array('like','%'.$questionTime.'%');
        $questionRs = QuestionModel::where($where)->select();
        return $questionRs;
    }

    /*查询所有问题答疑记录*/
    public function queryAllQuestion(){
        $questionRs = QuestionModel::where(null)->select();
        return $questionRs;

    }

}
