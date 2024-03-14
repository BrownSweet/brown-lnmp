<?php
namespace app\controller;

use app\BaseController;
use app\rpc\msh\MshTianyu;
use brown\RpcClient;

class Index
{


    public function hello($name = '1')
    {

        echo (new MshTianyu())->name();
        echo (new MshTianyu())->age();
    }
}
