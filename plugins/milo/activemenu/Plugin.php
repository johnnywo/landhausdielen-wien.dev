<?php
/**
 * Created by PhpStorm.
 * User: esletzbichler
 * Date: 06.09.16
 * Time: 17:44
 */

namespace Milo\ActiveMenu;


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


    public function classActivePath($path)
    {
        $path = explode('.', $path);
        $segment = 1;
        foreach($path as $p) {
            if((request()->segment($segment) == $p) == false) {
                return '';
            }
            $segment++;
        }
        return ' active';
    }
}