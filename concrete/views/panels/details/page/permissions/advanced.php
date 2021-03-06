<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>
<section class="ccm-ui">
	<header><?php echo t('Page Permissions')?></header>

	<?php
	  $cpc = $c->getPermissionsCollectionObject();
	if ($c->getCollectionInheritance() == "PARENT") { ?>
		<div class="alert alert-info"><?php echo t('This page inherits its permissions from:');?> <a target="_blank" href="<?php echo DIR_REL?>/<?php echo DISPATCHER_FILENAME?>?cID=<?php echo $cpc->getCollectionID()?>"><?php echo $cpc->getCollectionName()?></a></div>
	<?php } ?>		


	<div>
		<div class="form-group">
			<label for="ccm-page-permissions-inherit"><?php echo t('Assign Permissions')?></label>
			<select id="ccm-page-permissions-inherit" class="form-control">
			<?php if ($c->getCollectionID() > 1) { ?><option value="PARENT" <?php if ($c->getCollectionInheritance() == "PARENT") { ?> selected<?php } ?>><?php echo t('By Area of Site (Hierarchy)')?></option><?php } ?>
			<?php if ($c->getMasterCollectionID() > 1) { ?><option value="TEMPLATE"  <?php if ($c->getCollectionInheritance() == "TEMPLATE") { ?> selected<?php } ?>><?php echo t('From Page Type Defaults')?></option><?php } ?>
			<option value="OVERRIDE" <?php if ($c->getCollectionInheritance() == "OVERRIDE") { ?> selected<?php } ?>><?php echo t('Manually')?></option>
			</select>
		</div>
	<?php if (!$c->isMasterCollection()) { ?>
		<div class="form-group">
			<label for="ccm-page-permissions-subpages-override-template-permissions"><?php echo t('Subpage Permissions')?></label>
			<select id="ccm-page-permissions-subpages-override-template-permissions" class="form-control">
				<option value="0"<?php if (!$c->overrideTemplatePermissions()) { ?>selected<?php } ?>><?php echo t('Inherit page type default permissions.')?></option>
				<option value="1"<?php if ($c->overrideTemplatePermissions()) { ?>selected<?php } ?>><?php echo t('Inherit the permissions of this page.')?></option>
			</select>
		</div>
	<?php } ?>
	</div>

	<hr/>
	
	<p class="lead"><?php echo t('Current Permission Set')?></p>

	<?php $cat = PermissionKeyCategory::getByHandle('page'); ?>
	<form method="post" id="ccm-permission-list-form" data-dialog-form="permissions" data-panel-detail-form="permissions" action="<?php echo $cat->getToolsURL("save_permission_assignments")?>&cID=<?php echo $c->getCollectionID()?>">

	<table class="ccm-permission-grid table table-striped">
	<?php
	$permissions = PermissionKey::getList('page');
	foreach($permissions as $pk) { 
		$pk->setPermissionObject($c);
		?>
		<tr>
		<td class="ccm-permission-grid-name" id="ccm-permission-grid-name-<?php echo $pk->getPermissionKeyID()?>"><strong><?php if ($editPermissions) { ?><a dialog-title="<?php echo $pk->getPermissionKeyDisplayName()?>" data-pkID="<?php echo $pk->getPermissionKeyID()?>" data-paID="<?php echo $pk->getPermissionAccessID()?>" onclick="ccm_permissionLaunchDialog(this)" href="javascript:void(0)"><?php } ?><?php echo $pk->getPermissionKeyDisplayName()?><?php if ($editPermissions) { ?></a><?php } ?></strong></td>
		<td id="ccm-permission-grid-cell-<?php echo $pk->getPermissionKeyID()?>" <?php if ($editPermissions) { ?>class="ccm-permission-grid-cell"<?php } ?>><?php echo Loader::element('permission/labels', array('pk' => $pk))?></td>
		</tr>
	<?php } ?>
	<?php if ($editPermissions) { ?>
	<tr>
		<td class="ccm-permission-grid-name" ></td>
		<td>
		<?php echo Loader::element('permission/clipboard', array('pkCategory' => $cat))?>
		</td>
	</tr>
	<?php } ?>
	</table>
	</form>
</section>

<div id="ccm-page-permissions-confirm-dialog" style="display: none">
    <?php echo t('Changing this setting will affect this page immediately. Are you sure?')?>
    <div id="dialog-buttons-start">
        <input type="button" class="btn btn-default pull-left" value="Cancel" onclick="jQuery.fn.dialog.closeTop()" />
        <input type="button" class="btn btn-primary pull-right" value="Ok" onclick="ccm_pagePermissionsConfirmInheritanceChange()" />
    </div>
</div>

<?php if ($editPermissions) { ?>
    <div class="ccm-panel-detail-form-actions dialog-buttons">
        <button class="pull-left btn btn-default" type="button" data-dialog-action="cancel" data-panel-detail-action="cancel"><?php echo t('Cancel')?></button>
        <button class="pull-right btn btn-success" type="button" data-dialog-action="submit" data-panel-detail-action="submit"><?php echo t('Save Changes')?></button>
    </div>
<?php } ?>


<script type="text/javascript">
var inheritanceVal = '';

ccm_pagePermissionsCancelInheritance = function() {
	$('#ccm-page-permissions-inherit').val(inheritanceVal);
}

ccm_pagePermissionsConfirmInheritanceChange = function() { 
	jQuery.fn.dialog.showLoader();
	$.getJSON('<?php echo $pk->getPermissionAssignmentObject()->getPermissionKeyToolsURL("change_permission_inheritance")?>&cID=<?php echo $c->getCollectionID()?>&mode=' + $('#ccm-page-permissions-inherit').val(), function(r) { 
		if (r.deferred) {
			jQuery.fn.dialog.closeAll();
			jQuery.fn.dialog.hideLoader();
			ConcreteAlert.notify({
			'message': ccmi18n.setPermissionsDeferredMsg,
			'title': ccmi18n.setPagePermissions
			});
		} else {
			jQuery.fn.dialog.closeTop();
			ccm_refreshPagePermissions();
		}
	});
}


$(function() {
	$('#ccm-permission-list-form').ajaxForm({
		dataType: 'json',
		
		beforeSubmit: function() {
			jQuery.fn.dialog.showLoader();
		},
		
		success: function(r) {
			jQuery.fn.dialog.hideLoader();
			jQuery.fn.dialog.closeTop();
			if (!r.deferred) {
				ConcreteAlert.notify({
				'message': ccmi18n.setPermissionsMsg,
				'title': ccmi18n.setPagePermissions
				});			
			} else {
				jQuery.fn.dialog.closeTop();
				ConcreteAlert.notify({
				'message': ccmi18n.setPermissionsDeferredMsg,
				'title': ccmi18n.setPagePermissions
				});				
			}

		}		
	});
	
	inheritanceVal = $('#ccm-page-permissions-inherit').val();
	$('#ccm-page-permissions-inherit').change(function() {
		$('#dialog-buttons-start').addClass('dialog-buttons');
		jQuery.fn.dialog.open({
			element: '#ccm-page-permissions-confirm-dialog',
			title: '<?php echo t("Confirm Change")?>',
			width: 280,
			height: 160,
			onClose: function() {
				ccm_pagePermissionsCancelInheritance();
			}
		});
	});
	
	$('#ccm-page-permissions-subpages-override-template-permissions').change(function() {
		jQuery.fn.dialog.showLoader();
		$.getJSON('<?php echo $pk->getPermissionAssignmentObject()->getPermissionKeyToolsURL("change_subpage_defaults_inheritance")?>&cID=<?php echo $c->getCollectionID()?>&inherit=' + $(this).val(), function(r) { 
			if (r.deferred) {
				ConcretePanelManager.exitPanelMode();
				jQuery.fn.dialog.hideLoader();
				ConcreteAlert.notify({
				'message': ccmi18n.setPermissionsDeferredMsg,
				'title': ccmi18n.setPagePermissions
				});				
			} else {
				ccm_refreshPagePermissions();
			}
		});
	});
	
});

ccm_refreshPagePermissions = function() {
	var panel = ConcretePanelManager.getByIdentifier('page');
	panel.openPanelDetail({
		'identifier': 'page-permissions',
		'url': '<?php echo URL::to("/ccm/system/panels/details/page/permissions")?>'
	});
}

ccm_permissionLaunchDialog = function(link) {
	var dupe = $(link).attr('data-duplicate');
	if (dupe != 1) {
		dupe = 0;
	}
	jQuery.fn.dialog.open({
		title: $(link).attr('dialog-title'),
		href: '<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/edit_collection_popup?cID=<?php echo $c->getCollectionID()?>&ctask=set_advanced_permissions&duplicate=' + dupe + '&pkID=' + $(link).attr('data-pkID') + '&paID=' + $(link).attr('data-paID'),
		modal: false,
		width: 500,
		height: 380
	});		
}


</script>