<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Zivocich/vypis.latte

class Template02030aa5b609a805a3f1d08d0870c1e0 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('945fa718df', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbbc475a6108_content')) { function _lbbc475a6108_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;$_l->tmp = $_control->getComponent("vytvoritForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
<table>
    <tr>
        <td>Identifikačné číslo</td>
        <td>Meno</td>
    </tr>
<?php $iterations = 0; foreach ($zivocichi as $zivocich) { ?>
    <tr>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($zivocich->IDZivocicha, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($zivocich->meno, ENT_NOQUOTES) ?></td>
        <td><?php $_l->tmp = $_control->getComponent("viacButton-$zivocich->IDZivocicha"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?></td>
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