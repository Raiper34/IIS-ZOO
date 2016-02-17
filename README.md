# IIS-ZOO

Implementácia
==
Použité frameworky a knižnice:
--
* Nette
* Bootstrap
* jQuery
* Bs3FormRenderer
	
Na vypracovanie projektu je použitý framework Nette, takže aplikácia je postavená na MVC (MVP) architektúre, čiže skripty sú rozdelené na 3 časti. Na model, view a presenter. Pričom väčšinou si vystačíme iba s časťou view a presenter. V zložke app\mvc\templates sa nachádzajú jednotlivé pohľady (view), kde sa iba predávajú získané informácie z presenteru, ktoré chceme zobraziť. V zložke app\mvc má každý presenter zvlášť svoju zložku, napríklad presenter Druh. V tejto zložke sa typicky nachádzajú 3 súbory, a to (napríklad pre zložku Druh): DruhPresenter.php (kde sa nachádzajú všetky akcie, manipulácie s databázovou tabuľkou druh, pridávanie do tabuľky druh...), VytvoritDruhForm.php (továrenská metóda na tvorbu formulárov pre pridávanie nového druhu) a EditovatDruhForm.php (továrenská metóda na tvorbu formulárov, pre editovanie druhu). Každému pohľadu prislúcha v našom prípade práve jeden presenter. Model v aplikácií uvažujeme iba minimálne, vzhľadom na to, že v presenteri sa nachádzajú iba požiadavky na databázu. Model využívame napríklad pri implementácií autentifikátoru.

Inštalácia
==

Softwarové požiadavky:
--
PHP 5.4 MYSQL 5.6

* Najprv vytvorte v phpMyAdmin, alebo inom, databázu a spustite skript databaza.sql, ktorý vytvorí tabuľky a naplní ich dátami. 
* Potom editujte súbor app/config/config.local.neon vašimi prístupovými údajmi k databázi.</li><li>Nakoniec nahrajte na server všetky súbory.
	
