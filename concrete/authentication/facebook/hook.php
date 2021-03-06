<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<div class="form-group">
        <span>
            <?php echo t('Attach a %s account', t('facebook')) ?>
        </span>
    <hr>
</div>
<div class="form-group">
    <a href="<?php echo \URL::to('/system/authentication/facebook/attempt_attach'); ?>" class="btn btn-primary btn-facebook">
        <i class="fa fa-facebook"></i>
        <?php echo t('Attach a %s account', t('facebook')) ?>
    </a>
</div>

<style>
    .ccm-ui .btn-facebook {
        border-width: 0px;
        background: #3b5998;
    }
    .btn-facebook .fa-facebook {
        margin: 0 6px 0 3px;
    }
</style>
