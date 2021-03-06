<?php if (!defined('ROOT_PATH'))
{
    exit('No Permission');
}


class User_StockOut extends Yf_Model
{
    public $_cacheKeyPrefix  = 'c|user_stock_out|';
    public $_cacheName       = 'stock_out';
    public $_tableName       = 'user_stock_out';
    public $_tablePrimaryKey = 'out_id';

    /**
     * @param string $user User Object
     * @param   string $db_id 指定需要连接的数据库Id
     * @return void
     */
    public function __construct(&$db_id = 'shop', &$user = null)
    {
        $this->_tableName = TABEL_PREFIX . $this->_tableName;
        $this->_cacheFlag = CHE;
        parent::__construct($db_id, $user);
    }

    /**
     * 根据主键值，从数据库读取数据
     * @param int $table_key 主键值
     * @return array $rows 返回的查询内容
     * @throws Exception
     */
    public function getStockOut($table_key = null)
    {
        $rows = array();
        $rows = $this->get($table_key);

        return $rows;
    }

    /**
     * 插入
     * @param array $field_row 插入数据信息
     * @param bool $return_insert_id 是否返回inset id
     * @param array $field_row 信息
     * @return bool  是否成功
     * @access public
     */
    public function addStockOut($field_row, $return_insert_id = false)
    {
        $add_flag = $this->add($field_row, $return_insert_id);

        //$this->removeKey($user_grade_id);
        return $add_flag;
    }

    /**
     * 根据主键更新表内容
     * @param mix $table_key 主键
     * @param array $field_row key=>value数组
     * @return bool $update_flag 是否成功
     * @access public
     */
    public function editStockOut($table_key, $field_row)
    {
        $update_flag = $this->edit($table_key, $field_row);

        return $update_flag;
    }

    /**
     * 更新单个字段
     * @param mix $table_key
     * @param array $field_name
     * @param array $field_value_new
     * @param array $field_value_old
     * @return bool $update_flag 是否成功
     * @access public
     */
    public function editStockOutSingleField($table_key, $field_name, $field_value_new, $field_value_old)
    {
        $update_flag = $this->editSingleField($table_key, $field_name, $field_value_new, $field_value_old);

        return $update_flag;
    }

    /**
     * 删除操作
     * @param int $table_key
     * @return bool $del_flag 是否成功
     * @access public
     */
    public function removeStockOut($table_key)
    {
        $del_flag = $this->remove($table_key);

        return $del_flag;
    }
}