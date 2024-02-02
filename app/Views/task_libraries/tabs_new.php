<?php
$settings_menu = array(

    
);

foreach($allTaskLibraries as $oneTask){
    if($oneTask["category"]=="") $oneTask["category"]="Others";
    if(!isset($settings_menu[$oneTask["category"]])) $settings_menu[$oneTask["category"]]=array();
    if($oneTask['category']=="") $settings_menu["Others"][]=array("name"=>$oneTask["title"],"url"=>'task_libraries/'.$oneTask["id"].'/edit');
    else $settings_menu[$oneTask['category']][]=array("name"=>strtoupper(substr($oneTask['category'], 0, 1)).sprintf("%02d", count($settings_menu[$oneTask['category']])+1).". ".$oneTask["title"],"url"=>'task_libraries/'.$oneTask["id"].'/edit');
}
?>

<ul class="nav nav-tabs vertical settings d-block" role="tablist">
    <?php
    $sequence=1;
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
            <?php echo $sequence.". ".$key;
            $sequence++;
            ?>
        </div>

        <?php
        echo "<div id='settings-tab-".$keys[0]."' class='collapse $collapse_in'>";
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