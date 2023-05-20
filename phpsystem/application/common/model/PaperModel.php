<?php
namespace app\common\model;
use think\Model;

class PaperModel extends Model {
    /*关联表名*/
    protected $table  = 't_paper';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    /*添加测试试卷记录*/
    public function addPaper($paper) {
        $this->insert($paper);
    }

    /*更新测试试卷记录*/
    public function updatePaper($paper) {
        $this->update($paper);
    }

    /*删除多条测试试卷信息*/
    public function deletePapers($paperIds){
        $paperIdArray = explode(",",$paperIds);
        foreach ($paperIdArray as $paperId) {
            $this->paperId = $paperId;
            $this->delete();
        }
        return count($paperIdArray);
    }
    /*根据主键获取测试试卷记录*/
    public function getPaper($paperId) {
        $paper = PaperModel::where("paperId",$paperId)->find();
        return $paper;
    }

    /*按照查询条件分页查询测试试卷信息*/
    public function queryPaper($paperName, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($paperName != "") $where['paperName'] = array('like','%'.$paperName.'%');
        $paperRs = PaperModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = PaperModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $paperRs;
    }

    /*按照查询条件查询所有测试试卷记录*/
  public function queryOutputPaper( $paperName) {
        $where = null;
        if($paperName != "") $where['paperName'] = array('like','%'.$paperName.'%');
        $paperRs = PaperModel::where($where)->select();
        return $paperRs;
    }

    /*查询所有测试试卷记录*/
    public function queryAllPaper(){
        $paperRs = PaperModel::where(null)->select();
        return $paperRs;

    }

}
