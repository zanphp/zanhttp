<?php

namespace Com\Youzan\ZanHttpDemo\Controller\Index;

use Com\Youzan\ZanHttpDemo\Demo\Service\HttpCall;
use Com\Youzan\ZanHttpDemo\Demo\Service\TcpCall;
use Com\Youzan\ZanHttpDemo\Model\Index\GetCacheData;
use Zan\Framework\Foundation\Domain\HttpController as Controller;
use Com\Youzan\ZanHttpDemo\Model\Index\GetDBData;

class IndexController extends Controller {

    //字符串输出示例
    public function index()
    {
        $response =  $this->output('success');
        //设置响应信息头部
        $response->withHeaders(['Content-Type' => 'text/javascript']);
        yield $response;
    }

    public function exception()
    {
        throw new \Exception("service unavailable", 503);
    }

    //json输出示例
    public function json()
    {
        yield $this->r(0, 'json string', ["Hello" => "World"]);
    }

    //模板输出示例
    public function showTpl()
    {
        //给模板中的变量赋值
        $this->assign("str", "Zan Framework");
        //输出模板页面
        yield $this->display("Demo/test/test");
    }

    //操作数据库示例
    public function dbOperation()
    {
        $demo = new GetDBData();
        //执行sql语句
        $result = (yield $demo->doSql());
        yield $this->r(0, 'json string', $result);
    }

    public function redisOperation()
    {
        $demo = new GetCacheData();

        //执行Redis命令
        $result = (yield $demo->doCacheCmd());
        var_dump($result);
        yield $this->r(0, 'json string', $result);
    }

    //Http服务调用示例
    public function httpRemoteService()
    {
        $http = new HttpCall();
        yield $http->visit();
    }

    public function tcpRemoteService()
    {
        $tcp = new TcpCall();
        $result = (yield $tcp->visit());
        yield $this->r(0, 'json string', $result);
    }
}