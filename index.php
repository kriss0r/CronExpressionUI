<?php
( @include_once 'vendor/autoload.php' ) or die( 'Install first, using composer!'.PHP_EOL );

use Cron\CronExpression;
use Lorisleiva\CronTranslator\CronTranslator;

//  ------------------------------------------------------

//$mode		= 'dev';
$locale		= 'en';
$timezone	= 'Europe/Berlin';

$hint		= '<em class="muted">–</em>';
$next		= '<em class="muted">–</em>';
$prev		= '<em class="muted">–</em>';

//  ------------------------------------------------------

date_default_timezone_set( $timezone );
if( isset( $mode ) && $mode === 'dev' )
	ini_set( 'display_errors', 'On' );

$request		= new ADT_List_Dictionary( $_REQUEST );
$expression		= trim( $request->get( 'expression' ) ?? '' );

if( 0 !== strlen( $expression ) ){
	$hint	= '<em class="muted">invalid</em>';
	if( CronExpression::isValidExpression( $expression ) ){
		try{
			$hint	= CronTranslator::translate( $expression, $locale, TRUE ).'.';
		}
		catch( Exception $e ){
			$hint	= '<em class="muted">not supported</em>';
		}
		$cron	= new CronExpression( $expression );
		$next	= $cron->getNextRunDate()->format('Y-m-d H:i:s');
		$prev	= $cron->getPreviousRunDate()->format('Y-m-d H:i:s');
	}
}

$body	= '
<div class="container">
	<div class="hero-unit">
		<h1>
			<span class="not-muted">
				<span style="font-weight: 200">Cron</span>
				<span style="font-weight: 400">Expression</span>
				<span style="font-weight: 800">UI</span>
			</span>
		</h1>
	</div>
	<div id="input">
		<form action="./" method="GET">
			<label class="small">CRON Expression</label>
			<input type="text" name="expression" id="input_expression" value="'.htmlentities( $expression, ENT_QUOTES, 'UTF-8' ).'">
		</form>
	</div>
	<hr/>
	<div id="output">
		<label class="small">Meaning</label>
		<div class="output" id="output_hint">'.$hint.'</div>
		<label class="small" for="output_next">Next Run</label>
		<div class="output" id="output_next">'.$next.'</div>
		<label class="small" for="output_prev">Prev Run</label>
		<div class="output" id="output_prev">'.$prev.'</div>
	</div>
</div>';

$page	= new UI_HTML_PageFrame();
$page->addStylesheet( 'https://cdn.ceusmedia.de/css/bootstrap.min.css');
$page->addStylesheet( 'https://cdn.ceusmedia.de/fonts/Fira/fira.css' );
$page->addStylesheet( 'style.css' );
$page->addBody( $body );
print $page->build();
