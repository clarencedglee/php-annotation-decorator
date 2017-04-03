<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

require( dirname( __FILE__ ) . '/../src/autoload.php');

class Service {
    /**
     * @decorate(\Dau\Annotations\Decorators\HttpPost)
     * @decorate(\Dau\Annotations\Decorators\HttpGet, required=false)
     */
    public function add(int $id, string $name, array $data) {
        return '$id = '.$id.', $name = ' . $name . ', $data = '.implode(',', $data);
    }
}

$decorated = new \Dau\Annotations\Decorators\DecoratorEnabler(new Service);

// we get the $_POST as params for add()
// Notice we don't have any errors for empty $_GET
// because its annotation specifies required=false
$_POST = ['id' => 1, 'name' => 'Postal', 'data' => ['http', 'post']];
var_dump( $decorated->add() );

// If we have $_GET it is used as params for add() instead of POST
// because its annotation is declared below HttpPost decorator
$_GET  = ['id' => 2, 'name' => 'Ghetto', 'data' => ['http', 'get']];
var_dump( $decorated->add() );

// If no $_POST, we get an exception because it is required by default
$_POST = [];
try {
    $decorated->add();
} catch( \Dau\Annotations\Decorators\MissingArgumentsException $e ){
    var_dump('Problems');
}