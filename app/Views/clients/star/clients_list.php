<div class="list-group">
    <?php
    if (count($clients)) {
        foreach ($clients as $client) {
            $title = "<i data-feather='anchor' class='icon-16 mr10'></i> " . $client->charter_name;
            echo anchor(get_uri("clients/view/" . $client->id), $title, array("class" => "dropdown-item text-wrap"));
        }
    } else {
        ?>
        <div class='list-group-item'>
            <?php echo app_lang("empty_starred_vessels"); ?>
        </div>
    <?php } ?>
</div>