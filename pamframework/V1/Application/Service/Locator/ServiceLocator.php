<?php

namespace pam\V1\Application\Service\Locator;

class ServiceLocator
{
    private static $_config = null;
    private static function getConfig()
    {
        $modules = array (
            PAM_PATH."/Application/Service/Product/Conf/service.con"
		);
		$config = array ();
		foreach ($modules as $module) {
            $config= array_merge($config, self::loadModuleConfig($module));
		}
		self::$_config = $config;
	}

    private static function loadModuleConfig($path)
    {
        return include $path;
    }
    public static function getService($serviceName)
    {
        if (self::$_config == null) {
            self::getConfig();
        }
        return call_user_func(self::$_config[$serviceName]);
    }
}
