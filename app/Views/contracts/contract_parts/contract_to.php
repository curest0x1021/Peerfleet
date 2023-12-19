<?php if (!(isset($is_preview) && $is_preview)) { ?>
    <div><b><?php echo app_lang("contract_to"); ?></b></div>
    <div class="b-b" style="line-height: 2px; border-bottom: 1px solid #f2f2f2;"> </div>
    <div style="line-height: 3px;"> </div>
<?php } ?>

<strong><?php echo $client_info->charter_name; ?> </strong>
<div style="line-height: 3px;"> </div>
<span class="invoice-meta text-default" style="font-size: 90%; color: #666;">
    <?php if ($client_info) { ?>
        <div>
            <!--  -->
        </div>
    <?php } ?>
</span>