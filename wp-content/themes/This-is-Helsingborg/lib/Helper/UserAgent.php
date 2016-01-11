<?php
	
namespace Helsingborg\Helper;

class UserAgent
{
	
	public function __construct($mode = false)
    {
    }
	
	public function isBot() {
	    
	    //Transparent mode, same for all (do not detect boots). 
	    if($mode) { return false; }
	    
	    $crawlers = array(
			'Google' => 'Google',
			'MSN' => 'msnbot',
			'MSN 2' => 'msn',
			'Rambler' => 'Rambler',
			'Yahoo' => 'Yahoo',
			'Yahoo 2' => 'slurp',
			'AbachoBOT' => 'AbachoBOT',
			'accoona' => 'Accoona',
			'AcoiRobot' => 'AcoiRobot',
			'ASPSeek' => 'ASPSeek',
			'CrocCrawler' => 'CrocCrawler',
			'Dumbot' => 'Dumbot',
			'FAST-WebCrawler' => 'FAST-WebCrawler',
			'GeonaBot' => 'GeonaBot',
			'Gigabot' => 'Gigabot',
			'Lycos spider' => 'Lycos',
			'MSRBOT' => 'MSRBOT',
			'Altavista robot' => 'Scooter',
			'AltaVista robot' => 'Altavista',
			'ID-Search Bot' => 'IDBot',
			'eStyle Bot' => 'eStyle',
			'Scrubby robot' => 'Scrubby',
			'Facebook' => 'facebookexternalhit',
			'inktomi' => 'inktomi'
		);
		
		if (strpos(implode('|',$crawlers), $_SERVER['HTTP_USER_AGENT']) === false) {
			return false;
		} else {
		    return true;
		}

    }
}