<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('something', function()
{
    $openid = new LightOpenID(url('/'));

    $openid->identity = 'https://portal.ncu.edu.tw/user/';

    $openid->returnUrl = url('callback');
    $openid->required = array(
			   'user/roles'
		);
    $openid->optional = array(
  			'contact/email',
  			'contact/name',
  			'contact/ename',
  			'student/id',
  			'alunmi/leaveSem',
    );
    return redirect($openid->authUrl());
});

Route::get('callback', function()
{
    $openid = new LightOpenID(url('/'));
    if ($openid->mode) {
      echo $openid->validate() ? 'Logged in....' : 'Failed!';
    }
    $qaq = $openid->getAttributes();
    echo $qaq['student/id'];
});
