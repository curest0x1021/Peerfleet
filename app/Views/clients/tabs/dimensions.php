<div class="card" >
    <div class="card-body">
        <div class="d-flex justify-content-end" >
        
        <?php echo modal_anchor(get_uri("clients/modal_import_dimensions/".$client_info->id),'<button class="btn btn-default" target="_blank" ><i data-feather="upload" class="icon-16"  ></i>Import</button>',array());?>
        <a class="btn btn-default" style="margin-left:1vw;" href="<?php echo get_uri("clients/export_dimensions/".$client_info->id);?>" target="_blank" ><i data-feather="download" class="icon-16"  ></i>Export</a>
        </div>
        
        <div class="row" >
            <div class="col-md-4" >
                <h4>Dimensions</h4>
                <div style="margin-left:2vw;" >
                <p>
                    Gross Tonnage : <?php echo $client_info->gross_tonnage;?>
                </p>
                <p>
                    Net Tonnage : <?php echo $client_info->net_tonnage;?>
                </p>
                <p>
                    Lightweight : <?php echo $client_info->lightweight;?>
                </p>
                <p>
                    Length over all : <?php echo $client_info->length_over_all;?>
                </p>
                <p>
                    Length between perpendiculars : <?php echo $client_info->length_between_perpendiculars;?>
                </p>
                <p>
                    Length of waterline : <?php echo $client_info->length_of_waterline;?>
                </p>
                <p>
                    BEAM/Bredth Moulded : <?php echo $client_info->breadth_moulded;?>
                </p>
                <p>
                    Depth Moulded : <?php echo $client_info->depth_moulded;?>
                </p>
                <p>
                    Draft/Draught Design : <?php echo $client_info->draught_design;?>
                </p>
                <p>
                    Draught scantling : <?php echo $client_info->draught_scantling;?>
                </p>
                <p>
                    Hull design : <?php echo $client_info->hull_design;?>
                </p>
            </div>
            <br/>
            <h4>Hull surfaces</h4>
            <div style="margin-left:2vw;" >
                <p>
                    Top sides : <?php echo $client_info->top_sides;?>
                </p>
                <p>
                    Bottom sides : <?php echo $client_info->bottom_sides;?>
                </p>
                <p>
                    Flat bottom : <?php echo $client_info->flat_bottom;?>
                </p>
                </div>
            </div>
            <div class="col-md-4" >
                <h4>Capacities</h4>
                <div style="margin-left:2vw;" >
                <p>
                    DWT cargo : <?php echo $client_info->dwt_cargo;?>
                </p>
                <p>
                    DWT design : <?php echo $client_info->dwt_design;?>
                </p>
                <p>
                    DWT scantling : <?php echo $client_info->dwt_scantling;?>
                </p>
                <p>
                    Heavy fuel oil : <?php echo $client_info->heavy_fuel_oil;?>
                </p>
                <p>
                    Marine diesel oil : <?php echo $client_info->marine_diesel_oil;?>
                </p>
                <p>
                    Marine gas oil : <?php echo $client_info->marine_gas_oil;?>
                </p>
                <p>
                    LNG Capacity : <?php echo $client_info->lng_capacity;?>
                </p>
                <p>
                    Lub oil : <?php echo $client_info->lub_oil;?>
                </p>
                <p>
                    Ballast water : <?php echo $client_info->ballast_water;?>
                </p>
                <p>
                    Fresh water : <?php echo $client_info->fresh_water;?>
                </p>
                </div>
            </div>
        </div>
    </div>
</div>