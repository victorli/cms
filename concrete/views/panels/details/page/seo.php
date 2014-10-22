<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<section class="ccm-ui">
	<header><?php echo t('SEO')?></header>
	<form method="post" action="<?php echo $controller->action('submit')?>" class="ccm-panel-detail-content-form" data-dialog-form="seo" data-panel-detail-form="seo">

	<?php if ($allowEditPaths && !$c->isGeneratedCollection()) { ?>
	<div class="form-group">
		<label class="control-label launch-tooltip" data-placement="bottom" title="<?php echo t('This page must always be available from at least one URL. This is that URL.')?>" class="launch-tooltip"><?php echo t('URL Slug')?></label>
		<div>
			<input type="text" class="form-control" name="cHandle" value="<?php echo $c->getCollectionHandle()?>" id="cHandle"><input type="hidden" name="oldCHandle" id="oldCHandle" value="<?php echo $c->getCollectionHandle()?>">
		</div>
	</div>
	<?php } ?>

	<?php foreach ($attributes as $ak) { ?>
		<?php $av = $c->getAttributeValueObject($ak); ?>
		<div class="form-group">
			<label class="control-label"><?php echo $ak->getAttributeKeyDisplayName()?></label>
			<div>
			<?php echo $ak->render('form', $av); ?>
			</div>
		</div>
	<?php } ?>

	</form>
	<div class="ccm-panel-detail-form-actions dialog-buttons">
		<button class="pull-left btn btn-default" type="button" data-dialog-action="cancel" data-panel-detail-action="cancel"><?php echo t('Cancel')?></button>
		<button class="pull-right btn btn-success" type="button" data-dialog-action="submit" data-panel-detail-action="submit"><?php echo t('Save Changes')?></button>
	</div>
</section>
