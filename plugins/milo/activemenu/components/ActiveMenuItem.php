<?php
/**
 * Created by PhpStorm.
 * User: milo
 * Date: 06.09.16
 * Time: 18:49
 */

namespace Milo\ActiveMenu\Components;


class ActiveMenuItem extends \Cms\Classes\ComponentBase
{
	public function componentDetails()
	{
		return [
			'name' => 'Active Menu Item',
			'description' => 'returns if an menu item active is'
		];
	}

	public function isActive($path)
	{
		$path = explode('.', $path);
		$segment = 1;
		foreach($path as $p) {
			if((request()->segment($segment) == $p) == false) {
				return '';
			}
			$segment++;
		}
		return TRUE;
	}

}