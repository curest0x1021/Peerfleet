<?php
$settings_menu = array(
    "General & Docking"=>array(),
    "Hull"=>array(),
    "Equipment for Cargo"=>array(),
    "Ship Equipment"=>array(),
    "Safety & Crew Equipment"=>array(),
    "Machinery Main Components"=>array(),
    "System Machinery Main Components"=>array(),
    "Common systems"=>array(),
    "Others"=>array(),
);
foreach ($allTasklibraries as $oneTasklibrary) {
    # code...
    if($oneTasklibrary["category"]=="") $oneTasklibrary["category"]="Others";
    if(!isset($settings_menu[$oneTasklibrary['category']])) $settings_menu[$oneTasklibrary['category']]=array();
    if($oneTasklibrary['category']=="") $settings_menu["Others"][]=array("name"=>$oneTasklibrary["title"],"url"=>'task_libraries/'.$oneTasklibrary["id"].'/edit');
    else $settings_menu[$oneTasklibrary['category']][]=array("name"=>strtoupper($oneTasklibrary['category'][0]).sprintf("%02d", count($settings_menu[$oneTasklibrary["category"]])+1).". ".$oneTasklibrary["title"],"url"=>'task_libraries/view/'.$oneTasklibrary["id"].'/');
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
        ?>

        <div class="clearfix settings-anchor <?php echo $collapsed_class; ?>" data-bs-toggle="collapse" data-bs-target="#settings-tab-<?php echo explode(" ",$key)[0]; ?>">
            <?php echo $key; ?>
        </div>

        <?php
        // echo "<div id='settings-tab-$key' class='collapse $collapse_in'>";
        echo "<div id='settings-tab-".explode(" ",$key)[0]."' class='collapse'>";
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