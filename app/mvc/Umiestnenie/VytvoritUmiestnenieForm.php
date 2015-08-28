<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;


class VytvoritUmiestnenieForm extends Nette\Object
{
	private $database;
	private $mod;

	public function __construct(Nette\Database\Context $databaza, $mod)
	{
		$this->database = $databaza;
		$this->mod = $mod;
	}

	public function vytvorit()
	{
		$form = new Form;
		$umiestnenie = $form->addContainer('umiestnenie');
		$umiestnenie->addText('nazov', 'Názov:')->setRequired();
		$umiestnenie->addText('sirka', 'Šírka:')->setRequired()->addRule(Form::FLOAT, 'Pole musi obsahovať iba čísla!');
		$umiestnenie->addText('dlzka', 'Dĺžka:')->setRequired()->addRule(Form::FLOAT, 'Pole musi obsahovať iba čísla!');
		$umiestnenie->addText('vyska', 'Výška:')->setRequired()->addRule(Form::FLOAT, 'Pole musi obsahovať iba čísla!');

		if($this->mod == 0) //typ klietka
		{
			$klietka = $form->addContainer('klietka');
			$klietka->addText('typ', 'Typ:')->setRequired();
			$klietka->addText('podstielka', 'Podstielka:')->setRequired();
			$klietka->addText('lokacia', 'Lokácia:')->setRequired();
		}
		else //typ vybeh
		{
			$vybeh = $form->addContainer('vybeh');
			$vybeh->addText('teren', 'Terén:')->setRequired();
			$vybeh->addText('povrch', 'Povrch:')->setRequired();
			$vybeh->addText('ohradenie', 'Ohradenie:')->setRequired();
		}

		$form->addSubmit('vytvorit', 'Vytvoriť');
		$form->onSuccess[] = array($this, 'uspesne');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}
 
	public function uspesne(Form $form, $hodnoty)
	{
		$zaznam = $this->database->table('umiestnenie')->insert($hodnoty['umiestnenie']);

		if($this->mod == 0) //typ klietka
		{
			$hodnoty['klietka']->IDUmiestnenia = $zaznam->IDUmiestnenia;
			$this->database->table('klietka')->insert($hodnoty['klietka']);
		}
		else //typ vybeh
		{
			$hodnoty['vybeh']->IDUmiestnenia = $zaznam->IDUmiestnenia;
			$this->database->table('vybeh')->insert($hodnoty['vybeh']);
		}

		$form->getPresenter()->redirect('Umiestnenie:vypis');
	}

}
