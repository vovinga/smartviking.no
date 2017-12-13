<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by @DmitryNek (Dmitry Shkolyar)
// exmail.Nek@gmail.com
//-----------------------------------------------------
?>
<div class="box">
    <div class="box-heading"><?php echo $heading ? $heading : '&nbsp;'; ?></div>
    <div class="box-content">
        <div id="ne_subscribe<?php echo $module; ?>" class="ne_subscribe" style="text-align:center;">
            <a data-toggle="modal" href="#ne_modal<?php echo $module; ?>" class="button ne_submit" style="width:80%;"><span><?php echo $text_subscribe; ?></span></a>
        </div>
    </div>
</div>
<div class="ne-bootstrap ne_modal<?php echo $module; ?>" tabindex="-1">
    <div class="fade ne_modal" id="ne_modal<?php echo $module; ?>" tabindex="-1" role="dialog" aria-labelledby="ne_modal<?php echo $module; ?>Label" aria-hidden="true" style="display:none;">
        <div class="modal-dialog" style="max-width:400px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo $heading ? $heading : '&nbsp;'; ?></h4>
                    <a href="#" class="ne_close" data-dismiss="modal" aria-hidden="true"><?php echo $text_close; ?></a>
                </div>
                <div class="modal-body">
                    <?php echo $text; ?>
                    <?php if ($fields > 1) { ?>
                        <div class="form-group">
                            <label for="ne_name"><?php echo $fields == 2 ? $entry_name : $entry_firstname; ?></label>
                            <input type="text" class="form-control" id="ne_name" name="ne_name" />
                        </div>
                    <?php } ?>
                    <?php if ($fields == 3) { ?>
                        <div class="form-group">
                            <label for="ne_lastname"><?php echo $entry_lastname; ?></label>
                            <input type="text" class="form-control" id="ne_lastname" name="ne_lastname" />
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="ne_email"><?php echo $entry_email; ?></label>
                        <input type="email" class="form-control" id="ne_email" name="ne_email">
                    </div>
                    <?php if ($marketing_list) { ?>
                        <label><?php echo $entry_list; ?></label>
                        <div class="form-group">
                            <?php foreach ($marketing_list as $key => $list) { ?>
                                <div class="checkbox">
                                    <input class="ne_subscribe_list" id="ne_list<?php echo $key; ?>" name="ne_list[]" type="<?php echo $list_type ? 'radio' : 'checkbox'; ?>" value="<?php echo $key; ?>"><label for="ne_list<?php echo $key; ?>">&nbsp;<?php echo $list[$this->config->get('config_language_id')]; ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <a href="#" class="button ne_submit"><span><?php echo $text_subscribe; ?></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
jQuery(function ($) {
    $('body').append($('.ne_modal<?php echo $module; ?>'));

    $('#ne_modal<?php echo $module; ?>').modal({
        backdrop: "static",
        keyboard: false,
        show: false
    });

    $('#ne_modal<?php echo $module; ?> a.ne_submit').click(function(e){
        e.preventDefault();

        var list = $('#ne_modal<?php echo $module; ?> .ne_subscribe_list:checked').map(function(i,n) {
            return $(n).val();
        }).get();

        $.post("<?php echo $subscribe; ?>", {
            email: $('#ne_modal<?php echo $module; ?> input[name="ne_email"]').val(),
            <?php if ($fields > 1) { ?>name: $('#ne_modal<?php echo $module; ?> input[name="ne_name"]').val(), <?php } ?>
            <?php if ($fields == 3) { ?>lastname: $('#ne_modal<?php echo $module; ?> input[name="ne_lastname"]').val(), <?php } ?>
            'list[]': list
        }, function(data) {
            if (data) {
                if (data.type == 'success') {
                    $.cookie('ne_subscribed', true, {expires: 365, path: '/'});
                    $('#ne_modal<?php echo $module; ?> input[type="text"]').val('');
                    $('#ne_modal<?php echo $module; ?> input[type="email"]').val('');
                    $('#ne_modal<?php echo $module; ?> .ne_subscribe_list').removeAttr('checked');
                }
                $("#ne_modal<?php echo $module; ?> .modal-body div." + data.type).remove();
                $('#ne_modal<?php echo $module; ?> .modal-body').prepend('<div class="' + data.type + '">' + data.message + '</div>');
                $("#ne_modal<?php echo $module; ?> .modal-body div." + data.type).delay(3000).slideUp(400, function(){
                    if(data.type == 'success') {
                        $('#ne_modal<?php echo $module; ?>').modal('hide');
                    }
                    $(this).remove();
                });
            } else {
                $('#ne_modal<?php echo $module; ?> input[type="email"]:first').focus();
                $('#ne_modal<?php echo $module; ?> input[type="text"]:first').focus();
            }
        }, "json");
    });
});
//--></script>