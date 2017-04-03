<?php

require( dirname( __FILE__ ) . '/../src/autoload.php');

class Service {
    /**
     * @decorate(\Dau\Annotations\Decorators\HttpPost)
     * @decorate(\Dau\Annotations\Decorators\HttpGet)
     */
    public function add(int $id, string $name, array $data) {
        return '$id = '.$id.', $name = ' . $name . ', $data = '.implode(',', $data);
    }
}

$decorated = new \Dau\Annotations\Decorators\DecoratorEnabler(new Service);

$_POST = ['id' => 1, 'name' => 'Postal', 'data' => ['http', 'post']];
$_GET  = ['id' => 2, 'name' => 'Ghetto', 'data' => ['http', 'get']];
var_dump( $decorated->add() );