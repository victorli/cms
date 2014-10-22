<?php defined('C5_EXECUTE') or die('Access denied.'); ?>

<div class='form-group'>
    <?php echo $form->label('apikey', t('App ID'))?>
    <?php echo $form->text('apikey', $apikey)?>
</div>
<div class='form-group'>
    <?php echo $form->label('apisecret', t('App Secret'))?>
    <div class="input-group">
        <?php echo $form->password('apisecret', $apisecret)?>
        <span class="input-group-btn">
        <button id="showsecret" class="btn btn-warning" type="button"><?php echo t('Show secret key')?></button>
      </span>
    </div>
</div>
<div class='form-group'>
    <div class="input-group">
        <label type="checkbox">
            <input type="checkbox" name="registration_enabled" value="1" <?php echo \Config::get('auth.facebook.registration_enabled', false) ? 'checked' : '' ?>>
            <span style="font-weight:normal"><?php echo t('Allow automatic registration') ?></span>
        </label>
        </span>
    </div>
</div>

<div class="alert alert-info">
    <?php echo t('<a href="%s" target="_blank">Click here</a> to obtain your access keys.', 'https://developers.facebook.com/apps/'); ?>
</div>

<script type="text/javascript">
    var button = $('#showsecret');
    button.click(function() {
        var apisecret = $('#apisecret');
        if(apisecret.attr('type') == 'password') {
            apisecret.attr('type', 'text');
            button.html('<?php echo addslashes(t('Hide secret key'))?>');
        } else {
            apisecret.attr('type', 'password');
            button.html('<?php echo addslashes(t('Show secret key'))?>');
        }
    });
</script>
