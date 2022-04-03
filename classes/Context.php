<?php
class Context
{
	protected $mode;
	protected $locale;
	protected $timezone;
//	protected $expression;
	protected $headers;
	protected $request;

	public function __construct( string $mode = 'live', string $locale = 'en', string $timezone = 'Europe/Berlin' )
	{
		$this->mode			= $mode;
		$this->locale		= $locale;
		$this->timezone		= $timezone;
		$this->headers		= new ADT_List_Dictionary( getallheaders() );
		$this->request		= new ADT_List_Dictionary( $_REQUEST );
//		$this->expression	= trim( $this->request->get( 'expression' ) ?? '' );
	}

	public function getMode()
	{
		return $this->mode;
	}

	public function getLocale()
	{
		return $this->locale;
	}

	public function getTimezone()
	{
		return $this->timezone;
	}

	public function getHeaders()
	{
		return $this->headers;
	}

	public function getRequest()
	{
		return $this->request;
	}
}
