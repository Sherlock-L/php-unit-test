<?php
class Test {
    public function sayHello() {
        return 'hello ,it is server';
    }
    public function repeat($params) {
        return json_encode($params);
    }
}