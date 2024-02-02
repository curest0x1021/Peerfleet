<div id="page-content" class="page-wrapper clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "general";
            echo view("task_libraries/tabs_new", $tab_view);
            ?>
        </div>
        
        <div class="col-sm-9 col-lg-10">
            <div class="card">
                <div class="card-body">
                    <div class="display-flex" style="align-items:center" >
                        <div style="flex-grow:1" ></div>
                        <label for="title" style="margin:10px" >Search:</label>
                        <input class="form-control" type="text" style="width:20%"  name="search" />
                        <div style="margin:5px" >
                        <?php echo modal_anchor(get_uri("task_libraries/upload_modal"), "<i data-feather='upload' class='icon-16'></i> " . "Import Libraries", array("class" => "btn btn-default import_tasks_btn", "title" => "Import Task Libraries")); ?>
                        </div>
                        <?php echo modal_anchor(get_uri("task_libraries/download_modal"), "<i data-feather='external-link' class='icon-16'></i> " . "Export", array("class" => "btn btn-default export-excel-btn", "title" => "Export Task Libraries")); ?>
                    </div>
                </div>
            </div>
            <?php echo form_open(get_uri("task_libraries"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Task Template Edit</h4>
                    <div>
                        <!-- <button type="button" class="btn btn-danger" style="margin-right:10" ><i data-feather="refresh-cw" class="icon-16"></i> Restore to default</button> -->
                        <button type="submit" 
                        old-id="btn-task-save" 
                        class="btn btn-primary" ><i data-feather="check-circle" class="icon-16"></i> Save</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="row">
                                    <label for="title" class="col-md-4"><?php echo app_lang('title'); ?></label>
                                    <div class="col-md-8">
                                        <?php
                                        echo form_input(array(
                                            "id" => "title",
                                            "name" => "title",
                                            "value" => "",
                                            "class" => "form-control",
                                            "placeholder" => app_lang('title'),
                                            "required"=>true,
                                            "autofocus" => true,
                                            "data-rule-required" => true,
                                            "data-msg-required" => app_lang("field_required"),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="category" class="col-md-4"><?php echo app_lang('category'); ?></label>
                                    <div class="col-md-8">
                                    <?php
                                    $category_dropdown = array(
                                        array("id"=>"General & Docking","text"=>"General & Docking"),
                                        array("id"=>"Hull","text"=>"Hull"),
                                        array("id"=>"Equipment for Cargo","text"=>"Equipment for Cargo"),
                                        array("id"=>"Ship Equipment","text"=>"Ship Equipment"),
                                        array("id"=>"Safety & Crew Equipment","text"=>"Safety & Crew Equipment"),
                                        array("id"=>"Machinery Main Components","text"=>"Machinery Main Components"),
                                        array("id"=>"Systems machinery main components","text"=>"Systems machinery main components"),
                                        array("id"=>"Common systems","text"=>"Common systems"),
                                        array("id"=>"Others","text"=>"Others"),
                                    );
                                    

                                    echo form_input(array(
                                        "id" => "category",
                                        "name" => "labels",
                                        "value" => "",
                                        "class" => "form-control",
                                        "required"=>true,
                                        "placeholder" => app_lang('category'),
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="dock_list_number" class="col-md-4"><?php echo app_lang('dock_list_number'); ?></label>
                                    <div class="col-md-8">
                                        <?php
                                        echo form_input(array(
                                            "id" => "dock_list_number",
                                            "name" => "dock_list_number",
                                            "value" => "",
                                            "class" => "form-control",
                                            "maxlength" => 15,
                                            "placeholder" => app_lang('dock_list_number'),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="row">
                                    <label for="collaborators" class="col-md-3"><?php echo app_lang('collaborators'); ?></label>
                                    <div class="col-md-9">
                                    <?php
                                    $collaborators_dropdown = array(
                                        array(
                                            "id"=>"Ines Erna",
                                            "text"=>"Ines Erna"
                                        ),
                                        array(
                                            "id"=>"Reinhold Gereit",
                                            "text"=>"Reinhold Gereit"
                                        ),
                                        array(
                                            "id"=>"Dominik Darnell",
                                            "text"=>"Dominik Darnell"
                                        ),
                                        array(
                                            "id"=>"Olav Lakshmi",
                                            "text"=>"Olav Lakshmi"
                                        ),
                                        array(
                                            "id"=>"Paul Winfred",
                                            "text"=>"Paul Winfred"
                                        ),
                                    );

                                    echo form_input(array(
                                        "id" => "collaborators",
                                        "name" => "collaborators",
                                        "value" => "",
                                        "class" => "form-control",
                                        "required"=>true,
                                        "placeholder" => app_lang('collaborators'),
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="status" class="col-md-3"><?php echo app_lang('status'); ?></label>
                                    <div class="col-md-9">
                                    <?php
                                        $status_dropdown = array(
                                            array(
                                                "id"=>"To Do",
                                                "text"=>"To Do"
                                            ),
                                            array(
                                                "id"=>"Approved",
                                                "text"=>"Approved"
                                            ),
                                            array(
                                                "id"=>"In Progress",
                                                "text"=>"In Progress"
                                            ),
                                            array(
                                                "id"=>"Done",
                                                "text"=>"Done"
                                            ),
                                            array(
                                                "id"=>"Rejected",
                                                "text"=>"Rejected"
                                            ),
                                        );

                                        echo form_input(array(
                                            "id" => "status",
                                            "name" => "status",
                                            "value" => "",
                                            "class" => "form-control",
                                            "required"=>true,
                                            "placeholder" => app_lang('status'),
                                            "data-rule-required" => true,
                                            "data-msg-required" => app_lang("field_required"),
                                        ));
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="priority" class="col-md-3"><?php echo app_lang('priority'); ?></label>
                                    <div class="col-md-9">
                                    <?php
                                        $priority_dropdown = array(
                                            array(
                                                "id"=>"Minor",
                                                "text"=>"Minor"
                                            ),
                                            array(
                                                "id"=>"Major",
                                                "text"=>"Major"
                                            ),
                                            array(
                                                "id"=>"Critical",
                                                "text"=>"Critical"
                                            ),
                                            array(
                                                "id"=>"Blocker",
                                                "text"=>"Blocker"
                                            )
                                        );

                                        echo form_input(array(
                                            "id" => "priority",
                                            "name" => "priority",
                                            "value" => "",
                                            "class" => "form-control",
                                            "required"=>true,
                                            "placeholder" => app_lang('priority'),
                                            "data-rule-required" => true,
                                            "data-msg-required" => app_lang("field_required"),
                                        ));
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="row">
                                    <label for="milestone" class="col-md-3"><?php echo app_lang('milestone'); ?></label>
                                    <div class="col-md-9">
                                    <?php
                                        $milestone_dropdown = array(
                                            array("name"=>"-","id"=>"-")
                                        );

                                        echo form_input(array(
                                            "id" => "milestone",
                                            "name" => "milestone",
                                            "value" => "",
                                            "class" => "form-control",
                                            "required"=>true,
                                            "placeholder" => app_lang('milestone'),
                                            "data-rule-required" => true,
                                            "data-msg-required" => app_lang("field_required"),
                                        ));
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="supplier" class="col-md-3"><?php echo app_lang('supplier'); ?></label>
                                    <div class="col-md-9">
                                    <?php
                                    $supplier_dropdown = array(
                                        array(
                                            "id"=>"Yard",
                                            "text"=>"Yard"
                                        ),
                                        array(
                                            "id"=>"Specialist",
                                            "text"=>"Specialist"
                                        ),
                                        array(
                                            "id"=>"Both",
                                            "text"=>"Both"
                                        ),
                                    );

                                    echo form_input(array(
                                        "id" => "supplier",
                                        "name" => "supplier",
                                        "value" => "",
                                        "class" => "form-control",
                                        "required"=>true,
                                        "placeholder" => app_lang('supplier'),
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="assigned_to" class="col-md-3"><?php echo app_lang('assign_to'); ?></label>
                                    <div class="col-md-9">
                                        <?php
                                        echo form_input(array(
                                            "id" => "assigned_to",
                                            "name" => "assigned_to",
                                            "value" => "",
                                            "class" => "form-control",
                                            "placeholder" => app_lang('assign_to')
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label for="description" class="col-md-1"><?php echo app_lang('description'); ?></label>
                            <div class="col-md-11"    >
                                <div class="row" >
                                    <div style='width:3%' ></div>
                                    <div style='width:97%' >
                                        <?php
                                        echo form_textarea(array(
                                            "id" => "description",
                                            "name" => "description",
                                            "value" => "",
                                            "class" => "form-control",
                                            "placeholder" => app_lang('description'),
                                            "data-rich-text-editor" => true
                                        ));
                                        ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label for="location" class=" col-md-1"><?php echo app_lang('location'); ?></label>
                            <div class=" col-md-11">
                                <div class="row" >
                                    <div style='width:3%' ></div>
                                    <div style='width:97%' >
                                        <?php
                                        echo form_textarea(array(
                                            "id" => "location",
                                            "name" => "location",
                                            "value" => "",
                                            "class" => "form-control",
                                            "placeholder" => app_lang('location'),
                                            "maxlength" => 300,
                                            "data-rich-text-editor" => true,
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label for="specification" class=" col-md-1"><?php echo app_lang('specification'); ?></label>
                            <div class=" col-md-11">
                                <div class="row" >
                                    <div style='width:3%' ></div>
                                    <div style='width:97%' >
                                        <?php
                                        echo form_textarea(array(
                                            "id" => "specification",
                                            "name" => "specification",
                                            "value" => "",
                                            "class" => "form-control",
                                            "placeholder" => app_lang('specification_placeholder'),
                                            "maxlength" => 300,
                                            "data-rich-text-editor" => true,
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <h4><?php echo app_lang("to_be_included"); ?>:</h4>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="gas_free_certificate" class="col-7"><?php echo app_lang('gas_free_certificate'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "gas_free_certificate_yes",
                                                    "name" => "gas_free_certificate",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="gas_free_certificate_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "gas_free_certificate_no",
                                                    "name" => "gas_free_certificate",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="gas_free_certificate_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="painting_after_completion" class="col-7"><?php echo app_lang('painting_after_completion'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "painting_after_completion_yes",
                                                    "name" => "painting_after_completion",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="painting_after_completion_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "painting_after_completion_no",
                                                    "name" => "painting_after_completion",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="painting_after_completion_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="light" class="col-7"><?php echo app_lang('light'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "light_yes",
                                                    "name" => "light",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="light_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "light_no",
                                                    "name" => "light",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="light_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="parts_on_board" class="col-7"><?php echo app_lang('parts_on_board'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "parts_on_board_yes",
                                                    "name" => "parts_on_board",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="parts_on_board_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "parts_on_board_no",
                                                    "name" => "parts_on_board",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="parts_on_board_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="ventilation" class="col-7"><?php echo app_lang('ventilation'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "ventilation_yes",
                                                    "name" => "ventilation",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="ventilation_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "ventilation_no",
                                                    "name" => "ventilation",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="ventilation_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="transport_to_yard_workshop" class="col-7"><?php echo app_lang('transport_to_yard_workshop'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "transport_to_yard_workshop_yes",
                                                    "name" => "transport_to_yard_workshop",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="transport_to_yard_workshop_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "transport_to_yard_workshop_no",
                                                    "name" => "transport_to_yard_workshop",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="transport_to_yard_workshop_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="crane_assistance" class="col-7"><?php echo app_lang('crane_assistance'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "crane_assistance_yes",
                                                    "name" => "crane_assistance",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="crane_assistance_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "crane_assistance_no",
                                                    "name" => "crane_assistance",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="crane_assistance_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="transport_outside_yard" class="col-7"><?php echo app_lang('transport_outside_yard'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "transport_outside_yard_yes",
                                                    "name" => "transport_outside_yard",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="transport_outside_yard_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "transport_outside_yard_no",
                                                    "name" => "transport_outside_yard",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="transport_outside_yard_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="cleaning_before" class="col-7"><?php echo app_lang('cleaning_before'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "cleaning_before_yes",
                                                    "name" => "cleaning_before",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="cleaning_before_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "cleaning_before_no",
                                                    "name" => "cleaning_before",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="cleaning_before_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="material_yards_supply" class="col-7"><?php echo app_lang('material_yards_supply'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "material_yards_supply_yes",
                                                    "name" => "material_yards_supply",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="material_yards_supply_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "material_yards_supply_no",
                                                    "name" => "material_yards_supply",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="material_yards_supply_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="cleaning_after" class="col-7"><?php echo app_lang('cleaning_after'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "cleaning_after_yes",
                                                    "name" => "cleaning_after",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="cleaning_after_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "cleaning_after_no",
                                                    "name" => "cleaning_after",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="cleaning_after_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="material_owners_supply" class="col-7"><?php echo app_lang('material_owners_supply'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "material_owners_supply_yes",
                                                    "name" => "material_owners_supply",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="material_owners_supply_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "material_owners_supply_no",
                                                    "name" => "material_owners_supply",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="material_owners_supply_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="work_permit" class="col-7"><?php echo app_lang('work_permit'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "work_permit_yes",
                                                    "name" => "work_permit",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="work_permit_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "work_permit_no",
                                                    "name" => "work_permit",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="work_permit_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="risk_assessment" class="col-7"><?php echo app_lang('risk_assessment'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "risk_assessment_yes",
                                                    "name" => "risk_assessment",
                                                    "class" => "form-check-input",
                                                ), "1", true);
                                                ?>
                                                <label for="risk_assessment_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "risk_assessment_no",
                                                    "name" => "risk_assessment",
                                                    "class" => "form-check-input",
                                                ), "0", false);
                                                ?>
                                                <label for="risk_assessment_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div>
                                <h4><?php echo app_lang("maker_informations"); ?>:</h4>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="maker" class=" col-md-4"><?php echo app_lang('maker'); ?></label>
                                    <div class=" col-md-8">
                                        <?php
                                        echo form_input(array(
                                            "id" => "maker",
                                            "name" => "maker",
                                            "value" => "",
                                            "class" => "form-control",
                                            "maxlength" => 30,
                                            "placeholder" => app_lang('maker'),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="type" class=" col-md-4"><?php echo app_lang('type'); ?></label>
                                    <div class=" col-md-8">
                                        <?php
                                        echo form_input(array(
                                            "id" => "type",
                                            "name" => "type",
                                            "value" => "",
                                            "class" => "form-control",
                                            "maxlength" => 30,
                                            "placeholder" => app_lang('type'),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="serial_number" class=" col-md-4"><?php echo app_lang('serial_number'); ?></label>
                                    <div class=" col-md-8">
                                        <?php
                                        echo form_input(array(
                                            "id" => "serial_number",
                                            "name" => "serial_number",
                                            "value" => "",
                                            "class" => "form-control",
                                            "maxlength" => 30,
                                            "placeholder" => app_lang('serial_number'),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="pms_scs_number" class=" col-md-4"><?php echo app_lang('pms_scs_number'); ?></label>
                                    <div class=" col-md-8">
                                        <?php
                                        echo form_input(array(
                                            "id" => "pms_scs_number",
                                            "name" => "pms_scs_number",
                                            "value" => "",
                                            "class" => "form-control",
                                            "maxlength" => 30,
                                            "placeholder" => app_lang('pms_scs_number'),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" >
                            <div class="card" style="border: solid 1px lightgray;">
                                <div class="card-header d-flex">
                                    <b>Quotes from yard</b>
                                </div>
                                <div class="card-body" style="padding:1px" >
                                    <table class="table " style="margin:0" >
                                        <thead>
                                        <tr>
                                            <td>Cost item name</td>
                                            <td>UNIT PRICE AND QUANTITY</td>
                                            <td>QUOTE</td>
                                            <td style="float:right" ><button class="btn btn-default btn-sm" ><i data-feather="plus" class ></i></button></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Initial Visit Incl Transport</td>
                                            <td>1.0 visit X USD 0.00 (Per unit)</td>
                                            <td>USD 0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Subsequent Visits Incl Transport</td>
                                            <td>20.0 visit X USD 0.00 (Per unit)</td>
                                            <td>USD 0.00</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-6" ></div>
                        <!-- <div class="col-md-6" >
                            <div class="card" style="border: solid 1px lightgray;">
                                <div class="card-header d-flex">
                                    <b>Owner's supply</b>
                                </div>
                                <div class="card-body" style="padding:1px" >
                                    <table class="table " style="margin:0" >
                                        <thead>
                                        <tr>
                                            <td>SUPPLY<br/>PO NUMBER</td>
                                            <td>SUPPLIER</td>
                                            <td>STATUS</td>
                                            <td>COST</td>
                                            <td>SHARED WITH</td>
                                            <td style="float:right" ><button class="btn btn-default btn-sm" ><i data-feather="plus" class ></i></button></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div> -->
                        <!-- <div class="col-md-6" ></div> -->
                        <!-- <div class="col-md-6" >
                            <div class="card" style="border: solid 1px lightgray;">
                                <div class="card-header d-flex">
                                    <b>Work order quotes</b>
                                </div>
                                <div class="card-body" style="padding:1px" >
                                    <table class="table " style="margin:0" >
                                        <thead>
                                        <tr>
                                            <td>QUOTE</td>
                                            <td>COST</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Estimated cost</td>
                                            <td>USD 0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Quoted cost</td>
                                            <td>USD 0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Billed cost</td>
                                            <td>USD 0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Final cost</td>
                                            <td>USD 0.00</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                        
                    </div>
                    <button id="file-selector-btn" class="btn btn-default" ><i data-feather="file" class=""></i> Upload File</button>
                    <input type="file" id="file-selector" hidden/> 
                </div>
                
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?php echo view("includes/cropbox"); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#category").select2({
            multiple: false,
            data: <?php echo (json_encode($category_dropdown)); ?>
        });
        $("#supplier").select2({
            multiple: false,
            data: <?php echo (json_encode($supplier_dropdown)); ?>
        });
        $("#milestone").select2({
            multiple: false,
            data: <?php echo (json_encode($milestone_dropdown)); ?>
        });
        $("#status").select2({
            multiple: false,
            data: <?php echo (json_encode($status_dropdown)); ?>
        });
        $("#priority").select2({
            multiple: false,
            data: <?php echo (json_encode($priority_dropdown)); ?>
        });
        $("#collaborators").select2({
            multiple: false,
            data: <?php echo (json_encode($collaborators_dropdown)); ?>
        });
        
        $('#description').summernote({
            height:250
        });
        $("#file-selector-btn").on('click',function(){
            $("#file-selector").click()
        })
        setDatePicker("#start_date");
        setDatePicker("#deadline");
    });

    
    
</script>
