<?php


class OdesilacEmailu
{


	public function odesli(string $komu, string $predmet, string $zprava, string $od): void
	{
		$hlavicka = "From: " . $od;
		$hlavicka .= "\nMIME-Version: 1.0\n";
		$hlavicka .= "Content-Type: text/html; charset=\"utf-8\"\n";
		if (!mb_send_mail($komu, $predmet, $zprava, $hlavicka))
			throw new ChybaUzivatele('Email se nepodařilo odeslat.');
	}


	public function odesliSAntispamem(string $rok, string $komu, string $predmet, string $zprava, string $od): void
	{
		if ($rok != date("Y"))
			throw new ChybaUzivatele('Chybně vyplněný antispam.');
		$this->odesli($komu, $predmet, $zprava, $od);
	}

}