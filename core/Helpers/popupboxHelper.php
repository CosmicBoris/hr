<?php

/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 14.03.2016
 * Time: 9:51
 */
class popupboxHelper
{
	private static $output;

	static function Form($id, $title = false, $buttons = false)
	{
		if(!$buttons){
			$buttons[0] = "YES";
			$buttons[1] = "NO";
		}
		self::$output = <<< TX
		<div class="popupbox" id="$id" role="alert">
			<div class="popupbox-container">
				<p>$title</p>
					<ul class="cd-buttons">
						<li><a id="pub_ok">$buttons[0]</a></li>
						<li><a id="pub_no">$buttons[1]</a></li>
					</ul>
				<a href="#" class="popupbox-close"></a>
			</div>
		</div>
TX;
		return self::$output;
	}
}