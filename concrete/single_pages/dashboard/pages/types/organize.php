<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-pane-body">
<fieldset>
    <legend><?php echo t('Frequently Used')?></legend>
    <ul class="item-select-list" data-sort="frequently-used">
    <?php foreach($frequent as $pt) { ?>
        <li data-page-type-id="<?php echo $pt->getPageTypeID()?>"><span><?php echo $pt->getPageTypeName()?> <i class="fa fa-arrow-v ccm-item-select-list-sort"></i></span></li>
    <?php } ?>
    </ul>
</fieldset>

<fieldset>
    <legend><?php echo t('Others')?></legend>
    <ul class="item-select-list" data-sort="other">
        <?php foreach($infrequent as $pt) { ?>
            <li data-page-type-id="<?php echo $pt->getPageTypeID()?>"><span><?php echo $pt->getPageTypeName()?> <i class="fa fa-arrow-v ccm-item-select-list-sort"></i></span></li>
        <?php } ?>
    </ul>
</fieldset>
</div>
<div class="ccm-dashboard-form-actions-wrapper">
    <div class="ccm-dashboard-form-actions">
        <a href="<?php echo URL::to('/dashboard/pages/types')?>" class="btn pull-left btn-default"><?php echo t('Back to Page Types')?></a>
        <button class="pull-right btn btn-primary" type="button" data-submit="save"><?php echo t('Save Ordering')?></button>
    </div>
</div>

    <script type="text/javascript">
    $(function() {
        $('ul[data-sort]').sortable({
            connectWith: 'ul[data-sort]'
        });

        $('button[data-submit=save]').on('click', function() {
           var frequent = [],
               infrequent = [];

            $('ul[data-sort=frequently-used] li').each(function() {
                frequent.push($(this).attr('data-page-type-id'));
            });

            $('ul[data-sort=other] li').each(function() {
                infrequent.push($(this).attr('data-page-type-id'));
            });

            $.concreteAjax({
               url: '<?php echo $view->action('submit')?>',
               data: {
                   ccm_token: '<?php echo Loader::helper('validation/token')->generate("submit")?>',
                   frequent: frequent,
                   infrequent: infrequent
               },
                success: function(r) {
                    ConcreteAlert.notify({
                        'message': r.message,
                        'title': r.title
                    });
                }
            });

        });
    });
    </script>