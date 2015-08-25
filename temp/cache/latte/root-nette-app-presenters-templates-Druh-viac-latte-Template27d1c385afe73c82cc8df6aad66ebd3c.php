<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\presenters/templates/Druh/viac.latte

class Template27d1c385afe73c82cc8df6aad66ebd3c extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('36a9ad2e69', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbab95c63613_content')) { function _lbab95c63613_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><h3>Základné informácie:</h3>
<strong>Identifiačné číslo:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($druh->IDDruhuZivocicha, ENT_NOQUOTES) ?> <br>
<strong>Názov:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($druh->nazov, ENT_NOQUOTES) ?> <br>
<?php $_l->tmp = $_control->getComponent("editovatButton"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;$_l->tmp = $_control->getComponent("vymazatButton"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>

<h3>Živočíchy tohoto druhu:</h3>
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