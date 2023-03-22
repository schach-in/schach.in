<?php 

// zzwrap (Zugzwang Project)
// Copyright (c) 2007-2012 Gustaf Mossakowski <gustaf@koenige.org>
// Main script

// root directory
// some providers are not able to configure the root directory correctly
// then you'll have to correct that here
$zz_conf['root'] = $_SERVER['DOCUMENT_ROOT'];
// scripts library
// if your provider does not support putting the include scripts below
// document root, change accordingly
$zz_setting['cms_dir'] = realpath($zz_conf['root'].'/..');

// CMS will be started
require_once $zz_setting['cms_dir'].'/_inc/modules/zzwrap/zzwrap/zzwrap.php';
zzwrap();
