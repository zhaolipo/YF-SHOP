<?php if (!defined('ROOT_PATH'))
{
    exit('No Permission');
}

class User_SharesCtl extends AdminController
{
    public $webconfigModel = null;

    public function __construct(&$ctl, $met, $typ)
    {
        parent::__construct($ctl, $met, $typ);
    }

}