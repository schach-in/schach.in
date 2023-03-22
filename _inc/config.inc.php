<?php

// schach.in
// configuration

if (str_starts_with($_SERVER['SERVER_NAME'], 'dev.schach.in')) {
	wrap_setting('canonical_hostname', 'dev.schach.in');
	wrap_setting('multiple_websites', true);
}
