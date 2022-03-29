<?php

// schach.in
// configuration

if (str_starts_with($_SERVER['SERVER_NAME'], 'dev.schach.in')) {
	$zz_setting['canonical_hostname'] = 'dev.schach.in';
	$zz_setting['multiple_websites'] = true;
}
