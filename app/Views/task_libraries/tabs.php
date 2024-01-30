<?php
$settings_menu = array(
);
foreach($allCategories as $oneCategory){
    $settings_menu[$oneCategory['title']][]=array();
}
foreach($allTasks as $oneTask){
    // $labels=explode(",",$oneTask["labels"]);
    // $label=$labels[0];
    // $labelText="General";
    // foreach($allCategories as $oneCategory){
    //     if($oneCategory["id"]==$label) {
    //         $labelText=$oneCategory["title"];
    //         break;
    //     }
    // }
    // $settings_menu[$labelText][]=array("name"=>$oneTask["title"],"url"=>$oneTask["id"]);
    $settings_menu[$oneTask["context"]][]=array("name"=>$oneTask["title"],"url"=>$oneTask["id"]);
}
?>

<ul class="nav nav-tabs vertical settings d-block" role="tablist">
    <?php
    foreach ($settings_menu as $key => $value) {

        //collapse the selected settings tab panel
        $collapse_in = "";
        $collapsed_class = "collapsed";
        if (in_array($active_tab, array_column($value, "name"))) {
            $collapse_in = "show";
            $collapsed_class = "";
        }
        $keys=explode(" ",$key);
        ?>

        <div class="clearfix settings-anchor <?php echo $collapsed_class; ?>" data-bs-toggle="collapse" data-bs-target="#settings-tab-<?php echo $keys[0]; ?>">
            <?php echo $key; ?>
        </div>

        <?php
        echo "<div id='settings-tab-".$keys[0]."' class='collapse show'>";
        echo "<ul class='list-group help-catagory'>";

        foreach ($value as $sub_setting) {
            $active_class = "";
            $setting_name = get_array_value($sub_setting, "name");
            $setting_url = get_array_value($sub_setting, "url");

            if ($active_tab == $setting_name) {
                $active_class = "active";
            }

            echo "<a href='" . get_uri($setting_url) . "' class='list-group-item $active_class'>" . $setting_name . "</a>";
        }

        echo "</ul>";
        echo "</div>";
    }
    ?>

</ul>