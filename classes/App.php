<?php
class App
{
	protected $context;

	public function __construct( string $mode = 'live', string $locale = 'en', string $timezone = 'Europe/Berlin' )
	{
		$this->context	= new Context( $mode, $locale, $timezone );
	}

	public function run()
	{
		$this->dispatch();
	}

	protected function dispatch()
	{
		if( $this->context->getHeaders()->has( 'X-Requested-With' ) ){
			$controller	= new AjaxController( $this->context );
			if( $this->context->getRequest()->has( 'validate' ) )
				$controller->validate();
			else if( $this->context->getRequest()->has( 'view' ) )
				$controller->view();
		}
		else {
			$controller	= new Controller( $this->context );
			$controller->view();
		}
	}
}
