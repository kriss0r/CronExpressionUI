<?php
use Cron\CronExpression;
use Lorisleiva\CronTranslator\CronTranslator;

class Controller
{
	protected $context;
	protected $request;

	public function __construct( Context $context )
	{
		$this->context	= $context;
		$this->request	= $context->getRequest();
	}

	public function view()
	{
		$view	= new View( $this->context );
		$defaultExpression  = '*/15 * * * *';

		$expression	= trim( $this->request->get( 'expression' ) );
		$expression = strlen( $expression ) ?: $defaultExpression;
		print $view->render( ['expression' => $expression] );
		exit;
	}
}
