<div class="card" >
    <div class="card-body">
        <a class="btn btn-default" href="<?php echo get_uri("clients/export_dimensions/".$client_info->id);?>" target="_blank" ><i data-feather="download" class="icon-16"  ></i>Export Dimensions & Capacities</a>
        <div class="row" >
            <div class="col-md-6" >
                <h3>Dimensions</h3>
                <h4>
                    Gross Tonnage : <?php echo $client_info->gross_tonnage;?>
                </h4>
                <h4>
                    Net Tonnage : <?php echo $client_info->net_tonnage;?>
                </h4>
                <h4>
                    Lightweight : <?php echo $client_info->lightweight;?>
                </h4>
                <h4>
                    Length over all : <?php echo $client_info->length_over_all;?>
                </h4>
                <h4>
                    Length between perpendiculars : <?php echo $client_info->length_between_perpendiculars;?>
                </h4>
                <h4>
                    Length of waterline : <?php echo $client_info->length_of_waterline;?>
                </h4>
                <h4>
                    BEAM/Bredth Moulded : <?php echo $client_info->breadth_moulded;?>
                </h4>
                <h4>
                    Depth Moulded : <?php echo $client_info->depth_moulded;?>
                </h4>
                <h4>
                    Draft/Draught Design : <?php echo $client_info->draught_design;?>
                </h4>
                <h4>
                    Draught scantling : <?php echo $client_info->draught_scantling;?>
                </h4>
                <h4>
                    Hull design : <?php echo $client_info->hull_design;?>
                </h4>
                <h3>Hull surfaces</h3>
                <h4>
                    Top sides : <?php echo $client_info->top_sides;?>
                </h4>
                <h4>
                    Bottom sides : <?php echo $client_info->bottom_sides;?>
                </h4>
                <h4>
                    Flat bottom : <?php echo $client_info->flat_bottom;?>
                </h4>
            </div>
            <div class="col-md-6" >
                <h3>Capacities</h3>
                <h4>
                    DWT cargo : <?php echo $client_info->dwt_cargo;?>
                </h4>
                <h4>
                    DWT design : <?php echo $client_info->dwt_design;?>
                </h4>
                <h4>
                    DWT scantling : <?php echo $client_info->dwt_scantling;?>
                </h4>
                <h4>
                    Heavy fuel oil : <?php echo $client_info->heavy_fuel_oil;?>
                </h4>
                <h4>
                    Marine diesel oil : <?php echo $client_info->marine_diesel_oil;?>
                </h4>
                <h4>
                    Marine gas oil : <?php echo $client_info->marine_gas_oil;?>
                </h4>
                <h4>
                    LNG Capacity : <?php echo $client_info->lng_capacity;?>
                </h4>
                <h4>
                    Lub oil : <?php echo $client_info->lub_oil;?>
                </h4>
                <h4>
                    Ballast water : <?php echo $client_info->ballast_water;?>
                </h4>
                <h4>
                    Fresh water : <?php echo $client_info->fresh_water;?>
            </div>
        </div>
    </div>
</div>