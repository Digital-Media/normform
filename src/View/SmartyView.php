<?php
/**
 * Created by PhpStorm.
 * User: Wolfgang
 * Date: 15.02.2018
 * Time: 01:53
 */

namespace Fhooe\NormForm\View;


use Fhooe\NormForm\Parameter\GenericParameter;
use Fhooe\NormForm\Parameter\ParameterInterface;
use Fhooe\NormForm\Parameter\PostParameter;
use Smarty;

class SmartyView extends AbstractView
{
    /**
     * @var Smarty $smarty Hold the reference to the Smarty template engine.
     */
    private $smarty;

    /**
     * Creates a new view with the specified type, name and parameters.
     * @param int $type The type of view.
     * @param string $name The name of the file involved.
     * @param array $params The parameters used when displaying the view.
     */
    public function __construct(string $name, array $params = [])
    {
        parent::__construct($name, $params);

        $this->smarty = new Smarty();
        /*$this->smarty->template_dir = $templateDir;
        $this->smarty->compile_dir = $compileDir;*/
    }

    public function display()
    {
        foreach ($this->params as $param) {
            if ($param instanceof PostParameter) {
                $this->smarty->assign($param->getName(), $param);
            } else {
                if ($param instanceof GenericParameter) {
                    $this->smarty->assign($param->getName(), $param->getValue());
                }
            }
        }
        $this->smarty->display($this->name);
    }
}