<div id="page-content" class="page-wrapper clearfix">

    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "general";
            echo view("task_libraries/tabs", $tab_view);
            ?>
        </div>

        <div class="col-sm-9 col-lg-10">
            <div class="card"  >
                <div class="card-body">
                    <div class="display-flex" style="align-items:center" >
                        <div style="flex-grow:1" ></div>
                        <label for="title" style="margin:10px" >Search:</label>
                        <input class="form-control" type="text" style="width:20%"  name="search" />
                        <a class="btn btn-default" href="<?php echo get_uri("task_libraries");?>" style="margin:5px" ><i data-feather="plus-circle" class="icon-16" ></i> Add Task Template</a>
                        <div style="margin:5px" >
                        <?php echo modal_anchor(get_uri("task_libraries/import_modal"), "<i data-feather='upload' class='icon-16'></i> " . "Import Task Templates", array("class" => "btn btn-default import_tasks_btn", "title" => "Import Task Libraries")); ?>
                        </div>
                        <?php //if(isset($gotTasklibrary)) echo modal_anchor(get_uri("task_libraries/export_modal/").$gotTasklibrary->id, "<i data-feather='external-link' class='icon-16'></i> " . "Export", array("class" => "btn btn-default export-excel-btn", "title" => "Export Task Libraries")); ?>
                    </div>
                </div>
            </div>
            <div class="card" >
                <div id="tasks-dropzone" class="post-dropzone">
                <?php echo form_open(get_uri("task_libraries/save"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
                <?php if(isset($gotTasklibrary))
                    echo '<input hidden name="id" value="'.$gotTasklibrary->id.'" />';
                ?>
                <div class="card-header d-flex justify-content-between">
                    <h4><?php echo isset($gotTasklibrary)?"Edit Task Template" :"Add Task Template"; ?></h4>
                    
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="row">
                                    <label for="title" class="col-md-4"><?php echo app_lang('title'); ?>:</label>
                                    <div class="col-md-8" >
                                        <input
                                        id="title"
                                        name="title"
                                        value="<?php echo isset($gotTasklibrary) ?$gotTasklibrary->title:""; ?>"
                                        class="form-control",
                                        style="border:1px solid lightgray;"
                                        placeholder="<?php echo app_lang('title')?>"
                                        required
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="category" class="col-md-4"><?php echo app_lang('category'); ?>:</label>
                                    <div class="col-md-8"  >
                                    <?php
                                    $category_dropdown = array(
                                        array("id"=>"General & Docking","text"=>"General & Docking"),
                                        array("id"=>"Hull","text"=>"Hull"),
                                        array("id"=>"Equipment for Cargo","text"=>"Equipment for Cargo"),
                                        array("id"=>"Ship Equipment","text"=>"Ship Equipment"),
                                        array("id"=>"Safety & Crew Equipment","text"=>"Safety & Crew Equipment"),
                                        array("id"=>"Machinery Main Components","text"=>"Machinery Main Components"),
                                        array("id"=>"System Machinery Main Components","text"=>"System Machinery Main Components"),
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
                                        "style"=>"border:1px solid lightgray;",
                                        "data-msg-required" => app_lang("field_required"),
                                        "autocomplete" => "off"
                                    ));
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div class="row">
                                    <label for="dock_list_number" class="col-md-4"  ><a data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" data-bs-content="Dock List Number" >DLN:</a></label>
                                    <div class="col-md-8" >
                                        <?php
                                        $dock_list_number_now="";
                                        if(isset($gotTasklibrary)){
                                            $count=1;
                                            if(!$gotTasklibrary->category){
                                                $gotTasklibrary->category="Others";
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
                                            "style"=>"border:1px solid lightgray",
                                            "placeholder" => "Dock list number",
                                            "autocomplete" => "off"
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div class="row">
                                    <label for="budget_group" class="col-md-4"  >Budget group : </label>
                                    <div class="col-md-8" >
                                        <?php
                                        $budget_group_dropdown=array();
                                        foreach($allBudgetGroups as $oneGroup){
                                            $budget_group_dropdown[]=array(
                                                "id"=>$oneGroup->id,
                                                "text"=>$oneGroup->title
                                            );
                                        }
                                        
                                        echo form_input(array(
                                            "id" => "budget_group",
                                            "name" => "budget_group",
                                            "value" => isset($gotTasklibrary)&&property_exists($gotTasklibrary,"budget_group")?$gotTasklibrary->budget_group:"",
                                            // "value" => $dock_list_number_now,
                                            "class" => "form-control",
                                            "maxlength" => 15,
                                            "style"=>"border:1px solid lightgray",
                                            "placeholder" => "Budget group",
                                            "autocomplete" => "off"
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="row">
                                    <label for="supplier" class="col-md-3"><?php echo app_lang('supplier'); ?>:</label>
                                    <div class="col-md-9"  >
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
                                            array(
                                                "id"=>"Vessel(Crew)",
                                                "text"=>"Vessel(Crew)"
                                            ),
                                        );
                                        echo form_input(array(
                                            "id" => "supplier",
                                            "name" => "supplier",
                                            "value" =>isset($gotTasklibrary)&& $gotTasklibrary->supplier?$gotTasklibrary->supplier:$suppliers_dropdown[0]['id'],
                                            "class" => "form-control",
                                            "style"=>"border:1px solid lightgray",
                                            "placeholder" => app_lang('supplier'),
                                            "autocomplete" => "off"
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="status_id" class="col-md-3"><?php echo app_lang('status'); ?>:</label>
                                    <div class="col-md-9" >
                                        <?php
                                        $status_dropdown=array();
                                        foreach($allStatus as $oneStatus){
                                            $status_dropdown[]=array("id"=>$oneStatus['id'],'text'=>$oneStatus['title']);
                                        }
                                        echo form_input(array(
                                            "id" => "status_id",
                                            "name" => "status_id",
                                            "value" => isset($gotTasklibrary)&&$gotTasklibrary->status_id?$gotTasklibrary->status_id:$status_dropdown[0]['id'],
                                            "class" => "form-control",
                                            "style"=>"border:1px solid lightgray",
                                            "autocomplete" => "off"
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="priority_id" class="col-md-3"><?php echo app_lang('priority'); ?>:</label>
                                    <div class="col-md-9"  >
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
                                            "style"=>"border:1px solid lightgray",
                                            "placeholder" => app_lang('priority'),
                                            "autocomplete" => "off"
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="class_relevant" class="col-md-3"><?php echo "Class relevant"; ?>:</label>
                                    <div class="col-md-9"  >
                                        <?php
                                        $class_relevant_dropdown=array(
                                            array("id"=>1,"text"=>"Yes"),
                                            array("id"=>0,"text"=>"No"),
                                        );
                                        
                                        echo form_input(array(
                                            "id" => "class_relevant",
                                            "name" => "class_relevant",
                                            "value" => isset($gotTasklibrary)&&property_exists($gotTasklibrary,"class_relevant")?$gotTasklibrary->class_relevant:1,
                                            "class" => "form-control",
                                            "maxlength" => 15,
                                            "style"=>"border:1px solid lightgray",
                                            "placeholder" => "Class relevant",
                                            "autocomplete" => "off"
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            
                            <!-- <div class="form-group">
                                <div class="row">
                                    <label for="milestone_id" class="col-md-3"><?php //echo app_lang('milestone'); ?>:</label>
                                    <div class="col-md-9"  >
                                        <?php
                                        // $milestone_dropdown=array();
                                        // foreach ($allMilestones as $oneMilestone) {
                                        //     $milestone_dropdown[]=array("id"=>$oneMilestone['id'],"text"=>$oneMilestone['title']);
                                        // }
                                        // echo form_input(array(
                                        //     "id" => "milestone_id",
                                        //     "name" => "milestone_id",
                                        //     "value" => isset($gotTasklibrary)&&$gotTasklibrary->milestone_id?$gotTasklibrary->milestone_id:(count($milestone_dropdown)>0?$milestone_dropdown[0]['id']:""),
                                        //     "class" => "form-control",
                                        //     "style"=>"border:1px solid lightgray",
                                        //     "placeholder" => app_lang('milestone'),
                                        //     "autocomplete" => "off"
                                        // ));
                                        ?>
                                    </div>
                                </div>
                            </div> -->
                            
                            <div class="form-group">
                                <div class="row">
                                    <label for="assigned_to" class="col-md-3"><?php echo app_lang('assign_to'); ?>:</label>
                                    <div class="col-md-9" >
                                        <?php
                                        $assigned_to_dropdown=array(
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
                                            "id" => "assigned_to",
                                            "name" => "assigned_to",
                                            "value" => isset($gotTasklibrary)&&$gotTasklibrary->assigned_to?$gotTasklibrary->assigned_to:"-",
                                            "class" => "form-control",
                                            // "required"=>true,
                                            "style"=>"border:1px solid lightgray",
                                            "placeholder" => app_lang('assign_to'),
                                            "autocomplete" => "off"
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="collaborators" class="col-md-3"><?php echo app_lang('collaborators'); ?>:</label>
                                    <div class="col-md-9"  >
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
                                        "style"=>"border:1px solid lightgray",
                                        "placeholder" => app_lang('collaborators'),
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                        "autocomplete" => "off"
                                    ));
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="collaborators" class="col-md-3">PMS/SCS number:</label>
                                    <div class="col-md-9"  >
                                    <?php

                                    echo form_input(array(
                                        "id" => "pms_scs_number",
                                        "name" => "pms_scs_number",
                                        "value" => isset($gotTasklibrary)&&$gotTasklibrary->pms_scs_number?$gotTasklibrary->pms_scs_number:"",
                                        "class" => "form-control",
                                        "required"=>true,
                                        "style"=>"border:1px solid lightgray",
                                        "placeholder" => "PMS SCS number",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                        "autocomplete" => "off"
                                    ));
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="estimated_cost" class="col-md-3">Estimated cost:</label>
                                    <div class="col-md-9"  >
                                    <?php

                                    echo form_input(array(
                                        "id" => "estimated_cost",
                                        "name" => "estimated_cost",
                                        "value" => isset($gotTasklibrary)&&$gotTasklibrary->estimated_cost?$gotTasklibrary->estimated_cost:"",
                                        "class" => "form-control",
                                        "type"=>"number",
                                        "required"=>true,
                                        "style"=>"border:1px solid lightgray",
                                        "placeholder" => "Estimated cost",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                        "autocomplete" => "off"
                                    ));
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label for="description" class=" col-md-1"><?php echo app_lang('description'); ?>:</label>
                            <div class="col-md-11">
                                <div class="row" >
                                    <div style="width:3%" ></div>
                                    <div style="width:97%;" >
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
                                        "style"=>"border:1px solid lightgray;border-radius:5px",
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
                                    <div style="width:97%" style="border:1px solid lightgray;border-radius:5px" >
                                    <?php
                                    echo form_textarea(array(
                                        "id" => "specification",
                                        "name" => "specification",
                                        "value" => isset($gotTasklibrary)&&$gotTasklibrary->specification?$gotTasklibrary->specification:"",
                                        "class" => "form-control",
                                        "style"=>"border:1px solid lightgray;border-radius:5px",
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
                                                ), "1", isset($gotTasklibrary)?$gotTasklibrary->gas_free_certificate:1);
                                                ?>
                                                <label for="gas_free_certificate_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "gas_free_certificate_no",
                                                    "name" => "gas_free_certificate",
                                                    "class" => "form-check-input",
                                                ), "0", isset($gotTasklibrary)?!$gotTasklibrary->gas_free_certificate:0);
                                                ?>
                                                <label for="gas_free_certificate_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="light" class="col-7"><?php echo app_lang('light'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "light_yes",
                                                    "name" => "light",
                                                    "class" => "form-check-input",
                                                ), "1", isset($gotTasklibrary)?$gotTasklibrary->light:1);
                                                ?>
                                                <label for="light_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "light_no",
                                                    "name" => "light",
                                                    "class" => "form-check-input",
                                                ), "0", isset($gotTasklibrary)?!$gotTasklibrary->light:0);
                                                ?>
                                                <label for="light_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="ventilation" class="col-7"><?php echo app_lang('ventilation'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "ventilation_yes",
                                                    "name" => "ventilation",
                                                    "class" => "form-check-input",
                                                ), "1", isset($gotTasklibrary)?$gotTasklibrary->ventilation:1);
                                                ?>
                                                <label for="ventilation_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "ventilation_no",
                                                    "name" => "ventilation",
                                                    "class" => "form-check-input",
                                                ), "0", isset($gotTasklibrary)?!$gotTasklibrary->ventilation:0);
                                                ?>
                                                <label for="ventilation_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="crane_assistance" class="col-7"><?php echo app_lang('crane_assistance'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "crane_assistance_yes",
                                                    "name" => "crane_assistance",
                                                    "class" => "form-check-input",
                                                ), "1", isset($gotTasklibrary)?$gotTasklibrary->crane_assistance:1);
                                                ?>
                                                <label for="crane_assistance_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "crane_assistance_no",
                                                    "name" => "crane_assistance",
                                                    "class" => "form-check-input",
                                                ), "0", isset($gotTasklibrary)?!$gotTasklibrary->crane_assistance:0);
                                                ?>
                                                <label for="crane_assistance_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="cleaning_before" class="col-7"><?php echo app_lang('cleaning_before'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "cleaning_before_yes",
                                                    "name" => "cleaning_before",
                                                    "class" => "form-check-input",
                                                ), "1", isset($gotTasklibrary)?$gotTasklibrary->cleaning_before:1);
                                                ?>
                                                <label for="cleaning_before_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "cleaning_before_no",
                                                    "name" => "cleaning_before",
                                                    "class" => "form-check-input",
                                                ), "0", isset($gotTasklibrary)?!$gotTasklibrary->cleaning_before:0);
                                                ?>
                                                <label for="cleaning_before_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="cleaning_after" class="col-7"><?php echo app_lang('cleaning_after'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "cleaning_after_yes",
                                                    "name" => "cleaning_after",
                                                    "class" => "form-check-input",
                                                ), "1", isset($gotTasklibrary)?$gotTasklibrary->cleaning_after:1);
                                                ?>
                                                <label for="cleaning_after_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "cleaning_after_no",
                                                    "name" => "cleaning_after",
                                                    "class" => "form-check-input",
                                                ), "0", isset($gotTasklibrary)?!$gotTasklibrary->cleaning_after:0);
                                                ?>
                                                <label for="cleaning_after_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="work_permit" class="col-7"><?php echo app_lang('work_permit'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "work_permit_yes",
                                                    "name" => "work_permit",
                                                    "class" => "form-check-input",
                                                ), "1", isset($gotTasklibrary)?$gotTasklibrary->work_permit:1);
                                                ?>
                                                <label for="work_permit_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "work_permit_no",
                                                    "name" => "work_permit",
                                                    "class" => "form-check-input",
                                                ), "0", isset($gotTasklibrary)?!$gotTasklibrary->work_permit:0);
                                                ?>
                                                <label for="work_permit_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
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
                                                ), "1", isset($gotTasklibrary)?$gotTasklibrary->painting_after_completion:1);
                                                ?>
                                                <label for="painting_after_completion_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "painting_after_completion_no",
                                                    "name" => "painting_after_completion",
                                                    "class" => "form-check-input",
                                                ), "0", isset($gotTasklibrary)?!$gotTasklibrary->painting_after_completion:0);
                                                ?>
                                                <label for="painting_after_completion_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="parts_on_board" class="col-7"><?php echo app_lang('parts_on_board'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "parts_on_board_yes",
                                                    "name" => "parts_on_board",
                                                    "class" => "form-check-input",
                                                ), "1", isset($gotTasklibrary)?$gotTasklibrary->parts_on_board:1);
                                                ?>
                                                <label for="parts_on_board_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "parts_on_board_no",
                                                    "name" => "parts_on_board",
                                                    "class" => "form-check-input",
                                                ), "0", isset($gotTasklibrary)?!$gotTasklibrary->parts_on_board:0);
                                                ?>
                                                <label for="parts_on_board_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="risk_assessment" class="col-7"><?php echo app_lang('risk_assessment'); ?></label>
                                            <div class="col-5">
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "risk_assessment_yes",
                                                    "name" => "risk_assessment",
                                                    "class" => "form-check-input",
                                                ), "1", isset($gotTasklibrary)?$gotTasklibrary->risk_assessment:1);
                                                ?>
                                                <label for="risk_assessment_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                                <?php
                                                echo form_radio(array(
                                                    "id" => "risk_assessment_no",
                                                    "name" => "risk_assessment",
                                                    "class" => "form-check-input",
                                                ), "0", isset($gotTasklibrary)?!$gotTasklibrary->risk_assessment:0);
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
                                            "style"=>"border:1px solid lightgray",
                                            "placeholder" => app_lang('maker'),
                                            "autocomplete" => "off"
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="type" class=" col-md-4"><?php echo app_lang('type'); ?></label>
                                    <div class=" col-md-8" >
                                        <?php
                                        echo form_input(array(
                                            "id" => "type",
                                            "name" => "type",
                                            "value" => "",
                                            "class" => "form-control",
                                            "maxlength" => 30,
                                            "style"=>"border:1px solid lightgray",
                                            "placeholder" => app_lang('type'),
                                            "autocomplete" => "off"
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
                                            "style"=>"border:1px solid lightgray",
                                            "placeholder" => app_lang('serial_number'),
                                            "autocomplete" => "off"
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <div class="row">
                                    <label for="pms_scs_number" class=" col-md-4"><?php echo app_lang('pms_scs_number'); ?></label>
                                    <div class=" col-md-8" >
                                        <?php
                                        // echo form_input(array(
                                        //     "id" => "pms_scs_number",
                                        //     "name" => "pms_scs_number",
                                        //     "value" => "",
                                        //     "class" => "form-control",
                                        //     "maxlength" => 30,
                                        //     "style"=>"border:1px solid lightgray",
                                        //     "placeholder" => app_lang('pms_scs_number'),
                                        //     "autocomplete" => "off"
                                        // ));
                                        ?>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-7" >
                            <div class="card" style="min-height:50vh;">
                                <div class="card-header d-flex">
                                    <b>Cost Item List</b>
                                </div>
                                <div class="card-body" style="padding:1px" >
                                    <table id="table-quotes-from-yard" class="table table-hover table-bordered" style="margin:0" >
                                        <thead>
                                        <tr>
                                            <td>Cost item name</td>
                                            <td>UNIT PRICE AND QUANTITY</td>
                                            <td>QUOTE</td>
                                            <td ><button type="button" id="btn-add-new-quote" class="btn btn-default btn-sm" ><i data-feather="plus" class="icon-16" ></i></button></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($gotTasklibrary)&&$gotTasklibrary->reference_drawing){
                                                $cost_items=json_decode($gotTasklibrary->reference_drawing);
                                                if($cost_items)
                                                foreach ($cost_items as $key=>$oneItem) {
                                                    # code...
                                                    echo "<tr><td>";
                                                    echo $oneItem->name;
                                                    echo "</td><td>";
                                                    echo number_format(floatval($oneItem->quantity),1,".","")." ( ".$oneItem->measurement." ) X ".$oneItem->currency." ".number_format(floatval($oneItem->unit_price),2,".","")." ( ".$oneItem->quote_type." )";
                                                    echo "</td><td>";
                                                    echo $oneItem->currency." ".number_format(floatval($oneItem->quantity)*floatval($oneItem->unit_price), 2, '.', '');
                                                    echo "</td><td>";
                                                    echo '<button onClick="start_edit_cost_item('.$key.')" type="button" class="btn btn-sm" ><i style="color:gray" data-feather="edit" class="icon-16" ></i></button><button onClick="delete_item('.$key.')" type="button" class="btn btn-sm" ><i color="gray" data-feather="x-circle" class="icon-16" ></i></button>';
                                                    echo "</td></tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div id="insert-cost-item-panel" style="margin:5px;" hidden>
                                        <div style="min-height:5vh" ></div>
                                        <input hidden id="editing_cost_item" value="" />
                                        <div class="row" >
                                            <div class="form-group" >
                                                <label>Cost item name:</label>
                                                <input
                                                    id="cost_item_name"
                                                    class="form-control"
                                                    type="text"
                                                    style="border:1px solid lightgray;border-radius:5px"
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
                                                    style="border:1px solid lightgray;border-radius:5px"
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
                                                        style="border:1px solid lightgray;border-radius:5px"
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
                                                        style="border:1px solid lightgray;border-radius:5px"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-3" >
                                                <div class="form-group" >
                                                    <label>Measurement unit:</label>
                                                    <input
                                                        id="cost_item_measurement"
                                                        class="form-control"
                                                        placeholder="pcs"
                                                        value="pcs"
                                                        style="border:1px solid lightgray;border-radius:5px"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-md-6" >
                                                <div class="form-group" >
                                                    <label>Unit price:</label>
                                                    <div class="input-group mb-3" style="border:1px solid lightgray;border-radius:5px">
                                                        <!-- <input readonly type="text" id="cost_item_currency_symbol" class="form-control" value="$"> -->
                                                        <input id="cost_item_unit_price" type="text" class="form-control" value="0.00">
                                                        <?php
                                                        $cost_item_currency_dropdown=array(
                                                        array("id"=>"USD","text"=>"USD"),
                                                        array("id"=>"AUD","text"=>"AUD"),
                                                        array("id"=>"GBP","text"=>"GBP"),
                                                        array("id"=>"EUR","text"=>"EUR"),
                                                        array("id"=>"JPY","text"=>"JPY"),
                                                        array("id"=>"CHF","text"=>"CHF"),
                                                        array("id"=>"USD","text"=>"USD"),
                                                        array("id"=>"AFN","text"=>"AFN"),
                                                        array("id"=>"ALL","text"=>"ALL"),
                                                        array("id"=>"DZD","text"=>"DZD"),
                                                        array("id"=>"AOA","text"=>"AOA"),
                                                        array("id"=>"ARS","text"=>"ARS"),
                                                        array("id"=>"AMD","text"=>"AMD"),
                                                        array("id"=>"AWG","text"=>"AWG"),
                                                        array("id"=>"AUD","text"=>"AUD"),
                                                        array("id"=>"ATS (EURO)","text"=>"ATS (EURO)"),
                                                        array("id"=>"BEF (EURO)","text"=>"BEF (EURO)"),
                                                        array("id"=>"AZN","text"=>"AZN"),
                                                        array("id"=>"BSD","text"=>"BSD"),
                                                        array("id"=>"BHD","text"=>"BHD"),
                                                        array("id"=>"BDT","text"=>"BDT"),
                                                        array("id"=>"BBD","text"=>"BBD"),
                                                        array("id"=>"BYR","text"=>"BYR"),
                                                        array("id"=>"BZD","text"=>"BZD"),
                                                        array("id"=>"BMD","text"=>"BMD"),
                                                        array("id"=>"BTN","text"=>"BTN"),
                                                        array("id"=>"BOB","text"=>"BOB"),
                                                        array("id"=>"BAM","text"=>"BAM"),
                                                        array("id"=>"BWP","text"=>"BWP"),
                                                        array("id"=>"BRL","text"=>"BRL"),
                                                        array("id"=>"GBP","text"=>"GBP"),
                                                        array("id"=>"BND","text"=>"BND"),
                                                        array("id"=>"BGN","text"=>"BGN"),
                                                        array("id"=>"BIF","text"=>"BIF"),
                                                        array("id"=>"XOF","text"=>"XOF"),
                                                        array("id"=>"XAF","text"=>"XAF"),
                                                        array("id"=>"XPF","text"=>"XPF"),
                                                        array("id"=>"KHR","text"=>"KHR"),
                                                        array("id"=>"CAD","text"=>"CAD"),
                                                        array("id"=>"CVE","text"=>"CVE"),
                                                        array("id"=>"KYD","text"=>"KYD"),
                                                        array("id"=>"CLP","text"=>"CLP"),
                                                        array("id"=>"CNY","text"=>"CNY"),
                                                        array("id"=>"COP","text"=>"COP"),
                                                        array("id"=>"KMF","text"=>"KMF"),
                                                        array("id"=>"CDF","text"=>"CDF"),
                                                        array("id"=>"CRC","text"=>"CRC"),
                                                        array("id"=>"HRK","text"=>"HRK"),
                                                        array("id"=>"CUC","text"=>"CUC"),
                                                        array("id"=>"CUP","text"=>"CUP"),
                                                        array("id"=>"CYP (EURO)","text"=>"CYP (EURO)"),
                                                        array("id"=>"CZK","text"=>"CZK"),
                                                        array("id"=>"DKK","text"=>"DKK"),
                                                        array("id"=>"DJF","text"=>"DJF"),
                                                        array("id"=>"DOP","text"=>"DOP"),
                                                        array("id"=>"XCD","text"=>"XCD"),
                                                        array("id"=>"EGP","text"=>"EGP"),
                                                        array("id"=>"SVC","text"=>"SVC"),
                                                        array("id"=>"EEK (EURO)","text"=>"EEK (EURO)"),
                                                        array("id"=>"ETB","text"=>"ETB"),
                                                        array("id"=>"EUR","text"=>"EUR"),
                                                        array("id"=>"FKP","text"=>"FKP"),
                                                        array("id"=>"FIM (EURO)","text"=>"FIM (EURO)"),
                                                        array("id"=>"FJD","text"=>"FJD"),
                                                        array("id"=>"GMD","text"=>"GMD"),
                                                        array("id"=>"GEL","text"=>"GEL"),
                                                        array("id"=>"DMK (EURO)","text"=>"DMK (EURO)"),
                                                        array("id"=>"GHS","text"=>"GHS"),
                                                        array("id"=>"GIP","text"=>"GIP"),
                                                        array("id"=>"GRD (EURO)","text"=>"GRD (EURO)"),
                                                        array("id"=>"GTQ","text"=>"GTQ"),
                                                        array("id"=>"GNF","text"=>"GNF"),
                                                        array("id"=>"GYD","text"=>"GYD"),
                                                        array("id"=>"HTG","text"=>"HTG"),
                                                        array("id"=>"HNL","text"=>"HNL"),
                                                        array("id"=>"HKD","text"=>"HKD"),
                                                        array("id"=>"HUF","text"=>"HUF"),
                                                        array("id"=>"ISK","text"=>"ISK"),
                                                        array("id"=>"INR","text"=>"INR"),
                                                        array("id"=>"IDR","text"=>"IDR"),
                                                        array("id"=>"IRR","text"=>"IRR"),
                                                        array("id"=>"IQD","text"=>"IQD"),
                                                        array("id"=>"IED (EURO)","text"=>"IED (EURO)"),
                                                        array("id"=>"ILS","text"=>"ILS"),
                                                        array("id"=>"ITL (EURO)","text"=>"ITL (EURO)"),
                                                        array("id"=>"JMD","text"=>"JMD"),
                                                        array("id"=>"JPY","text"=>"JPY"),
                                                        array("id"=>"JOD","text"=>"JOD"),
                                                        array("id"=>"KZT","text"=>"KZT"),
                                                        array("id"=>"KES","text"=>"KES"),
                                                        array("id"=>"KWD","text"=>"KWD"),
                                                        array("id"=>"KGS","text"=>"KGS"),
                                                        array("id"=>"LAK","text"=>"LAK"),
                                                        array("id"=>"LVL (EURO)","text"=>"LVL (EURO)"),
                                                        array("id"=>"LBP","text"=>"LBP"),
                                                        array("id"=>"LSL","text"=>"LSL"),
                                                        array("id"=>"LRD","text"=>"LRD"),
                                                        array("id"=>"LYD","text"=>"LYD"),
                                                        array("id"=>"LTL (EURO)","text"=>"LTL (EURO)"),
                                                        array("id"=>"LUF (EURO)","text"=>"LUF (EURO)"),
                                                        array("id"=>"MOP","text"=>"MOP"),
                                                        array("id"=>"MKD","text"=>"MKD"),
                                                        array("id"=>"MGA","text"=>"MGA"),
                                                        array("id"=>"MWK","text"=>"MWK"),
                                                        array("id"=>"MYR","text"=>"MYR"),
                                                        array("id"=>"MVR","text"=>"MVR"),
                                                        array("id"=>"MTL (EURO)","text"=>"MTL (EURO)"),
                                                        array("id"=>"MRO","text"=>"MRO"),
                                                        array("id"=>"MUR","text"=>"MUR"),
                                                        array("id"=>"MXN","text"=>"MXN"),
                                                        array("id"=>"MDL","text"=>"MDL"),
                                                        array("id"=>"MNT","text"=>"MNT"),
                                                        array("id"=>"MAD","text"=>"MAD"),
                                                        array("id"=>"MZN","text"=>"MZN"),
                                                        array("id"=>"MMK","text"=>"MMK"),
                                                        array("id"=>"ANG","text"=>"ANG"),
                                                        array("id"=>"NAD","text"=>"NAD"),
                                                        array("id"=>"NPR","text"=>"NPR"),
                                                        array("id"=>"NLG (EURO)","text"=>"NLG (EURO)"),
                                                        array("id"=>"NZD","text"=>"NZD"),
                                                        array("id"=>"NIO","text"=>"NIO"),
                                                        array("id"=>"NGN","text"=>"NGN"),
                                                        array("id"=>"KPW","text"=>"KPW"),
                                                        array("id"=>"NOK","text"=>"NOK"),
                                                        array("id"=>"OMR","text"=>"OMR"),
                                                        array("id"=>"PKR","text"=>"PKR"),
                                                        array("id"=>"PAB","text"=>"PAB"),
                                                        array("id"=>"PGK","text"=>"PGK"),
                                                        array("id"=>"PYG","text"=>"PYG"),
                                                        array("id"=>"PEN","text"=>"PEN"),
                                                        array("id"=>"PHP","text"=>"PHP"),
                                                        array("id"=>"PLN","text"=>"PLN"),
                                                        array("id"=>"PTE (EURO)","text"=>"PTE (EURO)"),
                                                        array("id"=>"QAR","text"=>"QAR"),
                                                        array("id"=>"RON","text"=>"RON"),
                                                        array("id"=>"RUB","text"=>"RUB"),
                                                        array("id"=>"RWF","text"=>"RWF"),
                                                        array("id"=>"WST","text"=>"WST"),
                                                        array("id"=>"STD","text"=>"STD"),
                                                        array("id"=>"SAR","text"=>"SAR"),
                                                        array("id"=>"RSD","text"=>"RSD"),
                                                        array("id"=>"SCR","text"=>"SCR"),
                                                        array("id"=>"SLL","text"=>"SLL"),
                                                        array("id"=>"SGD","text"=>"SGD"),
                                                        array("id"=>"SKK (EURO)","text"=>"SKK (EURO)"),
                                                        array("id"=>"SIT (EURO)","text"=>"SIT (EURO)"),
                                                        array("id"=>"SBD","text"=>"SBD"),
                                                        array("id"=>"SOS","text"=>"SOS"),
                                                        array("id"=>"ZAR","text"=>"ZAR"),
                                                        array("id"=>"KRW","text"=>"KRW"),
                                                        array("id"=>"ESP (EURO)","text"=>"ESP (EURO)"),
                                                        array("id"=>"LKR","text"=>"LKR"),
                                                        array("id"=>"SHP","text"=>"SHP"),
                                                        array("id"=>"SDG","text"=>"SDG"),
                                                        array("id"=>"SRD","text"=>"SRD"),
                                                        array("id"=>"SZL","text"=>"SZL"),
                                                        array("id"=>"SEK","text"=>"SEK"),
                                                        array("id"=>"CHF","text"=>"CHF"),
                                                        array("id"=>"SYP","text"=>"SYP"),
                                                        array("id"=>"TWD","text"=>"TWD"),
                                                        array("id"=>"TZS","text"=>"TZS"),
                                                        array("id"=>"THB","text"=>"THB"),
                                                        array("id"=>"TOP","text"=>"TOP"),
                                                        array("id"=>"TTD","text"=>"TTD"),
                                                        array("id"=>"TND","text"=>"TND"),
                                                        array("id"=>"TRY","text"=>"TRY"),
                                                        array("id"=>"TMM","text"=>"TMM"),
                                                        array("id"=>"USD","text"=>"USD"),
                                                        array("id"=>"UGX","text"=>"UGX"),
                                                        array("id"=>"UAH","text"=>"UAH"),
                                                        array("id"=>"UYU","text"=>"UYU"),
                                                        array("id"=>"AED","text"=>"AED"),
                                                        array("id"=>"VUV","text"=>"VUV"),
                                                        array("id"=>"VEB","text"=>"VEB"),
                                                        array("id"=>"VND","text"=>"VND"),
                                                        array("id"=>"YER","text"=>"YER"),
                                                        array("id"=>"ZMK","text"=>"ZMK"),
                                                        array("id"=>"ZWD","text"=>"ZWD"),);

                                                        echo form_input(array(
                                                                "id" => "cost_item_currency",
                                                                "name" => "cost_item_currency",
                                                                "value" => "USD",
                                                                "class" => "form-control",
                                                                "placeholder" => app_lang('category'),
                                                                "data-rule-required" => true,
                                                                "style"=>"border:1px solid lightgray;",
                                                                "data-msg-required" => app_lang("field_required"),
                                                                "autocomplete" => "off"
                                                            ));
                                                            ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2" >
                                                <div class="form-group" >
                                                    <label>Discount:</label>
                                                    <div class="input-group mb-3" style="border:1px solid lightgray;border-radius:5px">
                                                        <input id="cost_item_discount" type="text" class="form-control" value="0.0">
                                                        <input readonly type="text" class="form-control" value="%" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="form-group" >
                                                <label>Yard remarks:</label>
                                                <textarea style="border:1px solid lightgray;border-radius:5px" id="cost_item_yard_remarks" class="form-control" name="yard_remarks" ></textarea>
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
                        <div class="col-md-5"  >
                            <!--checklist-->
                            <div class="card" >
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
                                        foreach($gotChecklistItems as $item_index=>$oneItem){
                                            echo '<div id="checklist-item-row-33" class="list-group-item mb5 checklist-item-row b-a rounded text-break" data-id="33"><a href="#" title="" data-id="33" data-value="1" data-act="update-checklist-item-status-checkbox"><span class="'.($oneItem->checked==1?"checkbox-checked":"checkbox-blank").' mr15 float-start"></span></a><a href="#" class="delete-checklist-item" title="Delete checklist item" data-fade-out-on-success="#checklist-item-row-33" data-act="ajax-request" data-action-url="'. get_uri("/task_libraries"."/delete_checklist_item"."/".$oneItem->id).'"><div class="float-end"><i data-feather="x" class="icon-16"></i></div></a><span class="font-13">'.$oneItem->title.'</span></div>';
                                        }
                                    ?>
                                    </div>
                                        <div class="mb5 mt5 btn-group checklist-options-panel hide" role="group">
                                            <button id="type-new-item-button" type="button" class="btn btn-default checklist_button active"> <?php echo app_lang('type_new_item'); ?></button>
                                            <button id="select-from-template-button" type="button" class="btn btn-default checklist_button"> <?php echo app_lang('select_from_template'); ?></button>
                                            <!-- <button id="select-from-checklist-group-button" type="button" class="btn btn-default checklist_button"> <?php echo app_lang('select_from_checklist_group'); ?></button> -->
                                        </div>
                                        <div class="form-group">
                                            <div class="mt5 p0" style="border:1px solid lightgray;border:5px;">
                                                <?php
                                                echo form_input(array(
                                                    "id" => "checklist-add-item",
                                                    "name" => "checklist-add-item",
                                                    "class" => "form-control",
                                                    "placeholder" => app_lang('add_item'),
                                                    "style"=>"border:1px solid lightgray;border-radius:5px",
                                                    "data-rule-required" => true,
                                                    "data-msg-required" => app_lang("field_required"),
                                                    "autocomplete" => "off",
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
                            <!---->
                            <div class="card" >
                                <div class="card-body" >
                                    <!--Task dependency-->
                                    <div class="col-md-12 mb15">
                                        <span class="dropdown">
                                            <button class="btn btn-default dropdown-toggle btn-border" type="button" data-bs-toggle="dropdown" aria-expanded="true">
                                                <i data-feather="shuffle" class="icon-16"></i> <?php echo app_lang('add_dependency'); ?>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li id="toggle-blocking-panel"><?php echo js_anchor(app_lang("this_task_blocking"), array("class" => "add-dependency-btn dropdown-item", "data-dependency_type" => "blocking")); ?></li>
                                                <li id="toggle-blocked-by-panel" role="presentation"><?php echo js_anchor(app_lang("this_task_blocked_by"), array("class" => "add-dependency-btn dropdown-item", "data-dependency_type" => "blocked_by")); ?></li>
                                            </ul>
                                        </span>
                                    </div>
                                    <div class="col-md-12 mb15" id="dependency-area">
                                        <div class="pb10 pt10 hide" id="dependency-list-title">
                                            <strong><?php echo app_lang("dependency"); ?></strong>
                                        </div>
                                        <?php
                                        $gotDependencies=array();
                                        if(isset($gotTasklibrary)) $gotDependencies=json_decode($gotTasklibrary->dependencies,true);
                                        $blockingDependencies=array();
                                        $blockedDependencies=array();
                                        if(is_array($gotDependencies)) foreach($gotDependencies as $oneDependency){
                                            if($oneDependency['blocking']==1){
                                                $blockingDependencies[]= '
                                                <div id="dependency-task-row-'.$oneDependency['id'].'" class="list-group-item mb5 dependency-task-row b-a rounded" style="border-left: 5px solid #F9A52D !important;">
                                                <a href="#" class="delete-dependency-task" title="Delete" data-fade-out-on-success="#dependency-task-row-'.$oneDependency['id'].'" data-dependency-type="blocked_by" data-act="ajax-request" data-action-url="'.get_uri("task_libraries/delete_dependency").'">
                                                <div class="float-end"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-16"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div></a><a href="#" data-post-id="'.$oneDependency['id'].'" data-modal-lg="1" data-act="ajax-modal" data-title="" data-action-url="">'.$oneDependency['title'].'</a></div>
                                                ';
                                            }else $blockedDependencies[]='
                                            <div id="dependency-task-row-'.$oneDependency['id'].'" class="list-group-item mb5 dependency-task-row b-a rounded" style="border-left: 5px solid #F9A52D !important;">
                                            <a href="#" class="delete-dependency-task" title="Delete" data-fade-out-on-success="#dependency-task-row-'.$oneDependency['id'].'" data-dependency-type="blocked_by" data-act="ajax-request" data-action-url="'.get_uri("task_libraries/delete_dependency").'">
                                            <div class="float-end"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-16"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div></a><a href="#" data-post-id="'.$oneDependency['id'].'" data-modal-lg="1" data-act="ajax-modal" data-title="" data-action-url="">'.$oneDependency['title'].'</a></div>
                                            ';
                                            
                                        };
                                        ?>
                                        <div class="p10 list-group-item mb15 dependency-section <?php echo (count($blockingDependencies)>0)?"":"hide"; ?>" id="blocking-area">
                                            <div class="pb10"><strong><?php echo app_lang("blocking"); ?></strong></div>
                                            <div id="blocking-tasks"><?php if(isset($blocking)) echo $blocking; ?>
                                            <?php
                                            
                                            foreach ($blockingDependencies as $oneBlocking) {
                                                echo $oneBlocking;
                                            }
                                            ?>
                                            </div>
                                        </div>
                                        <div class="p10 list-group-item mb15 dependency-section <?php echo (count($blockedDependencies)>0)?"":"hide"; ?>" id="blocked-by-area">
                                            <div class="pb10"><strong><?php echo app_lang("blocked_by"); ?></strong></div>
                                            <div id="blocked-by-tasks"><?php if(isset($blocked_by)) echo $blocked_by; ?>
                                            <?php
                                            foreach ($blockedDependencies as $oneBlocked) {
                                                echo $oneBlocked;
                                            }
                                            ?>
                                            </div>
                                        </div>

                                        
                                        <div id="edit-dependency-panel" hidden  >
                                        <?php //echo form_open(get_uri("tasks/save_dependency_tasks"), array("id" => "dependency_tasks_form", "class" => "general-form hide", "role" => "form")); ?>
                                        <input hidden name="task_id" value="<?php //echo $task_id; ?>" />

                                        <div class="form-group mb0">
                                            <div class="mt5 col-md-12 p0" style="border:1px solid lightgray;border-radius:5px">

                                                <?php
                                                $dependency_dropdown=array();
                                                foreach ($allTasklibraries as $oneLibrary) {
                                                    $dependency_dropdown[]=array(
                                                        "id"=>$oneLibrary['id'],
                                                        "text"=>$oneLibrary['title']
                                                    );
                                                }
                                                echo form_input(array(
                                                    "id" => "dependency_task",
                                                    "name" => "dependency_task",
                                                    "class" => "form-control validate-hidden",
                                                    "placeholder" => app_lang('tasks'),
                                                    "data-rule-required" => true,
                                                    "data-msg-required" => app_lang("field_required"),
                                                    "autocomplete" => "off"
                                                ));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="p0 mt10">
                                            <button id="btn-insert-edit-dependency" type="button" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></button>
                                            <button id="btn-cancel-edit-dependency" type="button" class="dependency-tasks-close btn btn-default"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('cancel'); ?></button>
                                        </div>
                                        <?php //echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!---->
                        </div>
                        <div class="col-md-4" >
                            
                        </div>
                    </div>
                    <div><?php echo view("includes/dropzone_preview"); ?></div>
                    <div stlyle="margin-top:10px" class="d-flex align-items-center" >
                        <div  >
                            <button class="btn btn-default upload-file-button float-start me-auto btn-sm round" type="button" style="color:#7988a2"><i data-feather="camera" class="icon-16"></i> <?php echo app_lang("upload_file"); ?></button>
                        </div>
                        <div class="flex-grow-1" ></div>
                        <div  >
                            <?php
                            if(isset($gotTasklibrary)){
                                echo js_anchor("<i data-feather='x' class='icon-16'></i>Delete", array('title' => app_lang('delete_project'), "class" => "btn btn-danger delete-library", "data-id" => $gotTasklibrary->id, "data-action-url" => get_uri("task_libraries/delete/").$gotTasklibrary->id, "data-action" => "delete-confirmation"));
                            }
                            ?>
                            
                            <button type="button"
                            old-id="btn-task-save"
                            id="btn-save-task-library"
                            class="btn btn-primary" ><i data-feather="check-circle" class="icon-16"></i> Save</button>
                        </div>
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
        // $("#confirmDeleteButton").on("mouseup",function(){
        //     window.location.href='<?php //echo get_uri("task_libraries")?>';
        // })
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
        })
        $("#cost_item_currency_symbol").on('mousedown', false);
        $("#cost_item_currency_symbol").on('keydown', false);
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
        $("#cost_item_currency").select2({
            data: <?php echo (json_encode($cost_item_currency_dropdown)); ?>
        });
        $("#class_relevant").select2({
            data: <?php echo (json_encode($class_relevant_dropdown)); ?>
        });
        $("#budget_group").select2({
            data: <?php echo (json_encode($budget_group_dropdown)); ?>
        });
        // $("#milestone_id").select2({
        //     data: <?php //echo (json_encode($milestone_dropdown)); ?>
        // });
        $("#assigned_to").select2({
            data: <?php echo (json_encode($assigned_to_dropdown)); ?>
        });
        $("#supplier").select2({
            data: <?php echo (json_encode($suppliers_dropdown)); ?>
        });
        $("#dependency-task").select2({
            data: <?php echo (json_encode($dependency_dropdown)); ?>
        });
        setDatePicker("#start_date");
        setDatePicker("#deadline");
        $('#description').summernote({
            height:250
        });
        $('.note-editor').css({
            'border-radius':'5px'
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
        }

        var checklists = $(".checklist-items .checklist-item-row").length;
        $(".delete-checklist-item").click(function () {
            checklists--;
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
                status_checkbox.addClass("checkbox-blank");
                checklist_items[$(this).parent().index()].checked=0;
                checklist_complete--;
            }else {
                status_checkbox.addClass("checkbox-checked");
                status_checkbox.removeClass("checkbox-blank");
                checklist_complete++;
                checklist_items[$(this).parent().index()].checked=1;
            }
            $(".chcklists_status_count").text(checklist_complete);
            console.log(checklist_items)
           
        });
        $("#btn-add-new-quote").on("click",function(){
            if($("#insert-cost-item-panel").prop("hidden")){
                $("#insert-cost-item-panel").prop("hidden",false);
            }else {
                $("#insert-cost-item-panel").prop("hidden",true);
            }
            

        })
        $("#insert-add-cost-item").on("click",function(){
            var table=$("#table-quotes-from-yard")[0].getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();

            var cell0 = newRow.insertCell(0);
            var cell1 = newRow.insertCell(1);
            var cell2 = newRow.insertCell(2);
            var cell3 = newRow.insertCell(3);

            cell0.innerHTML = $("#cost_item_name")[0].value;
            cell1.innerHTML = Number($("#cost_item_quantity")[0].value).toFixed(1)+' '+$("#cost_item_measurement")[0].value+" X "+$("#cost_item_currency")[0].value+" "+Number($("#cost_item_unit_price")[0].value).toFixed(2)+" ( "+$("#cost_item_quote_type")[0].value+" ) ";
            cell2.innerHTML = $("#cost_item_currency")[0].value+" "+(Number($("#cost_item_quantity")[0].value)*Number($("#cost_item_unit_price")[0].value)).toFixed(2);
            cell3.innerHTML=`
            <button onClick="start_edit_cost_item(${cost_items.length})" type="button" class="btn btn-sm" ><i style="color:gray" data-feather="edit" class="icon-16" ></i></button>
            <button type="button" onClick="delete_item(${cost_items.length})" class="btn btn-sm" ><i style="color:gray" data-feather="x-circle" class="icon-16" ></i></button>
            `;
            $("#btn-add-new-quote").prop("disabled", false);
            $("#insert-cost-item-panel").prop("hidden",false);
            if($("#editing_cost_item")[0].value=="")
                cost_items.push({
                    name:$("#cost_item_name")[0].value,
                    quantity:$("#cost_item_quantity")[0].value,
                    measurement:$("#cost_item_measurement")[0].value,
                    unit_price:$("#cost_item_unit_price")[0].value,
                    quote_type:$("#cost_item_quote_type")[0].value,
                    currency:$("#cost_item_currency")[0].value,
                    description:$("#cost_item_description")[0].value,
                    yard_remarks:$("#cost_item_yard_remarks")[0].value,
                    discount:$("#cost_item_discount")[0].value,
                });
            else{
                $("#table-quotes-from-yard")[0].getElementsByTagName('tbody')[0].deleteRow(Number($("#editing_cost_item")[0].value));
                cost_items[Number($("#editing_cost_item")[0].value)]={
                    name:$("#cost_item_name")[0].value,
                    quantity:$("#cost_item_quantity")[0].value,
                    measurement:$("#cost_item_measurement")[0].value,
                    unit_price:$("#cost_item_unit_price")[0].value,
                    quote_type:$("#cost_item_quote_type")[0].value,
                    currency:$("#cost_item_currency")[0].value,
                    description:$("#cost_item_description")[0].value,
                    yard_remarks:$("#cost_item_yard_remarks")[0].value,
                    discount:$("#cost_item_discount")[0].value,
                };
                $("#editing_cost_item")[0].value=""
            }
            $("#cost_item_name")[0].value="";
            $("#cost_item_quantity")[0].value="";
            $("#cost_item_unit_price")[0].value="";
            $("#cost_item_description")[0].value="";
            $("#cost_item_yard_remarks")[0].value="";
        });
        $("#cancel-add-cost-item").on("click",function(){
            $("#insert-cost-item-panel").prop("hidden",true);
            $("#btn-add-new-quote").prop("disabled", false);
        })
        
        $("#add-checklist-item").on("click",function(){
            var checklist_item_title=$("#checklist-add-item")[0].value;
            checklist_items.push({title:checklist_item_title,checked:0});
            var newTempId=checklist_items.length;
            $('#checklist-items').append(`
                <div id='checklist-item-row-${newTempId}' class='list-group-item mb5 checklist-item-row b-a rounded text-break' data-id='${newTempId}'><a href="#" title="" data-id="${newTempId}" data-value="${newTempId}" data-act="update-checklist-item-status-checkbox"><span class='checkbox-blank mr15 float-start'></span></a><a href="#" class="delete-checklist-item" title="Delete checklist item" data-fade-out-on-success="#checklist-item-row-${newTempId}" data-act="ajax-request" data-action-url="<?php echo get_uri("/task_libraries"."/delete_checklist_item"."/");?>${newTempId}"><div class='float-end'><i data-feather='x' class='icon-16'></i></div></a><span class='font-13 '>${checklist_item_title}</span></div>
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
            // var milestone_id=$("#milestone_id")[0].value;
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
            // var transport_to_yard_workshop_yes=$("#transport_to_yard_workshop_yes")[0].value;
            var crane_assistance_yes=$("#crane_assistance_yes")[0].value;
            // var transport_outside_yard_yes=$("#transport_outside_yard_yes")[0].value;
            var cleaning_before_yes=$("#cleaning_before_yes")[0].value;
            // var material_yards_supply_yes=$("#material_yards_supply_yes")[0].value;
            var cleaning_after_yes=$("#cleaning_after_yes")[0].value;
            // var material_owners_supply_yes=$("#material_owners_supply_yes")[0].value;
            var work_permit_yes=$("#work_permit_yes")[0].value;
            var risk_assessment_yes=$("#risk_assessment_yes")[0].value;
            var maker=$("#maker")[0].value;
            var type=$("#type")[0].value;
            var serial_number=$("#serial_number")[0].value;
            var pms_scs_number=$("#pms_scs_number")[0].value;
            var class_relevant=$("#class_relevant")[0].value;
            var estimated_cost=$("#estimated_cost")[0].value;
            var budget_group=$("#budget_group")[0].value;
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
                    // ,milestone_id
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
                    // ,transport_to_yard_workshop:transport_to_yard_workshop_yes
                    ,crane_assistance:crane_assistance_yes
                    // ,transport_outside_yard:transport_outside_yard_yes
                    ,cleaning_before:cleaning_before_yes
                    // ,material_yards_supply:material_yards_supply_yes
                    ,cleaning_after:cleaning_after_yes
                    // ,material_owners_supply:material_owners_supply_yes
                    ,work_permit:work_permit_yes
                    ,risk_assessment:risk_assessment_yes
                    ,maker
                    ,type
                    ,serial_number
                    ,pms_scs_number
                    ,checklist_items,
                    dependencies:JSON.stringify(dependencies),
                    cost_items:JSON.stringify(cost_items),
                    class_relevant,
                    estimated_cost,
                    budget_group
                },
                success: function (response) {
                    // appLoader.hide();
                    window.location='<?php echo get_uri('task_libraries/view/'); ?>'+JSON.parse(response).saved_id;
                }
            });
        });
        $('#toggle-blocking-panel').on('click',function(){
            if($("#blocking-area").hasClass('hide')) $("#blocking-area").removeClass("hide");
            if(!$("#blocked-by-area").hasClass('hide')) {
                if($("#blocked-by-area").text=="")
                    $("#blocked-by-area").addClass("hide")
                else {

                }
            }
            dependency_status=1;
            if($("#dependency-list-title").hasClass('hide')) $("#dependency-list-title").removeClass("hide")
            if($("#edit-dependency-panel").prop('hidden')) $("#edit-dependency-panel").prop("hidden",false)
            // if($("#dependency-area").hasClass('hide')) $("#dependency-area").removeClass("hide")
            $("#dependency_task").select2({
            data: <?php echo (json_encode($dependency_dropdown)); ?>
        });
        });
        $('#toggle-blocked-by-panel').on('click',function(){
            if(!$("#blocking-area").hasClass('hide')) {
                if($("#blocking-area").text=="")
                    $("#blocking-area").addClass("hide");
                else{
                    
                }
            }
            dependency_status=2;
            if($("#blocked-by-area").hasClass('hide')) $("#blocked-by-area").removeClass("hide")
            if($("#dependency-list-title").hasClass('hide')) $("#dependency-list-title").removeClass("hide")
            if($("#edit-dependency-panel").prop('hidden')) $("#edit-dependency-panel").prop("hidden",false)
            // if($("#dependency-area").hasClass('hide')) $("#dependency-area").removeClass("hide")
            $("#dependency_task").select2({
                data: <?php echo (json_encode($dependency_dropdown)); ?>
            });
        });
        $("#btn-cancel-edit-dependency").on('click',function(){
            dependency_status=0;
            if(dependencies.length>0){
                if(!$("#blocking-area").text()) console.log("empty")
                if(!$("#blocked-by-area").text()) console.log("empty")
            }else {
                if(!$("#dependency-list-title").hasClass('hide')) $("#dependency-list-title").addClass("hide")
                if(!$("#blocking-area").hasClass('hide')) $("#blocking-area").addClass("hide");
                if(!$("#blocked-by-area").hasClass('hide')) $("#blocked-by-area").addClass("hide")
            }
            if(!$("#edit-dependency-panel").prop('hidden')) $("#edit-dependency-panel").prop("hidden",true)
        })
        $("#btn-insert-edit-dependency").on('click',function(){
            var selectedId=$('#dependency_task').val()
            var selectedText=""
            // console.log(selectedId,selectedText)
            for(var oneDependency of dependencies){
                if(String(oneDependency.id)==String(selectedId)) {
                    return;
                }
            }
            
            if(dependency_status==1){
                selectedText=$('#edit-dependency-panel .select2-chosen').text();
                dependencies.push({id:selectedId,title:selectedText,blocking:dependency_status});
                $("#blocking-tasks").append(`
                <div id="dependency-task-row-${selectedId}" class="list-group-item mb5 dependency-task-row b-a rounded" style="border-left: 5px solid #F9A52D !important;">
                <a href="#" class="delete-dependency-task" title="Delete" data-fade-out-on-success="#dependency-task-row-${selectedId}" data-dependency-type="blocked_by" data-act="ajax-request" data-action-url="<?php echo get_uri("task_libraries/delete_dependency");?>">
                <div class="float-end"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-16"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div></a><a href="#" data-post-id="${selectedId}" data-modal-lg="1" data-act="ajax-modal" data-title="" data-action-url="">${selectedText}</a></div>
                `)
            }
            
            else if(dependency_status==2) {
                selectedText=$('#edit-dependency-panel .select2-chosen').text();
                dependencies.push({id:selectedId,title:selectedText,blocking:dependency_status});
                $("#blocked-by-tasks").append(`
                <div id="dependency-task-row-${selectedId}" class="list-group-item mb5 dependency-task-row b-a rounded" style="border-left: 5px solid #F9A52D !important;">
                <a href="#" class="delete-dependency-task" title="Delete" data-fade-out-on-success="#dependency-task-row-${selectedId}" data-dependency-type="blocked_by" data-act="ajax-request" data-action-url="<?php echo get_uri("task_libraries/delete_dependency");?>">
                <div class="float-end"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-16"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div></a><a href="#" data-post-id="${selectedId}" data-modal-lg="1" data-act="ajax-modal" data-title="" data-action-url="">${selectedText}</a></div>
                `);
            }
            // if(!$("#blocking-area").hasClass('hide')) $("#blocking-area").addClass("hide");
            // if(!$("#blocked-by-area").hasClass('hide')) $("#blocked-by-area").addClass("hide")
            // if(!$("#dependency-list-title").hasClass('hide')) $("#dependency-list-title").addClass("hide")
            // if(!$("#edit-dependency-panel").prop('hidden')) $("#edit-dependency-panel").prop("hidden",true)
        })
        $("#cost_item_currency").on("change",function(){
            $("#cost_item_currency_symbol")[0].selectedIndex=$("#cost_item_currency")[0].selectedIndex;
        });
        $(".delete-dependency-task").on("click",function(){
            var deletedIndex=$(this).parent().index();
            dependencies.splice(deletedIndex,1);
        })
    });
    var dependencies=[]
    var dependency_status=0;
    var checklist_items=[];
    var cost_items=[];
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
    function delete_item(index){
        cost_items.splice(index,1);
        $("#table-quotes-from-yard")[0].getElementsByTagName('tbody')[0].deleteRow(index);
    }
    function start_edit_cost_item(index){
        $("#editing_cost_item")[0].value=index;
        if($("#insert-cost-item-panel").prop("hidden")) $("#btn-add-new-quote")[0].click();
        $("#cost_item_name")[0].value=cost_items[index].name;
        $("#cost_item_description")[0].value=cost_items[index].description;
        $("#cost_item_quantity")[0].value=cost_items[index].quantity;
        $("#cost_item_measurement")[0].value=cost_items[index].measurement;
        $("#cost_item_unit_price")[0].value=cost_items[index].unit_price;
        $("#cost_item_quote_type")[0].value=cost_items[index].quote_type;
        $("#cost_item_currency")[0].value=cost_items[index].currency;
        $("#cost_item_yard_remarks")[0].value=cost_items[index].yard_remarks;
        $("#cost_item_discount")[0].value=cost_items[index].yard_remarks;
    }
    <?php
        if(isset($gotTasklibrary)&&$gotTasklibrary->dependencies)
        echo 'dependencies=JSON.parse(`'.$gotTasklibrary->dependencies.'`);';
    ?>
    <?php
        if(isset($gotTasklibrary)&&$gotTasklibrary->reference_drawing)
        echo 'cost_items=JSON.parse(`'.$gotTasklibrary->reference_drawing.'`);';
    ?>
    <?php
        if(isset($gotChecklistItems))
        echo 'checklist_items='.json_encode($gotChecklistItems).';'
    ?>
    
</script>