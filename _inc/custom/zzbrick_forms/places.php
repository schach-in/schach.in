<?php 

/**
 * schach.in website
 * form definition: places
 *
 * Part of »Zugzwang Project«
 * https://www.zugzwang.org/projects/schach.in
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2019-2021 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


$values['contactdetails_restrict_to'] = 'places';
$values['relations'] = [];

$zz_setting['active_module'] = 'contacts';
require $zz_conf['form_scripts'].'/contacts.php';

$zz['title'] = 'Veranstaltungsorte';

$zz['fields'][1]['field_sequence'] = 1;

// contact
$zz['fields'][2]['title'] = 'Veranstaltungsort';
$zz['fields'][2]['explanation'] = 'Name der Einrichtung/Unterkunft';
$zz['fields'][2]['field_sequence'] = 2;

// identifier
$zz['fields'][3]['export'] = false;
$zz['fields'][3]['field_sequence'] = 30;
$zz['fields'][3]['unique'] = true;
$zz['fields'][3]['fields'] = [
	'addresses.country_id[country_code]', 'addresses.place', 'contact'
];
$zz['fields'][3]['conf_identifier']['concat'] = '/';
$zz['fields'][3]['conf_identifier']['ignore_this_if_identical']['ortsname'] = 'veranstaltungsort';
$zz['fields'][3]['hide_in_form'] = true;

// contact_category_id
$zz['fields'][4]['hide_in_form'] = true;
$zz['fields'][4]['hide_in_list'] = true;
$zz['fields'][4]['type'] = 'hidden';
$zz['fields'][4]['value'] = wrap_category_id('kontakte/veranstaltungsort');
$zz['fields'][4]['export'] = false;

$zz['fields'][5]['dont_show_missing'] = true;
$zz['fields'][5]['form_display'] = 'inline';
$zz['fields'][5]['list_display'] = 'inline';
$zz['fields'][5]['min_records'] = 1;
$zz['fields'][5]['min_records_required'] = 1;
$zz['fields'][5]['max_records'] = 1;
$zz['fields'][5]['fields'][3]['field_sequence'] = 10;
$zz['fields'][5]['fields'][4]['field_sequence'] = 11;
$zz['fields'][5]['fields'][5]['field_sequence'] = 12;
$zz['fields'][5]['fields'][6]['field_sequence'] = 13;
$zz['fields'][5]['fields'][7]['field_sequence'] = 50;
$zz['fields'][5]['fields'][7]['explanation'] = 'Wird automatisch hinzugefügt';
$zz['fields'][5]['fields'][8]['field_sequence'] = 31;
$zz['fields'][5]['fields'][9]['field_sequence'] = 14;
$zz['fields'][5]['fields'][9]['hide_in_list'] = true; // address_category_id
$zz['fields'][5]['fields'][9]['hide_in_form'] = true; // address_category_id
$zz['fields'][5]['fields'][9]['type'] = 'hidden';
$zz['fields'][5]['fields'][9]['value'] = wrap_category_id('adressen/dienstlich');

$zz['fields'][5]['fields'][6]['sql'] = sprintf('SELECT country_id, country_code, country, main_country_id
	FROM countries
	WHERE country_category_id = %d
	ORDER BY country, country_code3', wrap_category_id('politische-einheiten/staat'));
$zz['fields'][5]['fields'][6]['show_hierarchy'] = 'main_country_id';
$zz['fields'][5]['fields'][6]['default'] = 3; // Deutschland
$zz['fields'][5]['fields'][6]['add_details'] = '../db/politische-einheiten';

/*
include $zz_conf['form_scripts'].'/contacts-categories.php';
$zz['fields'][27] = $zz_sub;
unset($zz_sub);
$zz['fields'][27]['title'] = 'Kategorien';
$zz['fields'][27]['type'] = 'subtable';
$zz['fields'][27]['form_display'] = 'properties';
$zz['fields'][27]['min_records'] = 1;
$zz['fields'][27]['max_records'] = 3;
$zz['fields'][27]['fields'][3]['type'] = 'foreign_key';
$zz['fields'][27]['sql'] .= $zz['fields'][27]['sqlorder'];
*/

$zz['fields'][8]['export'] = false; // latlon

$zz['fields'][12]['explanation'] = 'Anfahrtshinweis etc.';
$zz['fields'][12]['kml'] = 'description';
$zz['fields'][12]['geojson'] = 'description';
$zz['fields'][12]['rows'] = 3;
$zz['fields'][12]['field_sequence'] = 17;

foreach ($zz['fields'] as $no => $field) {
	if ($no < 30 OR $no >= 40) continue;
	$zz['fields'][$no]['fields'][4]['for_action_ignore'] = true;
	$zz['fields'][$no]['hide_in_list'] = true;
	if (!empty($field['fields'][3]['type']) AND $field['fields'][3]['type'] === 'phone') {
		$zz['fields'][$no]['fields'][3]['explanation'] = 'Bitte im Format +49 4551 963356';
	}
}

if (empty($_GET['zz'])) {
	$zz['fields'][24] = zzform_include_table('contacts-contacts');
	$zz['fields'][24]['type'] = 'subtable';
	$zz['fields'][24]['min_records'] = 1;
	$zz['fields'][24]['max_records'] = 20;
	$zz['fields'][24]['form_display'] = 'lines';
	$zz['fields'][24]['title'] = 'Organisationen';
	$zz['fields'][24]['fields'][3]['type'] = 'foreign_key';
	if (!empty($_GET['where']['contact_id'])) {
		$zz['fields'][24]['fields'][2]['unique'] = true;
	}
	$zz['fields'][24]['fields'][2]['suffix'] = '<br>';
	$zz['fields'][24]['fields'][4]['type'] = 'hidden';
	$zz['fields'][24]['fields'][4]['type_detail'] = 'select';
	$zz['fields'][24]['fields'][4]['value'] = wrap_category_id('beziehungen/spielort');
	$zz['fields'][24]['fields'][4]['hide_in_form'] = true;
	$zz['fields'][24]['fields'][4]['def_val_ignore'] = true;
	$zz['fields'][24]['fields'][9]['prefix'] = '<span style="width: 2.4em; display: inline-block;"> </span> ';
	$zz['fields'][24]['fields'][6]['prefix'] = '<span style="width: 2.4em; display: inline-block;">';
	$zz['fields'][24]['fields'][6]['suffix'] = '</span>';
	$zz['fields'][24]['subselect']['sql'] = 'SELECT contacts_contacts.contact_id, contact
		FROM contacts_contacts
		LEFT JOIN contacts
			ON contacts_contacts.main_contact_id = contacts.contact_id
		WHERE contacts_contacts.published = "yes"
		ORDER BY contact
	';
	$zz['fields'][24]['field_sequence'] = 20;
}

unset($zz['fields'][10]); // contacts_short
unset($zz['fields'][14]); // published
unset($zz['fields'][15]); // parameters

unset($zz['fields'][16]); // start_date
unset($zz['fields'][17]); // end_date
unset($zz['fields'][18]); // country_id

$zz['sql'] = sprintf('SELECT contacts.*
		, categories.category, country_code, address_types.category AS address_type
	FROM contacts
	LEFT JOIN categories
		ON contacts.contact_category_id = categories.category_id
	LEFT JOIN addresses USING (contact_id)
	LEFT JOIN countries
		ON addresses.country_id = countries.country_id
	LEFT JOIN categories address_types
		ON addresses.address_category_id = address_types.category_id
	WHERE contact_category_id = %d
', wrap_category_id('kontakte/veranstaltungsort'));
$zz['sqlorder'] = ' ORDER BY country_code, postcode, contact, identifier';

unset($zz['filter'][1]);

$zz['explanation'] = '<p>In dieser Datenbank sind viele Spielorte und auch Veranstaltungsorte gespeichert, an denen z.B. Lehrgänge stattgefunden haben.</p>';
$zz['geo_map_head'] = 'leaflet-markercluster-map-head';
$zz['geo_map_html'] = 'leaflet-markercluster-mapbox-zzform-map';
$zz['geo_map_export'] = 'geojson';

$zz_conf['export'] = ['KML', 'GeoJSON'];
