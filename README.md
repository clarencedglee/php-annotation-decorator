[![Build Status](https://travis-ci.org/clarencedglee/php-annotation-decorator.svg?branch=master)](https://travis-ci.org/clarencedglee/php-annotation-decorator)

# php-annotation-decorator
Apply decorators to php methods using annotations

    class ExampleClass {
    
        /**
         * @decorate(\Dau\Annotations\Decorators\HttpPost)
         * @decorate(\Dau\Annotations\Decorators\HttpGet, required=false)
         */
        public function add(int $id, string $name, array $data) {
            return '$id = '.$id.', $name = ' . $name . ', $data = '.implode(',', $data);
        }
        
        /**
         * @decorate(\Dau\Annotations\Decorators\HttpGet, required=false)
         */
        public function remove(int $id, string $name, array $data) {
            return '$id = '.$id.', $name = ' . $name . ', $data = '.implode(',', $data);
        }
    }
    
    $decorated = new \Dau\Annotations\Decorators\DecoratorEnabler(new ExampleClass);
    // Method calls to $decorated are passed to ExampleClass via the classes defined in @decorate annotations
    
    // We get the $_POST as params for add()
    // Notice we don't have any errors for empty $_GET
    // This is because its annotation specifies required=false
    $_POST = ['id' => 1, 'name' => 'Postal', 'data' => ['http', 'post']];
    var_dump( $decorated->add() );
    
    // If we have values in $_GET it is used as params for add() instead of POST
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
    
    // While we have $_GET, the params are overridden
    var_dump($decorated->remove(1, 'param', []));
    
    // Without $_GET, the params we pass remain intact
    $_GET = [];
    var_dump($decorated->remove(1, 'param', []));
