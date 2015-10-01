<?php
namespace Strata\Controller;

use Strata\Controller\Request;
use Strata\Controller\Loader\ShortcodeLoader;
use Strata\Controller\Loader\HelperLoader;
use Strata\View\View;

use Strata\Core\StrataObjectTrait;

/**
 * Base controller class.
 */
class Controller {

    use StrataObjectTrait;

    public static function getNamespaceStringInStrata()
    {
        return "Controller";
    }

    public static function getClassNameSuffix()
    {
        return "Controller";
    }

    /**
     * The current request
     *
     * @var Strata\Controller\Request
     */
    public $request = null;

    /**
     * The associated view template
     *
     * @var Strata\View\View
     */
    public $view = null;

    /**
     * These hooks allow views to use Wordpress nicely, but still trigger
     * items in the current controller.
     *
     * @var  array
     */
    public $shortcodes = array();


    /**
     * Helpers that will need to be loaded across all the actions of the Controller.
     * @var array
     */
    public $helpers = array();

    public function __construct()
    {}

    /**
     * Initiate the controller.
     * @return null
     */
    public function init()
    {
        $this->request = new Request();
        $this->view = new View();

        $shortcodes = new ShortcodeLoader($this);
        $shortcodes->register();

        $helpers = new HelperLoader($this);
        $helpers->register();
    }

    /**
     * Executed after each calls to a controller action.
     * @return null
     */
    public function after()
    {

    }

    /**
     * Executed before each calls to a controller action.
     * @return null
     */
    public function before()
    {

    }

    /**
     * Base action.
     * @return  null
     */
    public function index()
    {

    }

    /**
     * Base action when no action is found. This is used mainly as a precautionary fallback.
     * @return  null
     */
    public function noActionMatch()
    {

    }
}
