<?php

namespace Fhooe\NormForm\View;


use Fhooe\NormForm\Parameter\GenericParameter;
use Fhooe\NormForm\Parameter\PostParameter;
use Twig_Loader_Filesystem;

class TwigView extends AbstractView
{
    private $loader;
    private $twig;

    public function __construct(string $name, array $params = [])
    {
        parent::__construct($name, $params);

        $this->loader = new Twig_Loader_Filesystem("twigtemplates");
        $this->twig = new \Twig_Environment($this->loader, ["cache" => "twigtemplates_c"]);
        $this->twig->addGlobal("_server", $_SERVER);
    }

    public function display()
    {
        $templateParameters = [];
        foreach ($this->params as $param) {
            if ($param instanceof PostParameter) {
                $templateParameters[$param->getName()] = $param;
            } else {
                if ($param instanceof GenericParameter) {
                    $templateParameters[$param->getName()] = $param->getValue();
                }
            }
        }
        try {
            $this->twig->display($this->name, $templateParameters);
        } catch (\Twig_Error_Loader $e) {
            echo $e->getMessage();
        } catch (\Twig_Error_Runtime $e) {
            echo $e->getMessage();
        } catch (\Twig_Error_Syntax $e) {
            echo $e->getMessage();
        }
    }
}