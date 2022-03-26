<?php 

/**
 * schach.in website
 * table definition: organisations (based on contacts)
 *
 * Part of »Zugzwang Project«
 * https://www.zugzwang.org/projects/schach.in
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2006-2021 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


$values['contactdetails_restrict_to'] = 'organisations';
$zz = zzform_include_table('contacts', $values);

$zz['title'] = 'Organisationen';

// contact_category_id
$zz['fields'][4]['sql'] = sprintf('SELECT category_id, category
		, IF(parameters LIKE "%%&has_place_contact=1%%", 1, NULL) AS has_place_contact
		, IF(parameters LIKE "%%&has_place_contact=1%%", NULL, 1) AS has_address
	FROM /*_PREFIX_*/categories
	WHERE main_category_id = %d
	ORDER BY sequence, category',
	wrap_category_id('contact')
);
$zz['fields'][4]['sql_ignore'] = ['has_place_contact', 'has_address'];
$zz['fields'][4]['dependent_fields'][76]['if_selected'] = 'has_place_contact';
$zz['fields'][4]['dependent_fields'][5]['if_selected'] = 'has_address';

// contact
$zz['fields'][2]['title'] = 'Name';
$zz['fields'][2]['type'] = 'text';
$zz['fields'][2]['link'] = [
	'string1' => 'https://schach.in'.($zz_setting['local_access'] ? '.local' : '').'/',
	'field1' => 'identifier',
	'string2' => '/'
];

// contact_short
$zz['fields'][10]['title'] = 'Name, kurz';
$zz['fields'][10]['hide_in_list'] = true;
$zz['fields'][10]['field_sequence'] = 32;

$zz['fields'][11]['title'] = 'Name, Abk.';
$zz['fields'][11]['field_name'] = 'contact_abbr';
$zz['fields'][11]['type'] = 'text';
$zz['fields'][11]['hide_in_list'] = true;
$zz['fields'][11]['field_sequence'] = 32.5;

$zz['fields'][3]['title'] = 'Kennung (DSJ)';
$zz['fields'][3]['conf_identifier']['concat'] = '-';
$zz['fields'][3]['conf_identifier']['remove_strings'] = [' e.V.', ' e. V.', ' e. V.', ' eV.', ' eV'];
$zz['fields'][3]['field_sequence'] = 44;

$zz['fields'][4]['title'] = 'Typ';
//$zz['fields'][4]['id_field_name'] = 'category_id';
//$zz['fields'][4]['character_set'] = 'utf8';
$zz['fields'][4]['hide_in_list'] = true;
$zz['fields'][4]['field_sequence'] = 1;

// remarks
$zz['fields'][13]['rows'] = 6;

$zz['fields'][12]['field_sequence'] = 36; // description

// website

for ($i = 30; $i <= 40; $i++) {
	if (empty($zz['fields'][$i])) continue;
	$zz['fields'][$i]['field_sequence'] = $i + 15;
	if ($zz['fields'][$i]['table_name'] === sprintf('contactdetails_%d', wrap_category_id('provider/website'))) {
		$zz['fields'][$i]['field_sequence'] = 33;
		$zz['fields'][$i]['display_field'] = 'website';
		$zz['fields'][$i]['list_prefix'] = '<a href="';
		$zz['fields'][$i]['list_suffix'] = '">www</a>';
		$zz['fields'][$i]['list_no_link'] = true;
		$zz['fields'][$i]['dont_mark_search_string'] = true;
		$zz['fields'][$i]['unless']['export_mode']['list_append_next'] = false;
	}
	unset($zz['fields'][$i]['subselect']);
}

// published
unset($zz['fields'][14]);

// parameters
unset($zz['fields'][15]);

$zz['fields'][76] = zzform_include_table('contacts-contacts');
$zz['fields'][76]['title'] = 'Spielorte';
$zz['fields'][76]['type'] = 'subtable';
$zz['fields'][76]['min_records'] = 1;
$zz['fields'][76]['max_records'] = 20;
$zz['fields'][76]['type'] = 'subtable';
$zz['fields'][76]['form_display'] = 'lines';
$zz['fields'][76]['fields'][2]['type'] = 'foreign_key';
$zz['fields'][76]['fields'][2]['key_field_name'] = 'contact_id';
$zz['fields'][76]['fields'][3]['suffix'] = '<br>';
$zz['fields'][76]['fields'][4]['type'] = 'hidden';
$zz['fields'][76]['fields'][4]['type_detail'] = 'select';
$zz['fields'][76]['fields'][4]['value'] = wrap_category_id('beziehungen/spielort');
$zz['fields'][76]['fields'][4]['hide_in_form'] = true;
$zz['fields'][76]['fields'][4]['def_val_ignore'] = true;
$zz['fields'][76]['fields'][9]['prefix'] = '<span style="width: 2.4em; display: inline-block;"> </span> ';
$zz['fields'][76]['fields'][6]['prefix'] = '<span style="width: 2.4em; display: inline-block;">';
$zz['fields'][76]['fields'][6]['suffix'] = '</span>';
$zz['fields'][76]['subselect']['sql'] = 'SELECT contacts_contacts.main_contact_id, postcode, place
		, places.contact_id, places.contact
	FROM contacts_contacts
	LEFT JOIN contacts places
		ON contacts_contacts.contact_id = places.contact_id
	LEFT JOIN addresses
		ON addresses.contact_id = places.contact_id
	WHERE contacts_contacts.published = "yes"
	ORDER BY sequence, postcode, place, contact
';
$zz['fields'][76]['subselect']['field_prefix'][2] = ' / <a href="/intern/orte/?edit=';
$zz['fields'][76]['subselect']['field_suffix'][2] = '">';
$zz['fields'][76]['subselect']['field_suffix'][3] = '</a>';
$zz['fields'][76]['hide_in_list'] = false;
$zz['fields'][76]['sql'] .= 'ORDER BY sequence, postcode, place, contact';
$zz['fields'][76]['foreign_key_field_name'] = 'contacts_contacts.main_contact_id';
$zz['fields'][76]['field_sequence'] = 38;
$zz['fields'][76]['list_append_next'] = true;

// address
$zz['fields'][77] = $zz['fields'][5];
unset($zz['fields'][5]);

$zz['fields'][77]['fields'][9]['type'] = 'hidden';
$zz['fields'][77]['fields'][9]['value'] = wrap_category_id('adressen/dienstlich');
$zz['fields'][77]['fields'][9]['hide_in_form'] = true;
$zz['fields'][77]['field_sequence'] = 37;
$zz['fields'][77]['list_append_next'] = false;

$zz['fields'][74]['title'] = 'Mutterorganisation';
$zz['fields'][74]['field_name'] = 'mother_contact_id';
$zz['fields'][74]['type'] = 'select';
$zz['fields'][74]['sql'] = 'SELECT contacts.contact_id, contact, mother_contact_id
		, contacts_identifiers.identifier AS zps_code
	FROM contacts
	LEFT JOIN contacts_identifiers
		ON contacts_identifiers.contact_id = contacts.contact_id
		AND contacts_identifiers.current = "yes"
	ORDER BY contacts_identifiers.identifier, contact_abbr';
$zz['fields'][74]['show_hierarchy'] = 'mother_contact_id';
$zz['fields'][74]['id_field_name'] = 'contacts.contact_id';
//$zz['fields'][74]['key_field_name'] = 'contacts.contact_id';
$zz['fields'][74]['sql_fieldnames_ignore'] = ['contacts.contact_id'];
$zz['fields'][74]['display_field'] = 'mutter_org';
$zz['fields'][74]['search'] = 'mutter_orgs.contact_short';
$zz['fields'][74]['character_set'] = 'utf8';
$zz['fields'][74]['hide_in_list'] = true;
if (isset($_GET['where']['mother_contact_id'])) {
	$zz['fields'][74]['class'] = 'hidden';
}
$zz['fields'][74]['show_hierarchy_same_table'] = true;
$zz['fields'][74]['separator'] = true;
$zz['fields'][74]['field_sequence'] = 40;

// Verein
$zz['fields'][75] = zzform_include_table('contacts-identifiers');
$zz['fields'][75]['title'] = 'Kennungen';
$zz['fields'][75]['type'] = 'subtable';
$zz['fields'][75]['form_display'] = 'lines';
$zz['fields'][75]['fields'][2]['type'] = 'foreign_key';
$zz['fields'][75]['fields'][4]['sql'] = wrap_edit_sql(
	$zz['fields'][75]['fields'][4]['sql'],
	'WHERE', 'parameters LIKE "%&organisation=1%"'
);
$zz['fields'][75]['hide_in_list'] = true;
$zz['fields'][75]['field_sequence'] = 42;

$zz['fields'][73]['field_name'] = 'ZPS';
$zz['fields'][73]['type'] = 'display';
$zz['fields'][73]['display_field'] = 'zps_code';
$zz['fields'][73]['hide_in_form'] = true;
$zz['fields'][73]['search'] = 'contacts_identifiers.identifier';

$zz['fields'][72]['title'] = 'Nachfolgerin';
$zz['fields'][72]['field_name'] = 'successor_contact_id';
$zz['fields'][72]['type'] = 'select';
$zz['fields'][72]['sql'] = 'SELECT contacts.contact_id, contact
		, contacts_identifiers.identifier AS zps_code, mother_contact_id
	FROM contacts
	LEFT JOIN contacts_identifiers
		ON contacts_identifiers.contact_id = contacts.contact_id
		AND contacts_identifiers.current = "yes"
	ORDER BY contacts_identifiers.identifier, contact_abbr';
// @todo eigene ID nicht anzeigen
$zz['fields'][72]['show_hierarchy'] = 'mother_contact_id';
$zz['fields'][72]['show_hierarchy_same_table'] = true;
$zz['fields'][72]['hide_in_list'] = true;
$zz['fields'][72]['field_sequence'] = 72;
$zz['fields'][72]['id_field_name'] = 'contacts.contact_id';

$zz['sql'] = 'SELECT contacts.*
		, mutter_orgs.contact_short AS mutter_org
		, country_code
		, category
		, contacts_identifiers.identifier AS zps_code
		, (SELECT CONCAT(latitude, ",", longitude) FROM /*_PREFIX_*/addresses
			WHERE /*_PREFIX_*/addresses.contact_id = /*_PREFIX_*/contacts.contact_id
			LIMIT 1) AS latlon
		, /*_PREFIX_*/categories.parameters AS contact_parameters
		, (SELECT identification FROM contactdetails
			WHERE contactdetails.contact_id = contacts.contact_id
			AND provider_category_id = %d
			LIMIT 1
		) AS website
	FROM contacts
	LEFT JOIN contacts AS mutter_orgs
		ON contacts.mother_contact_id = mutter_orgs.contact_id
	LEFT JOIN contacts_identifiers
		ON contacts_identifiers.contact_id = contacts.contact_id
		AND contacts_identifiers.current = "yes"
	LEFT JOIN countries 
		ON countries.country_id = contacts.country_id
	LEFT JOIN categories
		ON categories.category_id = contacts.contact_category_id
	WHERE categories.parameters LIKE "%%&organisation=1%%"
';
$zz['sql'] = sprintf($zz['sql'], wrap_category_id('provider/website'));
$zz['sqlorder'] = ' ORDER BY contacts_identifiers.identifier, contacts.identifier';

$zz['subtitle']['mother_contact_id']['sql'] = $zz['fields'][74]['sql'];
$zz['subtitle']['mother_contact_id']['var'] = ['contact'];

//$zz['list']['hierarchy']['mother_id_field_name'] = $zz['fields'][74]['field_name'];
//$zz['list']['hierarchy']['display_in'] = $zz['fields'][3]['field_name'];

$zz['details'][0]['title'] = 'Teilnahmen';
$zz['details'][0]['link'] = 'teilnahmen?where[club_contact_id]=';

$zz['filter'][1]['title'] = 'Typ';
$zz['filter'][1]['sql'] = wrap_edit_sql($zz['filter'][1]['sql'],
	'WHERE', 'categories.parameters LIKE "%&organisation=1%"'
);
$zz['filter'][1]['where'] = 'contacts.contact_category_id';

$zz['filter'][2]['title'] = 'Aktiv';
$zz['filter'][2]['type'] = 'list';
$zz['filter'][2]['where'] = 'contacts.aufloesung';
$zz['filter'][2]['selection']['NULL'] = 'ja';
$zz['filter'][2]['selection']['!NULL'] = 'nein';

$zz['filter'][3]['title'] = 'Alpha';
$zz['filter'][3]['identifier'] = 'alpha';
$zz['filter'][3]['type'] = 'list';
$zz['filter'][3]['where'] = 'UPPER(SUBSTRING(contacts.contact, 1, 1))';
$zz['filter'][3]['sql'] = 'SELECT DISTINCT 
		UPPER(SUBSTRING(contacts.contact, 1, 1)), 
		UPPER(SUBSTRING(contacts.contact, 1, 1))
	FROM contacts
	LEFT JOIN categories
		ON categories.category_id = contacts.contact_category_id
	WHERE categories.parameters LIKE "%&organisation=1%"
	ORDER BY UPPER(SUBSTRING(contacts.contact, 1, 1))';

if (!empty($_GET['filter']['typ'])) {
	$zz['list']['hierarchy'] = [];
}

$zz['set_redirect'][] = [
	'old' => '/%s/', 'new' => '/%s/', 'field_name' => 'identifier', 'website_id' => wrap_id('websites', 'schach.in')
];
$zz['revisions'] = true;
