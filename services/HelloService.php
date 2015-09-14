<?php

namespace app\services;

use petrabarus\services\HelloLanguage;

class HelloService implements \petrabarus\services\HelloServiceIf, \UrbanIndo\Yii2\Thrift\Service {
    
    public function say_foreign_hello($language) {
        $lang = HelloLanguage::$__names[$language];
        $hello = [
            HelloLanguage::ENGLISH => 'Hello!',
            HelloLanguage::FRENCH => 'Bonjour!',
            HelloLanguage::SPANISH => 'Hola!'
        ];
        return "{$lang}: {$hello[$language]}";
    }

    public function say_hello() {
        return "hello hello hello";
    }

    public function say_hello_repeat($times) {
        return array_map(function($e) {
            return "hello";
        }, range(1, $times));
    }

    public function getProcessorClass() {
        return 'petrabarus\services\HelloServiceProcessor';
    }

}
