<?php

/*  
|—————————————————————————————————————  
| Default Errors  
|—————————————————————————————————————  
*/

return [

	'bad_request' => [  
		'title' => 'The server cannot or will not process the request due to something that is perceived to be a client error.',  
		'detail' => 'Your request had an error. Please try again.' 
	],

	'forbidden' => [  
		'title' => 'The request was a valid request, but the server is refusing to respond to it.',  
		'detail' => 'Your request was valid, but you are not authorised to perform that action.'  
	],

	'internal_server_error' => [
		'title' => 'Something went wrong. hence, the server declined the request',
		'detail' => 'We will look into it'
	],

	'not_found' => [  
		'title' => 'The requested resource could not be found but may be available again in the future. Subsequent requests by the client are permissible.',  
		'detail' => 'The resource you were looking for was not found.'
	],

	'precondition_failed' => [  
		'title' => 'The server does not meet one of the preconditions that the requester put on the request.',  
		'detail' => 'Your request did not satisfy the required preconditions.'  
	],

	'method_not_allowed' => [
		'title' => 'The server decided to reject the specific HTTP method used.',
		'detail' => 'Your request did not satify the servers HTTP method'
	],

	'unauthorized' => [
		'title' => 'Invalid auth (bad email/password)',
		'detail' => 'Either you need to provide authentication credentials, or the credentials provided are not valid.'
	],

	'token_expired' => [
		'title' => 'Token has Expired',
		'detail' => 'Token has expired due inactivity. Re-login to continue'
	],

	'token_invalid' => [
		'title' => 'Token is Invalid',
		'detail' => 'The token may have been manipulated, hence the server refuse to recognise the user. Try login again'
	],

	'token_absent' => [
		'title' => 'lol3',
		'detail' => 'lol3'
	],

	'user_not_found' => [
		'title' => 'We are unable to find this account',
		'detail' => 'Either you need to provide authentication credentials, or the credentials provided are not valid.'
	],

	

];  
