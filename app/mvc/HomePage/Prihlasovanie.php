<?php

namespace App\Model;

use Nette;
use Nette\Security;
use Nette\Security\AuthenticationException;
use Nette\Security\Identity;

/*
 * Authenticator na prihlasenie uzivatela
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class Prihlasovanie extends Nette\Object implements Nette\Security\IAuthenticator
{
    private $database;

    /*
     * Konstruktor triedy
     */
    function __construct(Nette\Database\Context $databaza)
    {
        $this->database = $databaza;
    }

    /*
     * Funkcia na overovanie uzivatela, ktory sa pokusa prihlasit
     * pouzivatel: meno a heslo, ktore sa overuje
     */
    function authenticate(array $pouzivatel)
    {
        $RodneCislo = $pouzivatel[0];
        $heslo = $pouzivatel[1];
        $zaznam = $this->database->table('zamestnanec')->where('RodneCislo', $RodneCislo)->fetch();
        if ($zaznam == null || $heslo != $zaznam->heslo) //overenie ci taky uzivatel vobec je v db s takym heslom
        {
            throw new AuthenticationException('User not found.');
        }
        else
        {
            return new Identity($zaznam->RodneCislo, $zaznam->funkcia, array('meno' => $zaznam->meno . ' ' . $zaznam->priezvisko)); //vratenie uzivatela
        }
    }
}
