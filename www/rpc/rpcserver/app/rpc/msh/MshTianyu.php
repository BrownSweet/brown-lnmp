<?php

/**
 * // +----------------------------------------------------------------------
 * // | Brown-Rpc
 * // +----------------------------------------------------------------------
 * // | 自动生成接口调用类
 * // +----------------------------------------------------------------------
 * // | Author: tianyu <455764041@qq.com>
 * // +----------------------------------------------------------------------
 */

declare(strict_types=1);

namespace app\rpc\msh;

use brown\RpcClient;

class MshTianyu
{
	public function name()
	{
		return (new RpcClient())->Service('msh')->request('Tianyu')->name([]);
	}


	public function age($a = 1)
	{
		return (new RpcClient())->Service('msh')->request('Tianyu')->age(['a'=>$a,]);
	}
}
