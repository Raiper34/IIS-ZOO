<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;

/*
 * Tovarna na editacne formy umiestnenia
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class EditovatUmiestnenieForm extends Nette\Object
{
	private $database;
	private $mod; //0 je klietka 1 je vybeh, aby som vedel co editujem
	public $Id; //id aby sme vedeli, koho editujeme

	/*
	 * Konstruktor triedy
	 */
	public function __construct(Nette\Database\Context $databaza, $mod)
	{
		$this->database = $databaza;
		$this->mod = $mod;
	}

	/*
	 * Vytvori form na editovanie 
	 * Vracia: vytvoreny form
	 */
	public function vytvorit()
	{
		$form = new Form;
		$umiestnenie = $form->addContainer('umiestnenie');
		$umiestnenie->addText('nazov', '*Názov:')->setRequired();
		$umiestnenie->addText('sirka', 'Šírka:')->addCondition(Form::FILLED)->addRule(Form::FLOAT, 'Pole musi obsahovať iba čísla!');
		$umiestnenie->addText('dlzka', 'Dĺžka:')->addCondition(Form::FILLED)->addRule(Form::FLOAT, 'Pole musi obsahovať iba čísla!');
		$umiestnenie->addText('vyska', 'Výška:')->addCondition(Form::FILLED)->addRule(Form::FLOAT, 'Pole musi obsahovať iba čísla!');

		if($this->mod == 0) //editujem typ klietka do formu davam klietkove polozky
		{
			$klietka = $form->addContainer('klietka');
			$klietka->addText('typ', 'Typ:');
			$klietka->addText('podstielka', 'Podstielka:');
			$klietka->addText('lokacia', 'Lokácia:');
		}
		else // editujem typ vybeh
		{
			$vybeh = $form->addContainer('vybeh');
			$vybeh->addText('teren', 'Terén:');
			$vybeh->addText('povrch', 'Povrch:');
			$vybeh->addText('ohradenie', 'Ohradenie:');
		}

		$form->addSubmit('editovat', 'Editovať');
		$form->onSuccess[] = array($this, 'uspesne');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	/*
	 * Udalost po uspesnom odoslani formu
	 * form: samotny form
	 * hodnoty: hodnoty formu
	 */
	public function uspesne(Form $form, $hodnoty)
	{
		foreach ($hodnoty as &$hodnota) if ($hodnota === '') $hodnota = NULL; //premena prazdnch retazcov na null kvoli db
		$zaznam = $this->database->table('umiestnenie')->get($this->Id);
		$zaznam->update($hodnoty['umiestnenie']);
		if($this->mod == 0) //vkladam typ klietka
		{
			$zaznam = $this->database->table('klietka')->get($this->Id);
			$zaznam->update($hodnoty['klietka']);
		}
		else //vkladam typ vybeh
		{
			$zaznam = $this->database->table('vybeh')->get($this->Id);
			$zaznam->update($hodnoty['vybeh']);
		}
		$form->getPresenter()->redirect('Umiestnenie:viac', $this->Id);
	}

}
