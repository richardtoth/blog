<?php

namespace Refaktor\Blog\DependencyInjection;

use Auryn\Injector;

class AurynDependencyInjectionContainer implements DependencyInjectionContainer {
    /**
     * @var Injector
     */
    private $auryn;

    public function __construct() {
        $this->auryn = new Injector();
    }

    /**
     * Mark a class, interface or object as shared.
     *
     * @param string|object $classNameOrInstance
     */
    public function share($classNameOrInstance) {
        $this->auryn->share($classNameOrInstance);
    }

    /**
     * Mark a certain implementation as an alias for an interface. This can be used to specify the concrete
     * implementation of an interface.
     *
     * @param string $interfaceName
     * @param string $implementationClassName
     */
    public function alias($interfaceName, $implementationClassName) {
        $this->auryn->alias($interfaceName, $implementationClassName);
    }

    /**
     * Set the values for a certain class' constructor explicitly. This is useful when a certain parameter has no
     * type hinting, e.g. a configuration option.
     *
     * @param string $className
     * @param array  $arguments key-value array of arguments and their values.
     */
    public function setClassParameters($className, $arguments) {
        foreach ($arguments as $key => $value) {
            unset($arguments[$key]);
            $arguments[':' . $key] = $value;
        }
        $this->auryn->define($className, $arguments);
    }

    /**
     * Create an instance of $class or its alias, using dependency injection.
     *
     * @param string $class
     *
     * @return object
     */
    public function make($class) {
        return $this->auryn->make($class);
    }

    /**
     * Call a class method with the parameter autodiscovery.
     *
     * @param callable $method
     * @param array    $arguments Optional arguments set explicitly.
     *
     * @return mixed
     */
    public function execute($method, $arguments = []) {
        foreach ($arguments as $key => $value) {
            unset($arguments[$key]);
            $arguments[':' . $key] = $value;
        }
        return $this->auryn->execute($method, $arguments);
    }
}