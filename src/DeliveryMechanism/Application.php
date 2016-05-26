<?php

namespace Refaktor\Blog\DeliveryMechanism;

use Refaktor\Blog\DependencyInjection\DependencyInjectionContainer;

abstract class Application {
    /**
     * @var DependencyInjectionContainer
     */
    private $dic;

    /**
     * @var array
     */
    private $configuration = [];

    /**
     * Application constructor.
     *
     * @param DependencyInjectionContainer $dic
     * @param array                        $configuration
     */
    final public function __construct(DependencyInjectionContainer $dic, $configuration) {
        $this->dic           = $dic;
        $this->configuration = $configuration;

        $params = $this->getConfiguration('dic.params');
        foreach ($params as $class => $classParams) {
            $this->dic->setClassParameters($class, $classParams);
        }
        $alias = $this->getConfiguration('dic.alias');
        foreach ($alias as $interface => $class) {
            $this->dic->alias($interface, $class);
        }
        $share = $this->getConfiguration('dic.share');
        foreach ($share as $class) {
            $this->dic->share($class);
        }
    }

    /**
     * @param string $option
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function getConfiguration($option) {
        $optionElements = explode('.', $option);

        $configurationOption = &$this->configuration;
        while (count($optionElements)) {
            $currentOptionElement = array_shift($optionElements);
            if (isset($configurationOption[$currentOptionElement])) {
                $configurationOption = &$configurationOption[$currentOptionElement];
            } else {
                throw new \Exception('Missing configuration option: ' . $option);
            }
        }

        return $configurationOption;
    }

    /**
     * @return DependencyInjectionContainer
     */
    protected function getDIC() {
        return $this->dic;
    }
}