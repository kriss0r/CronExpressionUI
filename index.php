<?php
( @include_once 'vendor/autoload.php' ) or die( 'Install first, using composer!'.PHP_EOL );

use Cron\CronExpression;
use Lorisleiva\CronTranslator\CronTranslator;

//  ------------------------------------------------------

$mode		= 'dev';
$locale		= 'en';

$hint		= '–';
$next		= '–';
$prev		= '–';

//  ------------------------------------------------------

if( isset( $mode ) && $mode === 'dev' )
	ini_set( 'display_errors', 'On' );

$request		= new ADT_List_Dictionary( $_REQUEST );
$expression		= $request->get( 'expression' );

if( $expression ){
	$hint	= 'invalid';
	if( CronExpression::isValidExpression( $expression ) ){
		$hint	= CronTranslator::translate( $expression, $locale, TRUE ).'.';
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
</div>
';

$head	= '
<link type="text/css" rel="stylesheet" media="all" href="https://cdn.ceusmedia.de/fonts/Fira/fira.css"/>
<style>
body * {
	font-family: "Fira Sans";
	}
.hero-unit h1 {
	font-family: "Fira Sans";
	}
label.small {
	text-transform: uppercase;
	font-weight: light;
	font-size: 0.9rem;
	color: #666;
	padding-top: 0.25rem;
	padding-left: 0.15rem;
	}
input#input_expression {
	display: block;
	width: 98%;
	height: auto;
	font-size: 3rem;
	font-family: "Fira Mono";
	}
div.output {
	font-size: 2rem;
	padding-bottom: 0.5rem;
	line-height: 1.1em;
	}
#input,
#output {
	padding: 0 60px !important;
	}
</style>
';

$page	= new UI_HTML_PageFrame();
$page->addStylesheet('https://cdn.ceusmedia.de/css/bootstrap.min.css');
$page->addHead( $head );
$page->addBody( $body );
print $page->build();
