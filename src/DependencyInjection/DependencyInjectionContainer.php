<?php

namespace Refaktor\Blog\DependencyInjection;

interface DependencyInjectionContainer {
    /**
     * Mark a class, interface or object as shared.
     *
     * @param string|object $classNameOrInstance
     */
    public function share($classNameOrInstance);

    /**
     * Mark a certain implementation as an alias for an interface. This can be used to specify the concrete
     * implementation of an interface.
     *
     * @param string $interfaceName
     * @param string $implementationClassName
     */
    public function alias($interfaceName, $implementationClassName);

    /**
     * Set the values for a certain class' constructor explicitly. This is useful when a certain parameter has no
     * type hinting, e.g. a configuration option.
     *
     * @param string $className
     * @param array  $arguments key-value array of arguments and their values.
     */
    public function setClassParameters($className, $arguments);

    /**
     * Create an instance of $class or its alias, using dependency injection.
     *
     * @param string $class
     *
     * @return object
     */
    public function make($class);

    /**
     * Call a class method with the parameter autodiscovery.
     *
     * @param callable $method
     * @param array    $arguments Optional arguments set explicitly.
     *
     * @return mixed
     */
    public function execute($method, $arguments = []);
}