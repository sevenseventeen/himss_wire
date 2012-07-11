<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * 
 * Switch the from and to email addresses depending on the environment (server_name)
 * This way Mark won't get all our testing email's
 * Plus, we need to use KNIGHT1902@roadrunner.com to send using localhost. 
 * But, you'll need to set up MailServe to do this
 * 
 * 
 */

$config['test_mode'] = TRUE;

if ($_SERVER['SERVER_NAME'] == "localhost" || $config['test_mode'] == TRUE) {
    $config['email_from_support']               = 'KNIGHT1902@roadrunner.com';
    $config['email_name_from_admin']		    = 'HIMSSwire Administrator';
	$config['email_name_from_new_accounts']     = 'HIMSSwire New Accounts';
    $config['email_name_from_alerts']           = 'HIMSSwire Alerts';
    $config['email_to_admin'] 					= array('josh@seven-seventeen.com');
} else {
    $config['email_from_support']               = 'support@himsswire.com';
    $config['email_name_from_admin']		    = 'HIMSSwire Administrator';
    $config['email_name_from_new_accounts']     = 'HIMSSwire New Accounts';
    $config['email_name_from_alerts']           = 'HIMSSwire Alerts';
    $config['email_to_admin'] 					= array('josh@seven-seventeen.com');
}

