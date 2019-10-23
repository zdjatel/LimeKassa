<?php

class MainController extends Controller
{



	function render($f3)
	{


		$f3->set('name', $this->f3->get('SESSION.user'));

		$doknr = $this->f3->get('SESSION.doknr');
		$doknr++;
		$f3->set('doknr', $doknr);

		$f3->set('date', date("d.m.y H:i"));
		$template = new Template;
		echo $template->render('kassa.html');

		$f3->set('SESSION.doknr', $doknr);
	}

	function sayhello()
	{
		echo 'Hello, babe!';
	}
}
