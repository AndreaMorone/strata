<?php
namespace Strata\Model\CustomPostType\Registrar;

use Strata\Router\Router;
use Strata\Controller\Controller;
use Strata\Model\CustomPostType\Registrar\Registrar;
use Strata\Core\StrataConfigurableTrait;

class CustomPostTypeAdminMenuRegistrar extends Registrar
{
    use StrataConfigurableTrait;

    public function register()
    {
        if (count($this->getConfiguration())) {
            add_action('admin_menu', array($this, 'action_addAdminMenus'));
        }
    }

    public function action_addAdminMenus()
    {
        // Default to the model's likely controller.
        $defaultController = Controller::generateClassName($this->entity->getShortName());
        $parentSlug = 'edit.php?post_type=' . $this->entity->getWordpressKey();

        foreach ($this->getConfiguration() as $func => $config) {
            $config += array(
                'title'         => ucfirst($func),
                'menu-title'    => ucfirst($func),
                'capability'    => "manage_options",
                'icon'          => null,
                'route'         => array($defaultController, $func),
                'position'      => null,
            );

            // This is to circumvent that wordpress doesn't let you pass arguments to
            // callbacks so we can send the controller and function to the router.
            // We dont want people to have to specify that odd function name.
            // Allow them to send the controller string name and take care of the rest.
            if (is_string($config['route'])) {
                $route = Router::callback($config['route'], $func);
            }  else {
                $route = Router::callback($config['route'][0], $config['route'][1]);
            }

            $uniquePage = $this->entity->getWordpressKey() . "_" . $func;
            add_submenu_page($parentSlug, $config['title'], $config['menu-title'], $config['capability'], $uniquePage, $route, $config['icon'], $config['position']);
        }
    }
}
