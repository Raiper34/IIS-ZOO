<?php

namespace App\Model;

use Nette;
use Nette\Security;

class Prihlasovanie extends Nette\Object implements Nette\Security\IAuthenticator
{
	private $database;

    function __construct(Nette\Database\Context $databaza)
    {
        $this->database = $databaza;
    }

    function authenticate(array $pouzivatel)
    {
        $username = $pouzivatel[0];
        $password = $pouzivatel[1];
        $row = $this->database->table('pouzivatelia')->where('meno', $username)->fetch();

        if ($row == null) //overenie ci taky uzivatel vobec je v 
        {
            throw new Nette\Security\AuthenticationException('User not found.');
        }

        /*if (Nette\Security\Passwords::verify($password, $row->heslo) == null) //overenie ci je heslo spravne
        {
            throw new Nette\Security\AuthenticationException('Invalid password.');
        }*/

        if ($password != $row->heslo) //overenie ci je heslo spravne
        {
            throw new Nette\Security\AuthenticationException('Invalid password.');
        }

        return new Nette\Security\Identity($row->id, $row->opravnenie, array('meno' => $row->meno)); //vratenie uzivatela
    }
}

 ?>
