<?php

class SpravceUzivatelu
{
    public function vratOtisk(string $heslo): string
    {
        return password_hash($heslo, PASSWORD_DEFAULT);
    }

    public function registruj(string $jmeno, string $email, string $heslo, string $hesloZnovu, string $rok): void
    {
        if ($rok != date('Y')) {
            throw new ChybaUzivatele('Chybně vyplněný antispam.');
        } elseif ($heslo != $hesloZnovu) {
            throw new ChybaUzivatele('Hesla nesouhlasí.');
        }

        $hashedPassword = $this->vratOtisk($heslo);

        $uzivatel = array(
            'name' => $jmeno,
            'email' => $email,
            'password' => $hashedPassword,
        );

        try {
            Db::vloz('user', $uzivatel);
        } catch (PDOException $chyba) {
            throw new ChybaUzivatele('Uživatel s tímto e-mailem je již zaregistrovaný.');
        }
    }

    public function prihlas(string $email, string $heslo): void
    {
        $uzivatel = Db::dotazJeden('
            SELECT iduser, name, email, password, admin
            FROM user
            WHERE email = ?
        ', array($email));

        if (!$uzivatel) {
            throw new ChybaUzivatele('Uživatel s tímto e-mailem neexistuje.');
        }

        if (!password_verify($heslo, $uzivatel['password'])) {
            throw new ChybaUzivatele('Nesprávné heslo.');
        }

        // Nastavení dat uživatele do session
        $_SESSION['uzivatel'] = [
            'iduser' => $uzivatel['iduser'], // Opraven klíč
            'name' => $uzivatel['name'],     // Opraven klíč
            'email' => $uzivatel['email'],
            'admin' => $uzivatel['admin']
        ];
    }

    public function odhlas(): void
    {
        unset($_SESSION['uzivatel']);
    }

    public function vratUzivatele(): array|null
    {
        return $_SESSION['uzivatel'] ?? null;
    }
}

//