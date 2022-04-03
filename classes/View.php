<?php
class View
{
	protected $context;

	public function __construct( Context $context )
	{
		$this->context	= $context;
	}

	public function render( $data ): string
	{
		$d = (object) array_merge( ['expression' => ''], $data );

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
			<input type="text" name="expression" id="input_expression" value="'.htmlentities( $d->expression, ENT_QUOTES, 'UTF-8' ).'">
		</form>
	</div>
	<hr/>
	<div id="output">
	</div>
</div>';

		$page	= new UI_HTML_PageFrame();
		$page->addStylesheet( 'https://cdn.ceusmedia.de/css/bootstrap.min.css');
		$page->addStylesheet( 'https://cdn.ceusmedia.de/fonts/Fira/fira.css' );
		$page->addStylesheet( 'style.css' );
		$page->addJavaScript( 'https://cdn.ceusmedia.de/js/jquery/1.10.2.min.js' );
		$page->addJavaScript( 'https://cdn.ceusmedia.de/js/bootstrap.min.js' );
		$page->addJavaScript( 'script.js' );
		$page->addBody( $body );
		return $page->build();
	}
}
