<?php

namespace Refaktor\Blog\DeliveryMechanism\Web\Templating;

interface ControllerTemplatingEngine {
    public function render($controller, $method, $parameters);
}