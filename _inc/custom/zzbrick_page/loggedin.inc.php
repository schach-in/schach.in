<?php 

/**
 * schach.in website
 * page element: login name
 *
 * Part of »Zugzwang Project«
 * https://www.zugzwang.org/projects/schach.in
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2012, 2016-2017, 2022 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


function page_loggedin() {
	if (empty($_SESSION['person'])) return '';
	return $_SESSION['person'];
}
