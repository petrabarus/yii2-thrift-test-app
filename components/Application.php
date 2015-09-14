<?php

namespace app\components;
use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TPhpStream;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\ClassLoader\ThriftClassLoader;

class Application extends \yii\web\Application {
    
    public $thriftPath = '';
    public $thriftDefinitions = [];
    
    public function init() {
        parent::init();
        $this->autoloadThrift();
    }
    
    private function autoloadThrift() {
        $loader = new ThriftClassLoader();
        foreach($this->thriftDefinitions as $alias => $path) {
            $loader->registerDefinition($alias, $this->thriftPath . $path);
        }
        $loader->register();
    }

    public function handleRequest($request) {
        $handler = new \app\services\HelloHandler();
        $processor = new \urbanindo\services\HelloServiceProcessor($handler);
        $transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
        $protocol = new TBinaryProtocol($transport, true, true);
        $transport->open();
        $processor->process($protocol, $protocol);
        $transport->close();
        return $this->getResponse();
    }
}
