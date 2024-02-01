<?php
$settings_menu = array(
    // "General & Docking"=>array(),
    // "Hull"=>array(),
    // "Equipment for Cargo"=>array(),
    // "Ship Equipment"=>array(),
    // "Safety & Crew Equipment"=>array(),
    // "Machinery Main Components"=>array(),
    // "Systems machinery main components"=>array(),
    // "Common Systems"=>array(),
    // "Others"=>array(),
    
);
// foreach($allCategories as $oneCategory){
//     $settings_menu[$oneCategory['title']]=array();
// }
foreach($allTaskLibraries as $oneTask){
    // if($oneTask['category']==""){
    //     $settings_menu["Others"][]=array("name"=>$oneTask["title"],"url"=>'task_libraries/'.$oneTask["id"].'/edit');
    // }
    // if($oneTask['category']=="general"){
    //     $settings_menu["Others"][]=array("name"=>$oneTask["title"],"url"=>'task_libraries/'.$oneTask["id"].'/edit');
    // }
    // else{

    // }
    if($oneTask['category']=="") $settings_menu["Others"][]=array("name"=>$oneTask["title"],"url"=>'task_libraries/'.$oneTask["id"].'/edit');
    else $settings_menu[$oneTask['category']][]=array("name"=>$oneTask["title"],"url"=>'task_libraries/'.$oneTask["id"].'/edit');
    // $labels=explode(",",$oneTask["labels"]);
    // $label=$labels[0];
    // $labelText="General";
    // foreach($allCategories as $oneCategory){
    //     if($oneCategory["id"]==$label) {
    //         $labelText=$oneCategory["title"];
    //         break;
    //     }
    // }
    // $settings_menu[$labelText][]=array("name"=>$oneTask["title"],"url"=>'task_libraries/'.$oneTask["id"].'/edit');
    // $settings_menu[$oneTask["context"]][]=array("name"=>$oneTask["title"],"url"=>$oneTask["id"]);
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