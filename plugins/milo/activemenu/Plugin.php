<?php
/**
 * Created by PhpStorm.
 * User: esletzbichler
 * Date: 06.09.16
 * Time: 17:44
 */

namespace Milo\ActiveMenu;

use System\Classes\PluginBase;


class Plugin extends PluginBase {
    public function pluginDetails()
    {
        return [
            'name' => 'Set Active Menu Item Plugin',
            'description' => 'Provides Active Menu Class.',
            'author' => 'Milo',
            'icon' => 'icon-leaf'
        ];
    }

	public function registerComponents()
	{
		return [
			'Milo\ActiveMenu\Components\ActiveMenuItem' => 'activeMenuItem'
		];
	}
}