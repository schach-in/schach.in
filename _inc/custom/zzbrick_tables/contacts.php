<?php 

/**
 * schach.in website
 * table definition: contacts
 *
 * Part of »Zugzwang Project«
 * https://www.zugzwang.org/projects/schach.in
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2019-2021 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


$zz_setting['active_module'] = 'contacts';
if (empty($values))
	$values['contactdetails_separate'] = true;
$values['relations'] = [];
require $zz_setting['modules_dir'].'/contacts/zzbrick_tables/contacts.php';

$zz['fields'][1]['field_sequence'] = 30;

$zz['fields'][2]['field_sequence'] = 31;

$zz['fields'][12]['field_sequence'] = 32; // description

$zz['fields'][3]['field_sequence'] = 33;

$zz['fields'][4]['exclude_from_search'] = true;
$zz['fields'][4]['field_sequence'] = 34;

$zz['fields'][5]['field_sequence'] = 35;

foreach (array_keys($zz['fields']) as $no) {
	if ($no < 30 OR $no >= 40) continue;
	$zz['fields'][$no]['field_sequence'] = $no + 10;
}

$zz['fields'][8]['field_sequence'] = 50;

$zz['fields'][13]['field_sequence'] = 75; // remarks
$zz['fields'][13]['title_desc'] = '(intern)';

// @todo just provisionally

$zz['fields'][16]['title_append'] = 'Gründung – Auflösung';
$zz['fields'][16]['title'] = 'Gründung o. ä.';
$zz['fields'][16]['append_next'] = true;
$zz['fields'][16]['field_sequence'] = 69;

$zz['fields'][17]['title'] = 'Auflösung o. ä.';
$zz['fields'][17]['prefix'] = ' – ';
$zz['fields'][17]['field_sequence'] = 70;

$zz['fields'][18]['title'] = 'Politische Einheit';
$zz['fields'][18]['title_tab'] = 'Pol. Einh.';
$zz['fields'][18]['sql'] = 'SELECT country_id, country, main_country_id
	FROM countries
	ORDER BY country_code3';
$zz['fields'][18]['display_field'] = 'country_code';
$zz['fields'][18]['exclude_from_search'] = true;
$zz['fields'][18]['character_set'] = 'latin1';
$zz['fields'][18]['show_hierarchy'] = 'main_country_id';
$zz['fields'][18]['show_hierarchy_subtree'] = $zz_setting['country_ids']['de'];
$zz['fields'][18]['hide_in_list_if_empty'] = true;
$zz['fields'][18]['field_sequence'] = 37;

$zz['fields'][97]['field_sequence'] = 97;
$zz['fields'][97]['export'] = false;

$zz['fields'][99]['field_sequence'] = 99;
$zz['fields'][99]['export'] = false;
