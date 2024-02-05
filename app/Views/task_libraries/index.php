<div id="tasks-dropzone" class="post-dropzone">
<div id="page-content" class="page-wrapper clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "general";
            echo view("task_libraries/tabs", $tab_view);
            ?>
        </div>

        <div class="col-sm-9 col-lg-10">
            <div class="card">
                <div class="card-body">
                    <div class="display-flex" style="align-items:center" >
                        <div style="flex-grow:1" ></div>
                        <label for="title" style="margin:10px" >Search:</label>
                        <input class="form-control" type="text" style="width:20%"  name="search" />
                        <a class="btn btn-default" href="<?php echo get_uri("task_libraries");?>" style="margin:5px" ><i data-feather="plus-circle" ></i> Add Library</a>
                        <div style="margin:5px" >
                        <?php echo modal_anchor(get_uri("task_libraries/import_modal"), "<i data-feather='upload' class='icon-16'></i> " . "Import Libraries", array("class" => "btn btn-default import_tasks_btn", "title" => "Import Task Libraries")); ?>
                        </div>
                        <?php echo modal_anchor(get_uri("task_libraries/export_modal"), "<i data-feather='external-link' class='icon-16'></i> " . "Export", array("class" => "btn btn-default export-excel-btn", "title" => "Export Task Libraries")); ?>
                    </div>
                </div>
            </div>
            <div class="card">
                <?php echo form_open(get_uri("task_libraries/save"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
                <?php if(isset($gotTasklibrary))
                    echo '<input hidden name="id" value="'.$gotTasklibrary->id.'" />';
                ?>
                <div class="card-header d-flex justify-content-between">
                    <h4>Task Library Edit</h4>
                    <div>
                        <!-- <button type="button" class="btn btn-danger" style="margin-right:10" ><i data-feather="refresh-cw" class="icon-16"></i> Restore to default</button> -->
                        <button type="button" 
                        old-id="btn-task-save"
                        id="btn-save-task-library"
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
                                            "value" => isset($gotTasklibrary) ?$gotTasklibrary->title:"",
                                            "class" => "form-control",
                                            "placeholder" => app_lang('title'),
                                            "autofocus" => true,
                                            "required"=>true,
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
                                        "name" => "category",
                                        "value" => isset($gotTasklibrary)?$gotTasklibrary->category:"",
                                        "class" => "form-control",
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
                                        $dock_list_number_now="";
                                        if(isset($gotTasklibrary)){
                                            $count=1;
                                            if(!$gotTasklibrary->category){
                                                $gotTasklibrary["category"]="Others";
                                            }
                                            foreach($allTasklibraries as $oneTaskLibrary){
                                                if($oneTaskLibrary['title']==$gotTasklibrary->title) break;
                                                if($oneTaskLibrary['category']==$gotTasklibrary->category) $count++;
                                            }
                                            $dock_list_number_now=strtoupper($gotTasklibrary->category[0]).sprintf("%02d",$count);
                                        }
                                        
                                        echo form_input(array(
                                            "id" => "dock_list_number",
                                            "name" => "dock_list_number",
                                            // "value" => isset($gotTasklibrary)?$gotTasklibrary->dock_list_number:"",
                                            "value" => $dock_list_number_now,
                                            "class" => "form-control",
                                            "maxlength" => 15,
                                            "readonly"=>true,
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
                                    <label for="supplier" class="col-md-3"><?php echo app_lang('supplier'); ?></label>
                                    <div class="col-md-9">
                                        <?php
                                        $suppliers_dropdown=array(
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
                                            "value" =>isset($gotTasklibrary)&& $gotTasklibrary->supplier?$gotTasklibrary->supplier:$suppliers_dropdown[0]['id'],
                                            "class" => "form-control",
                                            "placeholder" => app_lang('supplier'),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="status_id" class="col-md-3"><?php echo app_lang('status'); ?></label>
                                    <div class="col-md-9">
                                        <?php
                                        $status_dropdown=array();
                                        foreach($allStatus as $oneStatus){
                                            $status_dropdown[]=array("id"=>$oneStatus['id'],'text'=>$oneStatus['title']);
                                        }
                                        echo form_input(array(
                                            "id" => "status_id",
                                            "name" => "status_id",
                                            "value" => isset($gotTasklibrary)&&$gotTasklibrary->status_id?$gotTasklibrary->status_id:$status_dropdown[0]['id'],
                                            "class" => "form-control"
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="priority_id" class="col-md-3"><?php echo app_lang('priority'); ?></label>
                                    <div class="col-md-9">
                                        <?php
                                        $priority_dropdown=array();
                                        foreach($allPriorities as $onePriority){
                                            $priority_dropdown[]=array("id"=>$onePriority['id'],'text'=>$onePriority['title']);
                                        }
                                        echo form_input(array(
                                            "id" => "priority_id",
                                            "name" => "priority_id",
                                            "value" => isset($gotTasklibrary)&&$gotTasklibrary->priority_id?$gotTasklibrary->priority_id:$priority_dropdown[0]['id'],
                                            "class" => "form-control",
                                            "maxlength" => 15,
                                            "placeholder" => app_lang('priority'),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            
                            <div class="form-group">
                                <div class="row">
                                    <label for="milestone_id" class="col-md-3"><?php echo app_lang('milestone'); ?></label>
                                    <div class="col-md-9">
                                        <?php
                                        $milestone_dropdown=array();
                                        foreach ($allMilestones as $oneMilestone) {
                                            $milestone_dropdown[]=array("id"=>$oneMilestone['id'],"text"=>$oneMilestone['title']);
                                        }
                                        echo form_input(array(
                                            "id" => "milestone_id",
                                            "name" => "milestone_id",
                                            "value" => isset($gotTasklibrary)&&$gotTasklibrary->milestone_id?$gotTasklibrary->milestone_id:$milestone_dropdown[0]['id'],
                                            "class" => "form-control",
                                            "placeholder" => app_lang('milestone')
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
                                            "value" => isset($gotTasklibrary)&&$gotTasklibrary->assigned_to?$gotTasklibrary->assigned_to:"",
                                            "class" => "form-control",
                                            // "required"=>true,
                                            "placeholder" => app_lang('assign_to')
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="collaborators" class="col-md-3"><?php echo app_lang('collaborators'); ?></label>
                                    <div class="col-md-9">
                                    <?php
                                    $collaborators_dropdown = array(
                                        array(
                                            "id"=>"-",
                                            "text"=>"-"
                                        ),
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
                                        "value" => isset($gotTasklibrary)&&$gotTasklibrary->collaborators?$gotTasklibrary->collaborators:"-",
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
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label for="description" class=" col-md-1"><?php echo app_lang('description'); ?></label>
                            <div class=" col-md-11">
                                <div class="row" >
                                    <div style="width:3%" ></div>
                                    <div style="width:97%" >
                                    <?php
                                    echo form_textarea(array(
                                        "id" => "description",
                                        "name" => "description",
                                        "value" => isset($gotTasklibrary)&&$gotTasklibrary->description?$gotTasklibrary->description:"",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('description'),
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
                            <label for="location" class=" col-md-1"><?php echo app_lang('location'); ?></label>
                            <div class=" col-md-11">
                                <div class="row" >
                                    <div style="width:3%" ></div>
                                    <div style="width:97%" >
                                    <?php
                                    echo form_textarea(array(
                                        "id" => "location",
                                        "name" => "location",
                                        "value" => isset($gotTasklibrary)&&$gotTasklibrary->location?$gotTasklibrary->location:"",
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
                                    <div style="width:3%" ></div>
                                    <div style="width:97%" >
                                    <?php
                                    echo form_textarea(array(
                                        "id" => "specification",
                                        "name" => "specification",
                                        "value" => isset($gotTasklibrary)&&$gotTasklibrary->specification?$gotTasklibrary->specification:"",
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
                    </div>
                    <div class="row" >
                        <div class="col-md-8" >
                            <div class="card" style="border: solid 1px lightgray;">
                                <div class="card-header d-flex">
                                    <b>Cost Item List</b>
                                </div>
                                <div class="card-body" style="padding:1px" >
                                    <table id="table-quotes-from-yard" class="table " style="margin:0" >
                                        <thead>
                                        <tr>
                                            <td>Cost item name</td>
                                            <td>UNIT PRICE AND QUANTITY</td>
                                            <td>QUOTE</td>
                                            <td style="float:right" ><button type="button" id="btn-add-new-quote" class="btn btn-default btn-sm" ><i data-feather="plus" class ></i></button></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- <tr>
                                            <td>Initial Visit Incl Transport</td>
                                            <td>1.0 visit X USD 0.00 (Per unit)</td>
                                            <td>USD 0.00</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Subsequent Visits Incl Transport</td>
                                            <td>20.0 visit X USD 0.00 (Per unit)</td>
                                            <td>USD 0.00</td>
                                            <td></td>
                                        </tr> -->
                                        </tbody>
                                    </table>
                                    <div id="insert-cost-item-panel" style="margin:5px;" hidden>
                                        <div style="min-height:5vh" ></div>
                                        <div class="row" >
                                            <div class="form-group" >
                                                <label>Cost item name:</label>
                                                <input
                                                    id="cost_item_name"
                                                    class="form-control"
                                                    type="text"
                                                />
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="form-group" >
                                                <label>Description:</label>
                                                <textarea
                                                    id="cost_item_description"
                                                    class="form-control"
                                                    type="text"
                                                ></textarea>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-md-6" >
                                                <div class="form-group" >
                                                    <label>Quote type:</label>
                                                    <select
                                                        name="cost_item_quote_type"
                                                        id="cost_item_quote_type"
                                                        class="form-control"
                                                    >
                                                        <option>Per unit</option>
                                                        <option>Lump sum</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" >
                                                <div class="form-group" >
                                                    <label>Quantity:</label>
                                                    <input
                                                        id="cost_item_quantity"
                                                        class="form-control"
                                                        type="number"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-3" >
                                                <div class="form-group" >
                                                    <label>Measurement unit:</label>
                                                    <input
                                                        id="cost_item_measurement_unit"
                                                        class="form-control"
                                                        placeholder="pcs"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-md-6" >
                                                <div class="form-group" >
                                                    <label>Unit price:</label>
                                                    <div class="input-group mb-3">
                                                        <input readonly type="text" class="form-control" value="$">
                                                        <input id="cost_item_unit_price" type="text" class="form-control" value="0.00">
                                                        <select id="cost_item_currency" class="form-control">
                                                            <option>USD</option>
                                                            <option>AED</option>
                                                            <option>AFN</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2" >
                                                <div class="form-group" >
                                                    <label>Discount:</label>
                                                    <div class="input-group mb-3">
                                                        <input id="cost_item_discount" type="text" class="form-control" value="0.0">
                                                        <input readonly type="text" class="form-control" value="%" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="form-group" >
                                                <label>Yard remarks:</label>
                                                <textarea id="cost_item_yard_remarks" class="form-control" name="yard_remarks" ></textarea>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-md-1" >
                                                <button id="insert-add-cost-item" type="button" class="btn btn-primary" >Save</button>
                                            </div>
                                            <div class="col-md-1" >
                                                <button id="cancel-add-cost-item" type="button" class="btn btn-default" >Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-4"  >
                            <!--checklist-->
                            <div class="card" style="border:1px solid lightgray;" >
                            <?php 
                            // echo form_open(get_uri("tasks/save_checklist_item"), array("id" => "checklist_form", "class" => "general-form", "role" => "form")); 
                            ?>
                            <div class="card-header d-flex">
                                <strong class="float-start mr10"><?php echo app_lang("checklist"); ?></strong><span class="chcklists_status_count">0</span><span>/</span><span class="chcklists_count"></span>
                            </div>
                            <div class="card-body d-flex" >
                                <div class="col-md-12 mb15 b-t">
                                    <div class="pb10 pt10">
                                        <!-- <strong class="float-start mr10"><?php echo app_lang("checklist"); ?></strong><span class="chcklists_status_count">0</span><span>/</span><span class="chcklists_count"></span> -->
                                    </div>
                                    <input type="hidden" id="is_checklist_group" name="is_checklist_group" value="" />
                                    <div class="checklist-items" id="checklist-items">
                                        <!--chekclist-items-lsiting-here-->
                                    <?php
                                        if(isset($gotChecklistItems))
                                        foreach($gotChecklistItems as $oneItem){
                                            echo '<div id="checklist-item-row-33" class="list-group-item mb5 checklist-item-row b-a rounded text-break" data-id="33"><a href="#" title="" data-id="33" data-value="1" data-act="update-checklist-item-status-checkbox"><span class="checkbox-blank mr15 float-start"></span></a><a href="#" class="delete-checklist-item" title="Delete checklist item" data-fade-out-on-success="#checklist-item-row-33" data-act="ajax-request" data-action-url="'. get_uri("/task_libraries"."/delete_checklist_item"."/".$oneItem->id).'"><div class="float-end"><i data-feather="x" class="icon-16"></i></div></a><span class="font-13">'.$oneItem->title.'</span></div>';
                                        }
                                    ?>
                                    </div>
                                        <div class="mb5 mt5 btn-group checklist-options-panel hide" role="group">
                                            <button id="type-new-item-button" type="button" class="btn btn-default checklist_button active"> <?php echo app_lang('type_new_item'); ?></button>
                                            <button id="select-from-template-button" type="button" class="btn btn-default checklist_button"> <?php echo app_lang('select_from_template'); ?></button>
                                            <!-- <button id="select-from-checklist-group-button" type="button" class="btn btn-default checklist_button"> <?php echo app_lang('select_from_checklist_group'); ?></button> -->
                                        </div>
                                        <div class="form-group">
                                            <div class="mt5 p0">
                                                <?php
                                                echo form_input(array(
                                                    "id" => "checklist-add-item",
                                                    "name" => "checklist-add-item",
                                                    "class" => "form-control",
                                                    "placeholder" => app_lang('add_item'),
                                                    "data-rule-required" => true,
                                                    "data-msg-required" => app_lang("field_required"),
                                                    "autocomplete" => "off"
                                                ));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="mb10 p0 checklist-options-panel hide">
                                            <button id="add-checklist-item" type="button" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></button>
                                            <button id="checklist-options-panel-close" type="button" class="btn btn-default ms-2"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('cancel'); ?></button>
                                        </div>
                                </div>
                            </div>
                            <?php 
                            // echo form_close(); 
                            ?> 
                            </div>
                        </div>
                        
                    </div>
                    <!-- <button type="button" id="file-selector-btn" class="btn btn-default" ><i data-feather="file" class=""></i> Upload File</button>
                    <input type="file" id="file-selector" hidden/> -->
                    <div><?php echo view("includes/dropzone_preview"); ?></div>
                    <div stlyle="margin-top:10px" >
                        <button class="btn btn-default upload-file-button float-start me-auto btn-sm round" type="button" style="color:#7988a2"><i data-feather="camera" class="icon-16"></i> <?php echo app_lang("upload_file"); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo view("includes/cropbox"); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#file-selector-btn").on("click",function(){
            $("#file-selector")[0].click();
        })
        $("#category").select2({
            data: <?php echo (json_encode($category_dropdown)); ?>
        });
        $("#category").on("change",function(e){
            
            $.ajax({
                url: '<?php echo_uri("task_libraries/get_count"); ?>/'+e.target.value,
                type: 'GET',
                // dataType: 'json',
                // data: {value: $(this).attr('data-value')},
                success: function (response) {
                    console.log(response)
                    var prefix=e.target.value[0].toUpperCase();
                    $("#dock_list_number")[0].value=prefix+(Number(response)+1).toString().padStart(2, '0');
                }
            });
        })
        $("#collaborators").select2({
            data: <?php echo (json_encode($collaborators_dropdown)); ?>
        });
        $("#status_id").select2({
            data: <?php echo (json_encode($status_dropdown)); ?>
        });
        $("#priority_id").select2({
            data: <?php echo (json_encode($priority_dropdown)); ?>
        });
        $("#milestone_id").select2({
            data: <?php echo (json_encode($milestone_dropdown)); ?>
        });
        $("#supplier").select2({
            data: <?php echo (json_encode($suppliers_dropdown)); ?>
        });
        setDatePicker("#start_date");
        setDatePicker("#deadline");
        $('#description').summernote({
            height:250
        });
        var $selector = $("#checklist-items");
        Sortable.create($selector[0], {
            animation: 150,
            chosenClass: "sortable-chosen",
            ghostClass: "sortable-ghost",
            onUpdate: function (e) {
                appLoader.show();
                //prepare checklist items indexes
                var data = "";
                $.each($selector.find(".checklist-item-row"), function (index, ele) {
                    if (data) {
                        data += ",";
                    }

                    data += $(ele).attr("data-id") + "-" + parseInt(index + 1);
                });

                //update sort indexes
                $.ajax({
                    url: '<?php echo_uri("task_librareis/save_checklist_items_sort") ?>',
                    type: "POST",
                    data: {sort_values: data},
                    success: function () {
                        appLoader.hide();
                    }
                });
            }
        });

        //show the items in checklist

        //show save & cancel button when the checklist-add-item-form is focused
        $("#checklist-add-item").focus(function () {
            $(".checklist-options-panel").removeClass("hide");
            $("#checklist-add-item-error").removeClass("hide");
        });

        $("#checklist-options-panel-close").click(function () {
            $(".checklist-options-panel").addClass("hide");
            $("#checklist-add-item-error").addClass("hide");
            $("#checklist-add-item").val("");

            $("#checklist-add-item").select2("destroy").val("");
            $("#checklist-template-toggle-button").html("<?php echo "<i data-feather='hash' class='icon-16'></i> " . app_lang('select_from_template'); ?>");
            $("#checklist-template-toggle-button").addClass('checklist-template-button');
            feather.replace();

            $(".checklist_button").removeClass("active");
            $("#type-new-item-button").addClass("active");
        });

        //count checklists
        function count_checklists() {
            var checklists = $(".checklist-items .checklist-item-row").length;
            $(".chcklists_count").text(checklists);

            //reload kanban
            $("#reload-kanban-button:visible").trigger("click");
        }

        var checklists = $(".checklist-items .checklist-item-row").length;
        $(".delete-checklist-item").click(function () {
            checklists--;
            console.log("dleted")
            $(".chcklists_count").text(checklists);
        });

        count_checklists();

        var checklist_complete = $(".checklist-items .checkbox-checked").length;
        $(".chcklists_status_count").text(checklist_complete);

        $("#checklist_form").appForm({
            isModal: false,
            onSuccess: function (response) {
                $("#checklist-add-item").val("");
                $("#checklist-add-item").focus();
                $("#checklist-items").append(response.data);

                count_checklists();
            }
        });
         //change the add checklist input box type
         $("#select-from-template-button").click(function() {
            $(".checklist_button").removeClass("active");
            applySelect2OnChecklistTemplate();
            $(this).addClass("active");
            $("#is_checklist_group").val("0");
        });

        $("#select-from-checklist-group-button").click(function() {
            $(".checklist_button").removeClass("active");
            applySelect2OnChecklistGroup();
            $(this).addClass("active");
            $("#is_checklist_group").val("1");
        });

        $("#type-new-item-button").click(function() {
            $(".checklist_button").removeClass("active");
            $("#checklist-add-item").select2("destroy").val("").focus();
            $("#is_checklist_group").val("0");
            $(this).addClass("active");
        });

        function applySelect2OnChecklistTemplate() {
            $("#checklist-add-item").select2({
                showSearchBox: true,
                ajax: {
                    url: "<?php echo get_uri("task_libraries/get_checklist_template_suggestion"); ?>",
                    type: 'POST',
                    dataType: 'json',
                    quietMillis: 250,
                    data: function(term, page) {
                        return {
                            q: term, // search term
                        };
                    },
                    results: function(data, page) {
                        return {
                            results: data
                        };
                        $("#checklist-add-item").val("");
                    }
                }
            });
        }

        function applySelect2OnChecklistGroup() {
            $("#checklist-add-item").select2({
                showSearchBox: true,
                ajax: {
                    url: "<?php echo get_uri("task_libraries/get_checklist_group_suggestion"); ?>",
                    type: 'POST',
                    dataType: 'json',
                    quietMillis: 250,
                    data: function(term, page) {
                        return {
                            q: term, // search term
                        };
                    },
                    results: function(data, page) {
                        return {
                            results: data
                        };
                        $("#checklist-add-item").val("");
                    }
                }
            });
        }
        
        $('body').on('click', '[data-act=update-checklist-item-status-checkbox]', function () {
            var status_checkbox = $(this).find("span");
            if(status_checkbox.hasClass('checkbox-checked')){
                status_checkbox.removeClass("checkbox-checked");
                checklist_complete--;
            }else {
                status_checkbox.addClass("checkbox-checked");
                checklist_complete++;
            }
            $(".chcklists_status_count").text(checklist_complete);
            // status_checkbox.addClass("checkbox-checked");
            // status_checkbox.removeClass("checkbox-checked");
            // status_checkbox.addClass("inline-loader");

            // if ($(this).attr('data-value') == 0) {
            //     checklist_complete--;
            //     $(".chcklists_status_count").text(checklist_complete);
            // } else {
            //     checklist_complete++;
            //     $(".chcklists_status_count").text(checklist_complete);
            //     status_checkbox.addClass("checkbox-checked");
            // }

        });
        $("#btn-add-new-quote").on("click",function(){
            $("#insert-cost-item-panel").prop("hidden",false);
            $("#btn-add-new-quote").prop("disabled", true);
            // var table=$("#table-quotes-from-yard")[0].getElementsByTagName('tbody')[0];
            // var newRow = table.insertRow();

            // var cell0 = newRow.insertCell(0);
            // var cell1 = newRow.insertCell(1);
            // var cell2 = newRow.insertCell(2);
            // var cell3 = newRow.insertCell(3);

            
            // cell1.innerHTML = `<input placeholder="Unit price and quantity" class="form-control" id="quote_price" />`;
            // cell2.innerHTML = `<input placeholder="Quote" class="form-control" id="quote_quote" />`;
            // cell3.innerHTML = `<button onClick="save_new_quote()" type="button" id="btn-save-new-quote" class="btn btn-default" ><i data-feather="check" ></i></button>`;
            // $("#btn-add-new-quote").prop("disabled", true);
        })
        $("#insert-add-cost-item").on("click",function(){
            var table=$("#table-quotes-from-yard")[0].getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();

            var cell0 = newRow.insertCell(0);
            var cell1 = newRow.insertCell(1);
            var cell2 = newRow.insertCell(2);
            var cell3 = newRow.insertCell(3);

            cell0.innerHTML = $("#cost_item_name")[0].value;
            cell1.innerHTML = Number($("#cost_item_quantity")[0].value).toFixed(1)+' '+$("#cost_item_measurement_unit")[0].value+" X "+$("#cost_item_currency")[0].value+" "+Number($("#cost_item_unit_price")[0].value).toFixed(2)+" ( "+$("#cost_item_quote_type")[0].value+" ) ";
            cell2.innerHTML = $("#cost_item_currency")[0].value+" "+(Number($("#cost_item_quantity")[0].value)*Number($("#cost_item_unit_price")[0].value)).toFixed(2);
            // cell1.innerHTML = `<input placeholder="Unit price and quantity" class="form-control" id="quote_price" />`;
            // cell2.innerHTML = `<input placeholder="Quote" class="form-control" id="quote_quote" />`;
            // cell3.innerHTML = `<button onClick="save_new_quote()" type="button" id="btn-save-new-quote" class="btn btn-default" ><i data-feather="check" ></i></button>`;
            $("#btn-add-new-quote").prop("disabled", false);
            $("#insert-cost-item-panel").prop("hidden",false);
        });
        var checklist_items=[];
        $("#add-checklist-item").on("click",function(){
            var checklist_item_title=$("#checklist-add-item")[0].value;
            checklist_items.push(checklist_item_title);
            console.log(checklist_item_title)
            $('#checklist-items').append(`
                <div id='checklist-item-row-33' class='list-group-item mb5 checklist-item-row b-a rounded text-break' data-id='33'><a href="#" title="" data-id="33" data-value="1" data-act="update-checklist-item-status-checkbox"><span class='checkbox-blank mr15 float-start'></span></a><a href="#" class="delete-checklist-item" title="Delete checklist item" data-fade-out-on-success="#checklist-item-row-33" data-act="ajax-request" data-action-url="<?php echo get_uri("/task_libraries"."/delete_checklist_item"."/33");?>"><div class='float-end'><i data-feather='x' class='icon-16'></i></div></a><span class='font-13 '>${checklist_item_title}</span></div>
            `);
            $("#checklist-add-item")[0].value="";
            checklists++;
            $(".chcklists_count").text(checklists);
        })
        var uploadUrl = "<?php echo get_uri('tasks/upload_file'); ?>";
        var validationUri = "<?php echo get_uri('tasks/validate_task_file'); ?>";
        var dropzone = attachDropzoneWithForm("#tasks-dropzone", uploadUrl, validationUri);
        $("#btn-save-task-library").on("click",function(){
            var rise_csrf_token = $('[name="rise_csrf_token"]').val();
            var id=$('[name="id"]').val();
            var title=$("#title")[0].value;
            var category=$("#category")[0].value;
            var dock_list_number=$("#dock_list_number")[0].value;
            var supplier=$("#supplier")[0].value;
            var status_id=$("#status_id")[0].value;
            var priority_id=$("#priority_id")[0].value;
            var milestone_id=$("#milestone_id")[0].value;
            var assigned_to=$("#assigned_to")[0].value;
            var collaborators=$("#collaborators")[0].value;
            var description=$("#description")[0].value;
            var location=$("#location")[0].value;
            var specification=$("#specification")[0].value;
            var gas_free_certificate_yes=$("#gas_free_certificate_yes")[0].value;
            var painting_after_completion_yes=$("#painting_after_completion_yes")[0].value;
            var light_yes=$("#light_yes")[0].value;
            var parts_on_board_yes=$("#parts_on_board_yes")[0].value;
            var ventilation_yes=$("#ventilation_yes")[0].value;
            var transport_to_yard_workshop_yes=$("#transport_to_yard_workshop_yes")[0].value;
            var crane_assistance_yes=$("#crane_assistance_yes")[0].value;
            var transport_outside_yard_yes=$("#transport_outside_yard_yes")[0].value;
            var cleaning_before_yes=$("#cleaning_before_yes")[0].value;
            var material_yards_supply_yes=$("#material_yards_supply_yes")[0].value;
            var cleaning_after_yes=$("#cleaning_after_yes")[0].value;
            var material_owners_supply_yes=$("#material_owners_supply_yes")[0].value;
            var work_permit_yes=$("#work_permit_yes")[0].value;
            var risk_assessment_yes=$("#risk_assessment_yes")[0].value;
            var maker=$("#maker")[0].value;
            var type=$("#type")[0].value;
            var serial_number=$("#serial_number")[0].value;
            var pms_scs_number=$("#pms_scs_number")[0].value;
            console.log(checklist_items)
            if(!title) return;
            $.ajax({
                url: '<?php echo get_uri("task_libraries/save_ajax") ?>',
                type: "POST",
                data: {
                    rise_csrf_token
                    ,id
                    ,title
                    ,category
                    ,dock_list_number
                    ,supplier
                    ,status_id
                    ,priority_id
                    ,milestone_id
                    ,assigned_to
                    ,collaborators
                    ,description
                    ,location
                    ,specification
                    ,gas_free_certificate:gas_free_certificate_yes
                    ,painting_after_completion:painting_after_completion_yes
                    ,light:light_yes
                    ,parts_on_board:parts_on_board_yes
                    ,ventilation:ventilation_yes
                    ,transport_to_yard_workshop:transport_to_yard_workshop_yes
                    ,crane_assistance:crane_assistance_yes
                    ,transport_outside_yard:transport_outside_yard_yes
                    ,cleaning_before:cleaning_before_yes
                    ,material_yards_supply:material_yards_supply_yes
                    ,cleaning_after:cleaning_after_yes
                    ,material_owners_supply:material_owners_supply_yes
                    ,work_permit:work_permit_yes
                    ,risk_assessment:risk_assessment_yes
                    ,maker
                    ,type
                    ,serial_number
                    ,pms_scs_number
                    ,checklist_items
                },
                success: function (response) {
                    // appLoader.hide();
                    window.location='<?php echo get_uri('task_libraries/view/'); ?>'+JSON.parse(response).saved_id;
                }
            });
        })
        
    });
    function save_new_quote(){
        var table=$("#table-quotes-from-yard")[0].getElementsByTagName('tbody')[0];
        var newRow = table.insertRow();

        var cell0 = newRow.insertCell(0);
        var cell1 = newRow.insertCell(1);
        var cell2 = newRow.insertCell(2);
        var cell3 = newRow.insertCell(3);

        cell0.innerHTML = $("#quote_name")[0].value;
        cell1.innerHTML = $("#quote_price")[0].value;
        cell2.innerHTML = $("#quote_quote")[0].value;
        cell3.innerHTML = "";
        $("#btn-save-new-quote")[0].closest("tr").remove();
        $("#btn-add-new-quote").prop("disabled", false);
    }
    <?php
        if(isset($gotChecklistItems))
        echo 'console.log(`'.json_encode($gotChecklistItems).'`)';
    ?>
    
</script>