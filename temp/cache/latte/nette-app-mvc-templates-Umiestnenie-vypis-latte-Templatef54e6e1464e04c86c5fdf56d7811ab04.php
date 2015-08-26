<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Umiestnenie/vypis.latte

class Templatef54e6e1464e04c86c5fdf56d7811ab04 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('9b7e35a3f6', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbbf90cc1176_content')) { function _lbbf90cc1176_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;$_l->tmp = $_control->getComponent("pridatKlietkuButton"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;$_l->tmp = $_control->getComponent("pridatVybehButton"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
<table>
    <tr>
        <th>Umiestnenia typu klietka</th>
    </tr>
    <tr>
        <td>Identifikačné číslo</td>
        <td>Názov</td>
        <td>Šírka</td>
        <td>Dĺžka</td>
        <td>Výška</td>
        <td>Typ</td>
        <td>Podstielka</td>
        <td>Lokácia</td>
    </tr>
<?php $iterations = 0; foreach ($umiestneniaKlietka as $umiestnenie) { ?>
    <tr>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->IDUmiestnenia, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->nazov, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->sirka, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->dlzka, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->vyska, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->typ, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->podstielka, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->lokacia, ENT_NOQUOTES) ?></td>
        <td><?php $_l->tmp = $_control->getComponent("viacButton-$umiestnenie->IDUmiestnenia"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?></td>
    <tr>
<?php $iterations++; } ?>
    <tr>
        <th>Umiestnenia typu vybeh</th>
    </tr>
    <tr>
        <td>Identifikačné číslo</td>
        <td>Názov</td>
        <td>Šírka</td>
        <td>Dĺžka</td>
        <td>Výška</td>
        <td>Terén</td>
        <td>Povch</td>
        <td>Ohradenie</td>
    </tr>
<?php $iterations = 0; foreach ($umiestneniaVybeh as $umiestnenie) { ?>
    <tr>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->IDUmiestnenia, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->nazov, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->sirka, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->dlzka, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->vyska, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->teren, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->povrch, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->ohradenie, ENT_NOQUOTES) ?></td>
        <td><?php $_l->tmp = $_control->getComponent("viacButton-$umiestnenie->IDUmiestnenia"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?></td>
    <tr>
<?php $iterations++; } ?>
</table>
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