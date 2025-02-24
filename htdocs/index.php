<?php

session_start();
mb_internal_encoding("UTF-8");

function autoloadFunkce(string $trida): void
{

	if (preg_match('/Kontroler$/', $trida))
		require("kontrolery/" . $trida . ".php");
	else
		require("modely/" . $trida . ".php");
}


spl_autoload_register("autoloadFunkce");

Db::pripoj("student.voskh.cz", "calekmichal215", "@motorka19", "calekmichal215");

$smerovac = new SmerovacKontroler();
$smerovac->zpracuj(array($_SERVER['REQUEST_URI']));

$smerovac->vypisPohled();
