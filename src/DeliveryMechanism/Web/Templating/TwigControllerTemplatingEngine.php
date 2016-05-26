<?php

namespace Refaktor\Blog\DeliveryMechanism\Web\Templating;

use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

class TwigControllerTemplatingEngine implements ControllerTemplatingEngine {
    /**
     * @var string
     */
    private $templateDirectory;

    /**
     * @var array
     */
    private $trimControllerName;

    /**
     * @var array
     */
    private $trimActionName;

    /**
     * @param string $templateDirectory
     * @param array  $trimControllerName
     * @param array  $trimActionName
     */
    public function __construct($templateDirectory, $trimControllerName, $trimActionName) {
        $this->templateDirectory  = $templateDirectory;
        $this->trimControllerName = $trimControllerName;
        $this->trimActionName     = $trimActionName;
    }

    /**
     * @param string $controller
     * @param string $method
     * @param array $parameters
     *
     * @return string
     */
    public function render($controller, $method, $parameters) {
        foreach ($this->trimControllerName as $remove) {
            $controller = str_replace($remove, '', $controller);
        }
        $path = strtr($controller, '\\', DIRECTORY_SEPARATOR);
        foreach ($this->trimActionName as $remove) {
            $method = str_replace($remove, '', $method);
        }
        $file = $method . '.twig';

        $loader = new Twig_Loader_Filesystem($this->templateDirectory);
        $twig = new Twig_Environment($loader, array('debug' => true));
        $twig->addExtension(new Twig_Extension_Debug());

        return $twig->render($path . DIRECTORY_SEPARATOR . $file, $parameters);
    }
}