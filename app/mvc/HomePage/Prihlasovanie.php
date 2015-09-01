<?php

namespace App\Model;

use Nette;
use Nette\Security;

/*
 * Authenticator na prihlasenie uzivatela
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class Prihlasovanie extends Nette\Object implements Nette\Security\IAuthenticator
{
    private $database;

    function __construct(Nette\Database\Context $databaza)
    {
        $this->database = $databaza;
    }

    function authenticate(array $pouzivatel)
    {
        $RodneCislo = $pouzivatel[0];
        $heslo = $pouzivatel[1];
        $zaznam = $this->database->table('zamestnanec')->where('RodneCislo', $RodneCislo)->fetch();
        if ($zaznam == null) //overenie ci taky uzivatel vobec je v db
        {
            throw new Nette\Security\AuthenticationException('Používateľ sa nenašiel!');
        }

        if ($heslo != $zaznam->heslo) //overenie ci je heslo spravne
        {
            throw new Nette\Security\AuthenticationException('Nesprávne heslo!');
        }

        return new Nette\Security\Identity($zaznam->RodneCislo, $zaznam->funkcia, array('meno' => $zaznam->meno . ' ' . $zaznam->priezvisko)); //vratenie uzivatela
    }
}
