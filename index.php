<?php
( @include_once 'vendor/autoload.php' ) or die( 'Install first, using composer!'.PHP_EOL );

use Cron\CronExpression;
use Lorisleiva\CronTranslator\CronTranslator;

//  ------------------------------------------------------

$mode		= 'dev';
$locale		= 'en';
$timezone	= 'Europe/Berlin';

//  ------------------------------------------------------

date_default_timezone_set( $timezone );
if( isset( $mode ) && $mode === 'dev' )
	ini_set( 'display_errors', 'On' );

new Loader( 'php', NULL, 'classes/' );

(new App)->run( $mode, $locale, $timezone );
