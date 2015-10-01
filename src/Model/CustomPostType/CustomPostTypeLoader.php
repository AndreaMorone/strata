<?php
namespace Strata\Model\CustomPostType;

use Strata\Strata;
use Strata\Utility\Hash;
use Strata\Model\CustomPostType\CustomPostType;
use Strata\Core\StrataConfigurableTrait;

class CustomPostTypeLoader
{
    use StrataConfigurableTrait;

    public function load()
    {
        $this->logAutoloadedEntities();

        foreach ($this->getConfiguration() as $cpt => $config) {

            $obj = CustomPostType::factory($cpt);

            $this->addWordpressRegisteringAction($obj);

            if ($this->shouldAddAdminMenus($obj)) {
                $this->addWordpressMenusRegisteringAction($obj);
            }

            if ($this->shouldAddRoutes($obj)) {
                $this->addResourceRoute($obj);
            }
        }
    }

    private function logAutoloadedEntities()
    {
        $app = Strata::app();
        $cpts = array_keys($this->getConfiguration());
        $app->log(sprintf("Found %s custom post types : %s", count($cpts), implode(", ", $cpts)), "[Strata:CustomPostTypeLoader]");
    }

    private function shouldAddAdminMenus(CustomPostType $customPostType)
    {
        return is_admin() && count($customPostType->admin_menus) > 0;
    }

    private function addWordpressMenusRegisteringAction(CustomPostType $customPostType)
    {
        $customPostType->registerAdminMenus();
    }

    private function shouldAddRoutes(CustomPostType $customPostType)
    {
        return !is_admin() && $customPostType->routed === true;
    }

    private function addResourceRoute(CustomPostType $customPostType)
    {
        Strata::app()->router->route->addResource($customPostType);
    }

    private function addWordpressRegisteringAction(CustomPostType $customPostType)
    {
        add_action('init', array($customPostType, "register"));
    }
}
