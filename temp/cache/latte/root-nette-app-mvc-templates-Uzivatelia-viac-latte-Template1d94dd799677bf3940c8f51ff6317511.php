<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Uzivatelia/viac.latte

class Template1d94dd799677bf3940c8f51ff6317511 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('15f877b301', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbfabb006b2c_content')) { function _lbfabb006b2c_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;$_l->tmp = $_control->getComponent("vymazatButton"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
<h3>Základné informácie:</h3>
<strong>Rodné číslo:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->RodneCislo, ENT_NOQUOTES) ?> <br>
<strong>Meno:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->meno, ENT_NOQUOTES) ?> <br>
<strong>Priezvisko:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->priezvisko, ENT_NOQUOTES) ?> <br>
<strong>Titul:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->titul, ENT_NOQUOTES) ?> <br>
<strong>Dátum narodenia:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->datumNarodenia, ENT_NOQUOTES) ?> <br>
<strong>Adresa:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->adresa, ENT_NOQUOTES) ?> <br>
<strong>Funkcia:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->funkcia, ENT_NOQUOTES) ?> <br>
<strong>IBAN:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->IBAN, ENT_NOQUOTES) ?> <br>
<?php $_l->tmp = $_control->getComponent("editovatButton"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>

<h3>Spravuje umiestnenia:</h3>

<h3>Stará sa o zvieratá:</h3>

<h3>Testoval:</h3>
<?php
}}

//
// end of blocks
//

// template extending

$_l->extends = empty($_g->extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $_g->extended = TRUE;

if ($_l->extends) { ob_start();}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIRuntime::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}