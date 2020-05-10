<?php
/**
 * Filename: Demo.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-22 22:38
 **/
class Service_Data_Demo extends Service_Data_Base
{
    private $tbName = null;

    const MAX_PAGE_SIZE = 100;
    /**
     *
     */
    protected function init()
    {
        Bd_Log::debug("in method ".__METHOD__);
        $this->tbName = 'tb_media';
    }
    /**
     * @param $conds
     * @param $fields
     * @param null $appends
     * @param null $options
     * @return mixed
     */
    public function getList($conds, $fields = array("*"), $appends = null, $options = null)
    {
        $arrItems = $this->objDb->select($this->tbName, $fields, $conds, $options, $appends);
        $this->logSql();
        return $arrItems;
    }

    /**
     * @param $pageNo
     * @param $pageSize
     * @param null $conds
     * @param null $options
     * @param null $appends
     * @return array|bool
     */
    public function getPageList($pageNo, $pageSize, $conds = null, $fields = array("*"), $options = null, $appends = null)
    {
        // 返回字段信息
        $arrRet = array(
            'totalPages'    =>    0,
            'totalItems'    =>    0,
            'pageNo'        =>    $pageNo,
            'pageSize'      =>    $pageSize,
            'before'        =>    $pageNo-1,  //需要修正
            'next'          =>    $pageNo+1,  //需要修正
            'last'          =>    0,
            'first'         =>    0,
        );



        $total = $this->objDb->selectCount($this->tbName, $conds, $options, $appends);
        $this->logSql();
        //上层处理数据库异常
        if ( false === $total ) {
            return false;
        }
        $arrRet['totalItems'] = $total;
        if ($pageSize < 0) {
            $pageSize = 1;
        }
        $arrRet['pageSize'] = $pageSize; //


        $arrRet['totalPages'] = ceil($total/$pageSize);

        //页号修正
        if ($pageNo > $arrRet['totalPages'] - 1) {
            $pageNo = $arrRet['totalPages'] - 1;
        }
        //有可能totalPages = 0
        if ($pageNo < 0) {
            $pageNo = 0;
        }
        $arrRet['pageNo'] = $pageNo;

        //修正last
        $arrRet['last'] = $arrRet['totalPages'] - 1;
        if ($arrRet['last'] < 0) {
            $arrRet['last'] = 0;
        }
        //before修正
        $arrRet['before'] = $pageNo - 1;
        if (0 > $arrRet['before']) {
            $arrRet['before'] = 0;
        }

        //next修正
        $arrRet['next'] = $pageNo + 1;
        if ($arrRet['next'] >= $arrRet['totalPages']) {
            $arrRet['next'] = $arrRet['totalPages'];
        }





        $start = $pageNo*$pageSize;
        $size = $pageSize;
        //暂时不考虑两次查询之间的数据并发 变化
        //$fields = array("*");
        $appends .= " limit {$start},{$size}";
        $arrItems = $this->objDb->select($this->tbName, $fields, $conds, $options, $appends);
        $this->logSql();
        //上层处理数据库异常
        if ( false === $arrItems ) {
            return false;
        }
        $arrRet['items'] = $arrItems;
        return $arrRet;


    }
    /**
     * @param $conds
     * @return mixed
     */
    public function del($conds)
    {
        $iRet = $this->objDb->delete($this->tbName, $conds);
        $this->logSql();
        return $iRet;
    }

    /**
     * @param $conds
     * @param $fields
     * @return mixed
     */
    public function mod($conds, $fields)
    {
        $iRet = $this->objDb->update($this->tbName, $fields, $conds);
        $this->logSql();
        return $iRet;
    }

    /**
     * @param $row
     * @return mixed
     */
    public function add($row)
    {
        $iRet = $this->objDb->insert($this->tbName, $row);
        $this->logSql();
        return $iRet;
    }

    /**
     * @param $conds
     * @param null $options
     * @param null $appends
     * @return mixed
     */
    public function count($conds, $options = null, $appends = null)
    {
        $iRet = $this->objDb->selectCount($this->tbName, $conds, $options, $appends);
        $this->logSql();
        return $iRet;
    }
}