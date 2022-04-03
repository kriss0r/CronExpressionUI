<?php
use Cron\CronExpression;
use Lorisleiva\CronTranslator\CronTranslator;

class AjaxController
{
	protected $context;
	protected $request;

	public function __construct( Context $context )
	{
		$this->context	= $context;
		$this->request	= $context->getRequest();
	}

	public function validate()
	{
		$expression	= trim( $this->request->get( 'expression' ) ?? '' );
		$isValid	= FALSE;
		if( $expression ){
			$isValid	= CronExpression::isValidExpression( $expression );
		}
		$this->respond( ['valid' => $isValid] );
	}

    public function view()
    {
        $expression	= trim( $this->request->get( 'expression' ) ?? '' );
        $hint   = '<em class="muted">invalid</em>';
        $next   = '<em class="muted">–</em>';
        $prev   = '<em class="muted">–</em>';
		if( CronExpression::isValidExpression( $expression ) ){
			try{
				$hint	= CronTranslator::translate( $expression, $this->context->getLocale(), TRUE ).'.';
			}
			catch( Exception $e ){
				$hint	= '<em class="muted">not supported</em>';
			}
			$cron	= new CronExpression( $expression );
			$next	= $cron->getNextRunDate()->format('Y-m-d H:i:s');
			$prev	= $cron->getPreviousRunDate()->format('Y-m-d H:i:s');
		}
        $output = join( PHP_EOL, [
            '<label class="small">Meaning</label>',
    		'<div class="output" id="output_hint">'.$hint.'</div>',
    		'<label class="small" for="output_next">Next Run</label>',
    		'<div class="output" id="output_next">'.$next.'</div>',
    		'<label class="small" for="output_prev">Prev Run</label>',
    		'<div class="output" id="output_prev">'.$prev.'</div>',
        ] );
        $this->respond( ['output' => $output] );
    }

	protected function respond( $data, $status = 'success', $code = 200 )
	{
		header( 'Content-Type: application/json' );
		print json_encode( [
			'status'	=> $status,
			'code'		=> $code,
			'data'		=> $data,
		] );
		exit;
	}
}
