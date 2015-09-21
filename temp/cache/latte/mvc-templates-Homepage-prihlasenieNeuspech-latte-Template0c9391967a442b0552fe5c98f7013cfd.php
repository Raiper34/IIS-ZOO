<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Homepage/prihlasenieNeuspech.latte

class Template0c9391967a442b0552fe5c98f7013cfd extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('ffd722e94f', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbe048e04e45_content')) { function _lbe048e04e45_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<div class="alert alert-danger alert-dismissible" role="alert">	
	    <span class="sr-only">Error:</span>
	    <h2 class="text-center"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Nesprávne meno alebo heslo! <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Homepage:prihlasenie"), ENT_COMPAT) ?>">Späť na prihlásenie</a></h2>
	</div>
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