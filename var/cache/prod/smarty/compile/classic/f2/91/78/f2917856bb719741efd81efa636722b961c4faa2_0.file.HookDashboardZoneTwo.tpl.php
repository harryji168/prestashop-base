<?php
/* Smarty version 3.1.43, created on 2022-04-10 15:59:51
  from '/var/www/html/modules/ps_metrics/views/templates/hook/HookDashboardZoneTwo.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_62533737a03e78_79965769',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f2917856bb719741efd81efa636722b961c4faa2' => 
    array (
      0 => '/var/www/html/modules/ps_metrics/views/templates/hook/HookDashboardZoneTwo.tpl',
      1 => 1649572965,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_62533737a03e78_79965769 (Smarty_Internal_Template $_smarty_tpl) {
?><link href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pathMetricsApp']->value,'htmlall','UTF-8' ));?>
" rel=preload as=script>
<link href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pathVendorMetrics']->value,'htmlall','UTF-8' ));?>
" rel=preload as=script>

<div id="app"></div>

<link rel="stylesheet" href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pathMetricsAssets']->value,'htmlall','UTF-8' ));?>
">
<?php echo '<script'; ?>
 type="module" src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pathMetricsApp']->value,'htmlall','UTF-8' ));?>
"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="module" src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pathVendorMetrics']->value,'htmlall','UTF-8' ));?>
"><?php echo '</script'; ?>
>
<?php }
}
