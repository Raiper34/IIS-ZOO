<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

/*
 * Tovarenska metoda na tlacidla viac, ktore iba redirectuju na danu stranku polozky s viac informaciami
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class ViacButton extends Nette\Object
{
	private $database;
	public $Id; //id niecoco, coho chceme viac informacii, napriklad id zivocicha
	public $stranka; //stranka alebo to coho chceme viac informaci napriklad zivocich

	/*
	 * Konstruktor triedy
	 */
	public function __construct(Nette\Database\Context $databaza, $Id, $stranka)
	{
		$this->database = $databaza;
		$this->Id = $Id; //id polozky
		$this->stranka = $stranka; //druh/zivocich/zamestnanec....
	}

	/*
	 * Vytvori form
	 * Vracia: vytvoreny form
	 */
	public function vytvorit()
	{
		$form = new Form;
		$form->addSubmit('viac', 'Viac')->setAttribute('class', 'btn btn-warning');

		$form->onSuccess[] = array($this, 'uspesne');
		return $form;
	}

	/*
	 * Udalost po uspesnom odoslani formu
	 */
	public function uspesne(Form $form, $hodnoty)
	{
		$form->getPresenter()->redirect($this->stranka, $this->Id);
	}

}
