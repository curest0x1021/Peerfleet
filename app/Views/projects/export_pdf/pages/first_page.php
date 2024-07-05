<?php
$page = 0;
?>

<?php echo view('projects/export_pdf/layouts/header.php', ["project_info" => $project_info]); ?>
<div style="text-align: center;">
    <?php if (unserialize($client_info->image)) { ?>
        <img style="height:auto;max-width:1775px;"
            src="<?php echo encode_img_base64(get_setting("profile_image_path") . "/" . unserialize($client_info->image)["file_name"]); ?>"
            alt="logo" />
    <?php } else { ?>
        <img style="height:auto;max-width:1775px;" src="<?php echo encode_img_base64(base_url("assets/images/ship_img.jpg")); ?>"
            alt="logo" />
    <?php } ?>
</div>
<h1 style="text-align:center;color:#3270b8;"><?php echo $project_info->title . " - " . $client_info->charter_name; ?></h1>
<!-- <table style="width:100%" >
    <tbody>
    <tr>
        <td style="width:50%;text-align:center;" >
        <p>Start Date : <?php
        // echo $project_info->start_date;
        ?></p>
        </td>
        <td style="width:50%;text-align:center;">
        <p>Deadline : <?php
        // echo $project_info->deadline;
        ?></p>
        </td>
    </tr>
    </tbody>
</table> -->
<p style="text-align:center;">
    <?php echo date("d.m.Y", strtotime($project_info->start_date)) . " ~ " . date("d.m.Y", strtotime($project_info->deadline)); ?>
</p>
<p style="text-align:center;">Labels : <?php
$label_data = explode("--::--", $project_info->labels_list);
if (array_key_exists(1, $label_data))
    echo $label_data[1];
?></p>
<div style=" width:100%;position:absolute; bottom:5px;">
    <div style="background-color:#3270b8;width:100%; height:5px;"></div>
    <table style="width:100%">
        <tbody>
            <tr>
                <td style="width:70%">
                </td>
                <td>
                    <p>Exported on :<?php echo date('d.m.Y'); ?></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div style="page-break-before: always;"></div>

<?php echo view('projects/export_pdf/layouts/header.php', ["project_info" => $project_info]); ?>
<h1 style="text-align:center;margin-top:300px; color:#3270b8;">1. Vessel Information</h1>
<?php
$page++;
echo view('projects/export_pdf/layouts/footer.php', ["page" => $page]);
?>
<div style="page-break-before: always;"></div>

<?php echo view('projects/export_pdf/layouts/header.php', ["project_info" => $project_info]); ?>
<h2 style="text-align:center;color:#3270b8;">General Information</h2>
<table style="width:100%;text-align:center;border:1px solid lightgray; border-collapse:collapse;">
    <tbody>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Vessel name
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php if ($client_info->charter_name)
                    echo $client_info->charter_name; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Vessel type
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php if ($vessel_info)
                    echo $vessel_info->title; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                IMO Number
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php if ($client_info->imo_number)
                    echo $client_info->imo_number; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Flag state
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php if ($client_info->flag_state)
                    echo $client_info->flag_state; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Port of registry
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php if ($client_info->port_of_registry)
                    echo $client_info->port_of_registry; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Classification society
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php if ($client_info->classification_society)
                    echo $client_info->classification_society; ?>
            </td>
        </tr>
    </tbody>
</table>
<h2 style="text-align:center;color:#3270b8;">Dimensions and Capacities</h2>
<table style="width:100%;text-align:center;border:1px solid lightgray; border-collapse:collapse;">
    <tbody>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;width:50%;">
                Gross tonnage
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->gross_tonnage ? $client_info->gross_tonnage : 0) . " t"; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Length over all (L.O.A)
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->length_over_all ? $client_info->length_over_all : 0) . " m"; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Length between perpendiculars (L.B.P)
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->length_between_perpendiculars ? $client_info->length_between_perpendiculars : 0) . " m"; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                BEAM/Breadth moulded
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->breadth_moulded ? $client_info->breadth_moulded : 0) . " m"; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Depth moulded
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->depth_moulded ? $client_info->depth_moulded : 0) . " m"; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Draught scantling
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->draught_scantling ? $client_info->draught_scantling : 0) . " m"; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Hull design
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->hull_design ? $client_info->hull_design : ""); ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Heavy fuel oil
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->heavy_fuel_oil ? $client_info->heavy_fuel_oil : ""); ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Marine diesel oil
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->marine_diesel_oil ? $client_info->marine_diesel_oil : ""); ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Marine gas oil
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->marine_gas_oil ? $client_info->marine_gas_oil : ""); ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                LNG capacity
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->lng_capacity ? $client_info->lng_capacity : ""); ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Lub oil
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->lub_oil ? $client_info->lub_oil : ""); ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Ballast water
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->ballast_water ? $client_info->ballast_water : ""); ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;">
                Fresh water
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo ($client_info->fresh_water ? $client_info->fresh_water : ""); ?>
            </td>
        </tr>
    </tbody>
</table>

<?php
$page++;
echo view('projects/export_pdf/layouts/footer.php', ["page" => $page]);
?>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php', ["project_info" => $project_info]); ?>
<h2 style="color:#3270b8;text-align:center;">Propulsion</h2>
<div style="">
    <table style="width:100%;">
        <tbody>
            <tr>
                <td style="width:50%;">
                    <h3 style="text-align:center">Main engine</h3>
                    <table style="width:90%;text-align:center;border:1px solid lightgray; border-collapse:collapse;">
                        <tbody>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Maker
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->main_engine_maker ? $client_info->main_engine_maker : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Model
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->main_engine_model ? $client_info->main_engine_model : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Continuous output
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->main_engine_continuous_output ? $client_info->main_engine_continuous_output : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Bore
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->main_engine_bore ? $client_info->main_engine_bore : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Stroke
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->main_engine_stroke ? $client_info->main_engine_stroke : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Serial number
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->main_engine_serial_number ? $client_info->main_engine_serial_number : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Quantity
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->main_engine_quantity ? $client_info->main_engine_quantity : ""); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h3 style="text-align:center">Auxiliary engine</h3>
                    <table style="width:90%;text-align:center;border:1px solid lightgray; border-collapse:collapse;">
                        <tbody>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Maker
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->auxiliary_engine_maker ? $client_info->auxiliary_engine_maker : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Model
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->auxiliary_engine_model ? $client_info->auxiliary_engine_model : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Output
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->auxiliary_engine_output ? $client_info->auxiliary_engine_output : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Serial number
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->auxiliary_engine_serial_number ? $client_info->auxiliary_engine_serial_number : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Quantity
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->auxiliary_engine_quantity ? $client_info->auxiliary_engine_quantity : ""); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h3 style="text-align:center">Emergency generator</h3>
                    <table style="width:90%;text-align:center;border:1px solid lightgray; border-collapse:collapse;">
                        <tbody>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Maker
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->emergency_generator_maker ? $client_info->emergency_generator_maker : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Model
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->emergency_generator_model ? $client_info->emergency_generator_model : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Output
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->emergency_generator_output ? $client_info->emergency_generator_output : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Serial number
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->emergency_generator_serial_number ? $client_info->emergency_generator_serial_number : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Quantity
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->emergency_generator_quantity ? $client_info->emergency_generator_quantity : ""); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <h3 style="text-align:center">Shaft generator</h3>
                    <table style="width:90%;text-align:center;border:1px solid lightgray; border-collapse:collapse;">
                        <tbody>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Maker
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->shaft_generator_maker ? $client_info->shaft_generator_maker : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Model
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->shaft_generator_model ? $client_info->shaft_generator_model : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Output
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->shaft_generator_output ? $client_info->shaft_generator_output : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Serial number
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->shaft_generator_serial_number ? $client_info->shaft_generator_serial_number : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Quantity
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->shaft_generator_quantity ? $client_info->shaft_generator_quantity : ""); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h3 style="text-align:center">Propeller</h3>
                    <table style="width:90%;text-align:center;border:1px solid lightgray; border-collapse:collapse;">
                        <tbody>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Maker
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->propeller_maker ? $client_info->propeller_maker : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Type
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->propeller_type ? $client_info->propeller_type : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Number of blades
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->propeller_number_of_blades ? $client_info->propeller_number_of_blades : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Diamter
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->propeller_diameter ? $client_info->propeller_diameter : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Pitch
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->propeller_pitch ? $client_info->propeller_pitch : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Material
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->propeller_material ? $client_info->propeller_material : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Weight
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->propeller_weight ? $client_info->propeller_weight : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Output
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->propeller_output ? $client_info->propeller_output : ""); ?>
                                </td>
                            </tr>
                            <tr style="border:1px solid lightgray;">
                                <td style="border:1px solid lightgray;padding:5px;width:50%;">
                                    Quantity
                                </td>
                                <td style="border:1px solid lightgray;padding:5px;">
                                    <?php echo ($client_info->propeller_quantity ? $client_info->propeller_quantity : ""); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>


</div>
<?php
$page++;
echo view('projects/export_pdf/layouts/footer.php', ["page" => $page]);
?>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php', ["project_info" => $project_info]); ?>
<h2 style="color:#3270b8;text-align:center">Side Thruster</h2>
<table style="width:90%;text-align:center;border:1px solid lightgray; border-collapse:collapse;">
    <tbody>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;width:50%;">
                Number of bow thrusters
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo $client_info->bow_thruster_number; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;width:50%;">
                Maker of bow thrusters
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo $client_info->bow_thruster_maker; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;width:50%;">
                Type of bow thrusters
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo $client_info->bow_thruster_type; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;width:50%;">
                Number of stern thrusters
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo $client_info->stern_thruster_number; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;width:50%;">
                Maker of stern thrusters
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo $client_info->stern_thruster_maker; ?>
            </td>
        </tr>
        <tr style="border:1px solid lightgray;">
            <td style="border:1px solid lightgray;padding:5px;width:50%;">
                Type of stern thrusters
            </td>
            <td style="border:1px solid lightgray;padding:5px;">
                <?php echo $client_info->stern_thruster_type; ?>
            </td>
        </tr>
    </tbody>
</table>
<?php
$page++;
echo view('projects/export_pdf/layouts/footer.php', ["page" => $page]);
?>
<div style="page-break-before: always;"></div>

<?php echo view('projects/export_pdf/layouts/header.php', ["project_info" => $project_info]); ?>
<h1 style="text-align:center;color:#3270b8;margin-top:300px;">2. Project Information</h1>
<?php
$page++;
echo view('projects/export_pdf/layouts/footer.php', ["page" => $page]);
?>
<div style="page-break-before: always;"></div>

<?php echo view('projects/export_pdf/layouts/header.php', ["project_info" => $project_info]); ?>
<h2 style="color:#3270b8;">About this project</h2>
<div><?php echo $project_info->description; ?></div>
<?php
$page++;
echo view('projects/export_pdf/layouts/footer.php', ["page" => $page]);
?>
<div style="page-break-before: always;"></div>

<?php echo view('projects/export_pdf/layouts/header.php', ["project_info" => $project_info]); ?>
<h2 style="color:#3270b8;">Team Members</h2>
<?php foreach ($members as $key => $member) {
    ?>
    <table style="width:80%;">
        <tbody>
            <tr>
                <td style="width:60px;">
                    <?php
                    $avatar_path = base_url("assets/images/avatar.jpg");
                    $avatar_data = unserialize($member->member_image);
                    if ($avatar_data && file_exists(get_setting("profile_image_path") . $avatar_data['file_name'])) {
                        $avatar_path = get_setting("profile_image_path") . $avatar_data['file_name'];
                    }
                    ?>
                    <img src="<?php echo encode_img_base64($avatar_path); ?>" style="width:50px;border-radius:50%;" />

                </td>
                <td style="width:40%">
                    <p style="float:left;"><?php echo $member->member_name; ?></p>
                </td>
                <td>
                    <p style="float:left;"><?php echo $member->member_email; ?></p>
                </td>
                <td>
                    <p style="float:left;"><?php echo $member->member_mobile; ?></p>
                </td>
            </tr>
        </tbody>
    </table>

    <?php
}
; ?>

<?php
$page++;
echo view('projects/export_pdf/layouts/footer.php', ["page" => $page]);
?>
<div style="page-break-before: always;"></div>

<?php echo view('projects/export_pdf/layouts/header.php', ["project_info" => $project_info]); ?>
<h2 style="color:#3270b8;"><?php if (count($tasks) > 0)
    echo "Task List"; ?></h2>
<?php
$categorized_tasks = array(
    "General & Docking" => array(),
    "Hull" => array(),
    "Equipment for Cargo" => array(),
    "Ship Equipment" => array(),
    "Safety & Crew Equipment" => array(),
    "Machinery Main Components" => array(),
    "System Machinery Main Components" => array(),
    "Common systems" => array(),
    "Others" => array(),
);
foreach ($tasks as $key => $task) {
    # code...
    if ($task->category == "")
        $task->category = "Others";
    if (!isset($categorized_tasks[$task->category]))
        $categorized_tasks[$task->category] = array();
    $categorized_tasks[$task->category][] = $task;
}
foreach ($categorized_tasks as $category => $list) {
    ?>
    <?php if (count($list) > 0)
        echo "<h4>$category</h4>"; ?>
    <?php foreach ($list as $task) {
        ?>
        <p style="margin-left:40px;">
            <?php echo (isset($task->dock_list_number) ? $task->dock_list_number : "&nbsp;&nbsp;&nbsp;&nbsp;") . " " . $task->title; ?>
        </p>
        <?php
    } ?>
<?php
}
?>
<!-- <div style="page-break-before: always;"></div> -->

<?php foreach ($tasks as $task) {
    ?>
    <?php
    $page++;
    echo view('projects/export_pdf/layouts/footer.php', ["page" => $page]);
    ?>
    <div style="page-break-before: always;"></div>
    <?php echo view('projects/export_pdf/layouts/header.php', ["project_info" => $project_info]); ?>
    <h3 style="color:#3270b8;"><?php echo $task->title; ?></h3>
    <table style="width:100%;">
        <tbody>
            <tr>

                <td style="width:30%;">
                    <?php echo "DLN : <b>" . $task->dock_list_number . "</b>"; ?>
                </td>
                <td style="width:30%;">
                    <?php echo "Category : <b>" . $task->category . "</b>"; ?>
                </td>
            </tr>
        </tbody>
    </table>
    <p><?php if ($task->supplier)
        echo "Supplier : " . $task->supplier ?></p>
        <div>
        <?php echo $task->description; ?>
    </div>
    <div>
        <?php
        $task_cost_items = array_filter($cost_items, function ($item) use ($task) {
            return $item->task_id == $task->id;
        });
        if (count($task_cost_items) > 0) {
            ?>
            <br />
            <table style="width:80%;border:1px solid lightgray; border-collapse:collapse; margin-left:40px; margin-right:40px;">
                <caption><b>Cost items</b></caption>
                <thead>
                    <tr>
                        <th style="border:1px solid lightgray;width:20%;">Name</th>
                        <th style="border:1px solid lightgray;width:50%;">Quantity X Unit Price</th>
                        <th style="border:1px solid lightgray;width:10%;">Discount</th>
                        <th style="border:1px solid lightgray;width:20%;">Quote</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($task_cost_items as $key => $item) {
                        ?>
                        <tr>
                            <td style="border:1px solid lightgray;text-align:center;">
                                <?php echo $item->name; ?>
                            </td>
                            <td style="border:1px solid lightgray;text-align:center;">
                                <?php echo $item->quantity . " " . $item->measurement . " X " . $project_info->currency . " " . $item->unit_price; ?>
                            </td>
                            <td style="border:1px solid lightgray;text-align:center;">
                                <?php echo $item->discount . " %"; ?>
                            </td>
                            <td style="border:1px solid lightgray;text-align:center;">
                                <?php echo $item->total_cost; ?>
                            </td>
                        </tr>
                        <?php
                    } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <?php
} ?>