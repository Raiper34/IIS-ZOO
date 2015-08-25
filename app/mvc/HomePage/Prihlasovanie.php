<?php

namespace App\Model;

use Nette;
use Nette\Security;

/*
 * Prihlasovanie uzivatela
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
        dump($zaznam);
        if ($zaznam == null) //overenie ci taky uzivatel vobec je v 
        {
            throw new Nette\Security\AuthenticationException('Používateľ sa nenašiel!');
        }

        /*if (Nette\Security\heslos::verify($heslo, $zaznam->heslo) == null) //overenie ci je heslo spravne
        {
            thzaznam new Nette\Security\AuthenticationException('Invalid heslo.');
        }*/

        if ($heslo != $zaznam->heslo) //overenie ci je heslo spravne
        {
            throw new Nette\Security\AuthenticationException('Nesprávne heslo!');
        }

        return new Nette\Security\Identity($zaznam->RodneCislo, $zaznam->funkcia, array('meno' => $zaznam->meno)); //vratenie uzivatela
    }
}

 ?>
