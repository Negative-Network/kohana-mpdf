<?php defined('SYSPATH') or die('No direct script access.');

if (!defined('_MPDF_PATH')) define('_MPDF_PATH', dirname(MODPATH.basename(__DIR__).DIRECTORY_SEPARATOR.'mpdf').DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'mpdf'.DIRECTORY_SEPARATOR);

// Loads mPDF
require_once Kohana::find_file('vendor', 'mpdf/mpdf');
