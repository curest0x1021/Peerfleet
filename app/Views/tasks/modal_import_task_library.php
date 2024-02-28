<?php $modalId=rand(); ?>
<div id="tasks-dropzone" class="post-dropzone">
    
    <div class="modal-body clearfix">
        <?php echo form_open(get_uri("tasks/save"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
        <input hidden name="id" value="<?php if(isset($gotTask)) echo $gotTask->id; ?>" />
        <div class="card-header d-flex justify-content-between">
            <h4><?php 
            // echo isset($gotTasklibrary)?"Edit Task" :"Add Task"; 
            ?></h4>
            
        </div>
        <div class="card-body">
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group" >
                        <div class="row">
                            <label for="select_library" class="col-md-4">Library:</label>
                            <div class="col-md-8" >
                                <?php
                                $task_libraries_dropdown=array();
                                foreach ($allTaskLibraries as $key => $oneLibrary) {
                                    $task_libraries_dropdown[]=array(
                                        "id"=>$oneLibrary->id,
                                        "text"=>$oneLibrary->title
                                    );
                                }
                                echo form_input(array(
                                    "id" => "task_library".$modalId,
                                    "name" => "task_library",
                                    "value" => count($task_libraries_dropdown)>0?$task_libraries_dropdown[0]['id']:"",
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
                    <div class="form-group" >
                        <div class="row">
                            <label for="select_library" class="col-md-4">Title:</label>
                            <div class="col-md-8" >
                                <?php
                                echo form_input(array(
                                    "id" => "title_of_task".$modalId,
                                    "name" => "title_of_task",
                                    "value" => "",
                                    "class" => "form-control",
                                    "maxlength" => 15,
                                    "style"=>"border:1px solid lightgray",
                                    "placeholder" => app_lang('title'),
                                    "autocomplete" => "off"
                                ));
                                ?>
                                
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
                                array("id"=>"Systems machinery main components","text"=>"Systems machinery main components"),
                                array("id"=>"Common systems","text"=>"Common systems"),
                                array("id"=>"Others","text"=>"Others"),
                            );

                            echo form_input(array(
                                "id" => "category_input".$modalId,
                                "name" => "category_input",
                                "value" => isset($gotTask)?$gotTask->category:"",
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
                    <div class="form-group">
                        <div class="row">
                            <label for="dock_list_number" class="col-md-4"><?php echo app_lang('dock_list_number'); ?>:</label>
                            <div class="col-md-8" >
                                <?php                                
                                echo form_input(array(
                                    "id" => "dock_list_number".$modalId,
                                    "name" => "dock_list_number",
                                    "value" => isset($gotTask)?$gotTask->dock_list_number:"",
                                    "class" => "form-control",
                                    "maxlength" => 15,
                                    "readonly"=>true,
                                    "style"=>"border:1px solid lightgray",
                                    "placeholder" => app_lang('dock_list_number'),
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
                                    "id" => "supplier".$modalId,
                                    "name" => "supplier",
                                    "value" =>isset($gotTask)&& $gotTask->supplier?$gotTask->supplier:$suppliers_dropdown[0]['id'],
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
                                    "id" => "status_id".$modalId,
                                    "name" => "status_id",
                                    "value" => isset($gotTask)&&$gotTask->status_id?$gotTask->status_id:$status_dropdown[0]['id'],
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
                                    "id" => "priority_id".$modalId,
                                    "name" => "priority_id",
                                    "value" => isset($gotTask)&&$gotTask->priority_id?$gotTask->priority_id:$priority_dropdown[0]['id'],
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
                            <label for="start_date" class=" col-md-3"><?php echo app_lang('start_date'); ?>:</label>
                            <div class=" col-md-9">
                                <?php
                                echo form_input(array(
                                    "id" => "start_date".$modalId,
                                    "name" => "start_date",
                                    "autocomplete" => "off",
                                    "value" => isset($gotTask)&&$gotTask->start_date?date('d.m.Y', strtotime($gotTask->start_date)):"",
                                    "class" => "form-control",
                                    "placeholder" => "DD.MM.YYYY",
                                    "style"=>"border:1px solid lightgray",
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    
                    <div class="form-group">
                        <div class="row">
                            <label for="milestone_id" class="col-md-3"><?php echo app_lang('milestone'); ?>:</label>
                            <div class="col-md-9"  >
                                <?php
                                $milestone_dropdown=array();
                                foreach ($allMilestones as $oneMilestone) {
                                    $milestone_dropdown[]=array("id"=>$oneMilestone->id,"text"=>$oneMilestone->title);
                                }
                                echo form_input(array(
                                    "id" => "milestone_id".$modalId,
                                    "name" => "milestone_id",
                                    "value" => isset($gotTask)&&$gotTask->milestone_id?$gotTask->milestone_id:"",
                                    "class" => "form-control",
                                    "style"=>"border:1px solid lightgray",
                                    "placeholder" => app_lang('milestone'),
                                    "autocomplete" => "off"
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    
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
                                    "id" => "assigned_to".$modalId,
                                    "name" => "assigned_to",
                                    "value" => isset($gotTask)&&$gotTask->assigned_to?$gotTask->assigned_to:"-",
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
                                "id" => "collaborators".$modalId,
                                "name" => "collaborators",
                                "value" => isset($gotTask)&&$gotTask->collaborators?$gotTask->collaborators:"-",
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
                            <label for="deadline" class=" col-md-3"><?php echo app_lang('deadline'); ?></label>
                            <div class=" col-md-9">
                                <?php
                                echo form_input(array(
                                    "id" => "deadline".$modalId,
                                    "name" => "deadline",
                                    "style"=>"border:1px solid lightgray",
                                    "autocomplete" => "off",
                                    "value" => isset($gotTask)&&$gotTask->deadline?date('d.m.Y', strtotime($gotTask->deadline)):"",
                                    "class" => "form-control",
                                    "placeholder" => "DD.MM.YYYY",
                                    "data-rule-greaterThanOrEqual" => "#start_date",
                                    "data-msg-greaterThanOrEqual" => app_lang("deadline_must_be_equal_or_greater_than_start_date")
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
                                "id" => "description".$modalId,
                                "name" => "description",
                                "value" => isset($gotTask)&&$gotTask->description?$gotTask->description:"",
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
                                "id" => "location".$modalId,
                                "name" => "location",
                                "value" => isset($gotTask)&&$gotTask->location?$gotTask->location:"",
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
                                "id" => "specification".$modalId,
                                "name" => "specification",
                                "value" => isset($gotTask)&&$gotTask->specification?$gotTask->specification:"",
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
                                            "id" => "gas_free_certificate_yes".$modalId,
                                            "name" => "gas_free_certificate",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="gas_free_certificate_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "gas_free_certificate_no",
                                            "name" => "gas_free_certificate",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "painting_after_completion_yes".$modalId,
                                            "name" => "painting_after_completion",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="painting_after_completion_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "painting_after_completion_no",
                                            "name" => "painting_after_completion",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "light_yes".$modalId,
                                            "name" => "light",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="light_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "light_no",
                                            "name" => "light",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "parts_on_board_yes".$modalId,
                                            "name" => "parts_on_board",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="parts_on_board_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "parts_on_board_no",
                                            "name" => "parts_on_board",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "ventilation_yes".$modalId,
                                            "name" => "ventilation",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="ventilation_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "ventilation_no",
                                            "name" => "ventilation",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "transport_to_yard_workshop_yes".$modalId,
                                            "name" => "transport_to_yard_workshop",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="transport_to_yard_workshop_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "transport_to_yard_workshop_no",
                                            "name" => "transport_to_yard_workshop",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "crane_assistance_yes".$modalId,
                                            "name" => "crane_assistance",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="crane_assistance_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "crane_assistance_no",
                                            "name" => "crane_assistance",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "transport_outside_yard_yes".$modalId,
                                            "name" => "transport_outside_yard",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="transport_outside_yard_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "transport_outside_yard_no",
                                            "name" => "transport_outside_yard",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "cleaning_before_yes".$modalId,
                                            "name" => "cleaning_before",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="cleaning_before_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "cleaning_before_no".$modalId,
                                            "name" => "cleaning_before",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "material_yards_supply_yes".$modalId,
                                            "name" => "material_yards_supply",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="material_yards_supply_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "material_yards_supply_no",
                                            "name" => "material_yards_supply",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "cleaning_after_yes".$modalId,
                                            "name" => "cleaning_after",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="cleaning_after_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "cleaning_after_no",
                                            "name" => "cleaning_after",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "material_owners_supply_yes".$modalId,
                                            "name" => "material_owners_supply",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="material_owners_supply_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "material_owners_supply_no",
                                            "name" => "material_owners_supply",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "work_permit_yes".$modalId,
                                            "name" => "work_permit",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="work_permit_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "work_permit_no",
                                            "name" => "work_permit",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                            "id" => "risk_assessment_yes".$modalId,
                                            "name" => "risk_assessment",
                                            "class" => "form-check-input",
                                        ), "1", false);
                                        ?>
                                        <label for="risk_assessment_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                        <?php
                                        echo form_radio(array(
                                            "id" => "risk_assessment_no",
                                            "name" => "risk_assessment",
                                            "class" => "form-check-input",
                                        ), "0", true);
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
                                    "id" => "maker".$modalId,
                                    "name" => "maker",
                                    "value" => isset($gotTask)&&$gotTask->maker?$gotTask->maker:"",
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
                                    "id" => "type".$modalId,
                                    "name" => "type",
                                    "value" => isset($gotTask)&&$gotTask->type?$gotTask->type:"",
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
                                    "id" => "serial_number".$modalId,
                                    "name" => "serial_number",
                                    "value" => isset($gotTask)&&$gotTask->serial_number?$gotTask->serial_number:"",
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
                    <div class="form-group">
                        <div class="row">
                            <label for="pms_scs_number" class=" col-md-4"><?php echo app_lang('pms_scs_number'); ?></label>
                            <div class=" col-md-8" >
                                <?php
                                echo form_input(array(
                                    "id" => "pms_scs_number".$modalId,
                                    "name" => "pms_scs_number",
                                    "value" => isset($gotTask)&&$gotTask->pms_scs_number?$gotTask->pms_scs_number:"",
                                    "class" => "form-control",
                                    "maxlength" => 30,
                                    "style"=>"border:1px solid lightgray",
                                    "placeholder" => app_lang('pms_scs_number'),
                                    "autocomplete" => "off"
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-md-7" >
                    <div class="card" style="border: solid 1px lightgray;min-height:50vh;">
                        <div class="card-header d-flex">
                            <b>Cost Item List</b>
                        </div>
                        <div class="card-body" style="padding:1px" >
                            <table id="table-costs-item-list<?php echo $modalId;?>" class="table " style="margin:0" >
                                <thead>
                                <tr>
                                    <td>Cost item name</td>
                                    <td>UNIT PRICE AND QUANTITY</td>
                                    <td>QUOTE</td>
                                    <td ><button type="button" id="btn-add-new-quote-start<?php echo $modalId;?>" class="btn btn-default btn-sm" ><i data-feather="plus" class="icon-16" ></i></button></td>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(isset($gotTask)&&$gotTask->cost_items){
                                        $cost_items=json_decode($gotTask->cost_items);
                                        if(is_array($cost_items))
                                            foreach ($cost_items as $key=>$oneItem) {
                                                # code...
                                                echo "<tr><td>";
                                                echo $oneItem->name;
                                                echo "</td><td>";
                                                echo number_format($oneItem->quantity,1,".","")." ( ".$oneItem->measurement." ) X ".$oneItem->currency." ".number_format($oneItem->unit_price,2,".","")." ( ".$oneItem->quote_type." )";
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
                            <div id="insert-cost-item-panel-new<?php echo $modalId;?>" style="margin:5px;" hidden>
                                <div style="min-height:5vh" ></div>
                                <input hidden id="editing_cost_item<?php echo $modalId;?>" value="" />
                                <div class="row" >
                                    <div class="form-group" >
                                        <label>Cost item name:</label>
                                        <input
                                            id="input_cost_item_name<?php echo $modalId;?>"
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
                                            id="cost_item_description<?php echo $modalId;?>"
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
                                                id="cost_item_quote_type<?php echo $modalId;?>"
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
                                                id="input_cost_item_quantity<?php echo $modalId;?>"
                                                class="form-control"
                                                value="0.0"
                                                type="number"
                                                style="border:1px solid lightgray;border-radius:5px"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-3" >
                                        <div class="form-group" >
                                            <label>Measurement unit:</label>
                                            <input
                                                id="input_cost_item_measurement<?php echo $modalId;?>"
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
                                                <input value="0.00" class="form-control" id="input_cost_item_unit_price<?php echo $modalId;?>" type="number" />
                                                <?php
                                                $cost_item_currency_dropdown=array(
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
                                                array("id"=>"ZWD","text"=>"ZWD"));

                                                echo form_input(array(
                                                    "id" => "input_cost_item_currency_select".$modalId,
                                                    "name" => "input_cost_item_currency_select",
                                                    "value" => "AUD",
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
                                                <input id="cost_item_discount<?php echo $modalId;?>" type="text" class="form-control" value="0.0">
                                                <input readonly type="text" class="form-control" value="%" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-3" >
                                        <div class="form-group" >
                                            <label>Budget group:</label>
                                            <div class="input-group mb-3" style="border:1px solid lightgray;border-radius:5px">
                                            <?php
                                            // $budget_group_dropdown=array();
                                            // foreach ($allVariationOrders as $oneOrder) {
                                            //     $budget_group_dropdown[]=array("id"=>$oneOrder->id,"text"=>$oneOrder->name);
                                            // }
                                            ?>    
                                            <input id="cost_item_budget_group<?php 
                                            // echo $modalId;
                                            ?>" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="row" >
                                    <div class="form-group" >
                                        <label>Yard remarks:</label>
                                        <textarea style="border:1px solid lightgray;border-radius:5px" id="cost_item_yard_remarks<?php echo $modalId;?>" class="form-control" name="yard_remarks" ></textarea>
                                    </div>
                                </div>
                                <div class="row" >
                                    <div class="col-md-1" >
                                        <button id="btn-insert-add-cost-item<?php echo $modalId;?>" type="button" class="btn btn-primary" >Save</button>
                                    </div>
                                    <div class="col-md-1" >
                                        <button id="cancel-add-cost-item<?php echo $modalId;?>" type="button" class="btn btn-default" >Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-5"  >
                    <!--checklist-->
                    <div class="card" style="border:1px solid lightgray;" >
                    <?php 
                    // echo form_open(get_uri("tasks/save_checklist_item"), array("id" => "checklist_form", "class" => "general-form", "role" => "form")); 
                    ?>
                    <div class="card-header d-flex">
                        <strong class="float-start mr10"><?php echo app_lang("checklist"); ?></strong><span class="chcklists_status_count_modal<?php echo $modalId;?>">0</span><span>/</span><span class="chcklists_count_modal<?php echo $modalId;?>"></span>
                    </div>
                    <div class="card-body d-flex" >
                        <div class="col-md-12 mb15 b-t">
                            <div class="pb10 pt10">
                                <!-- <strong class="float-start mr10"><?php echo app_lang("checklist"); ?></strong><span class="chcklists_status_count_modal">0</span><span>/</span><span class="chcklists_count_modal"></span> -->
                            </div>
                            <input type="hidden" id="is_checklist_group<?php echo $modalId;?>" name="is_checklist_group" value="" />
                            <div class="checklist-items-panel-modal<?php echo $modalId;?>" id="checklist-items-panel-modal<?php echo $modalId;?>">
                                <!--chekclist-items-lsiting-here-->
                            <?php
                                if(isset($gotChecklistItems))
                                foreach($gotChecklistItems as $key=>$oneItem){
                                    echo '<div id="checklist-item-row-'.$oneItem->id.'" class="list-group-item mb5 checklist-item-row-'.$modalId.' b-a rounded text-break" data-id="'.$oneItem->id.'"><a href="#" title="" data-id="'.$oneItem->id.'" data-value="'.$oneItem->id.'" data-act="update-checklist-item-status-checkbox'.$modalId.'"><span class="checkbox-blank mr15 float-start"></span></a><a href="#" item-id="'.$oneItem->id.'" class="delete-checklist-item'.$modalId.'" title="Delete checklist item"><div class="float-end"><i data-feather="x" class="icon-16"></i></div></a><span class="font-13">'.$oneItem->title.'</span></div>';
                                }
                            ?>
                            </div>
                                <div class="mb5 mt5 btn-group checklist-options-panel-modal<?php echo $modalId;?> hide" role="group">
                                    <button id="type-new-item-button<?php echo $modalId;?>" type="button" class="btn btn-default checklist_button<?php echo $modalId;?> active"> <?php echo app_lang('type_new_item'); ?></button>
                                    <button id="select-from-template-button<?php echo $modalId;?>" type="button" class="btn btn-default checklist_button<?php echo $modalId;?>"> <?php echo app_lang('select_from_template'); ?></button>
                                    <!-- <button id="select-from-checklist-group-button" type="button" class="btn btn-default checklist_button"> <?php echo app_lang('select_from_checklist_group'); ?></button> -->
                                </div>
                                <div class="form-group">
                                    <div class="mt5 p0" style="border:1px solid lightgray;border:5px;">
                                        <?php
                                        echo form_input(array(
                                            "id" => "checklist-add-item-modal".$modalId,
                                            "name" => "checklist-add-item-modal",
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
                                <div class="mb10 p0 checklist-options-panel-modal<?php echo $modalId; ?> hide">
                                    <button id="add-checklist-item-modal<?php echo $modalId; ?>" type="button" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></button>
                                    <button id="checklist-options-panel-modal-close<?php echo $modalId; ?>" type="button" class="btn btn-default ms-2"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('cancel'); ?></button>
                                </div>
                        </div>
                    </div>
                    <?php 
                    // echo form_close(); 
                    ?> 
                    </div>
                    <!---->
                    <div class="card" style="border:solid 1px lightgray" >
                        <div class="card-body" >
                            <!--Task dependency-->
                            <div class="col-md-12 mb15">
                                <span class="dropdown">
                                    <button class="btn btn-default dropdown-toggle btn-border" type="button" data-bs-toggle="dropdown" aria-expanded="true">
                                        <i data-feather="shuffle" class="icon-16"></i> <?php echo app_lang('add_dependency'); ?>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li id="toggle-blocking-panel<?php echo $modalId; ?>"><?php echo js_anchor(app_lang("this_task_blocking"), array("class" => "add-dependency-btn dropdown-item", "data-dependency_type" => "blocking")); ?></li>
                                        <li id="toggle-blocked-by-panel<?php echo $modalId; ?>" role="presentation"><?php echo js_anchor(app_lang("this_task_blocked_by"), array("class" => "add-dependency-btn dropdown-item", "data-dependency_type" => "blocked_by")); ?></li>
                                    </ul>
                                </span>
                            </div>
                            <div class="col-md-12 mb15" id="dependency-area<?php echo $modalId; ?>">
                                <div class="pb10 pt10 hide" id="dependency-list-title<?php echo $modalId; ?>">
                                    <strong><?php echo app_lang("dependency"); ?></strong>
                                </div>
                                <?php
                                $gotDependencies=array();
                                if(isset($gotTask)) $gotDependencies=json_decode($gotTask->dependencies,true);
                                $blockingDependencies=array();
                                $blockedDependencies=array();
                                if(is_array($gotDependencies)) foreach($gotDependencies as $oneDependency){
                                    if($oneDependency['blocking']==1){
                                        $blockingDependencies[]= '
                                        <div id="dependency-task-row-'.$oneDependency['id'].'-'.$modalId.'" class="list-group-item mb5 dependency-task-row b-a rounded" style="border-left: 5px solid #F9A52D !important;">
                                        <a href="#" class="delete-dependency-task'.$modalId.'" title="Delete" data-fade-out-on-success="#dependency-task-row-'.$oneDependency['id'].'-'.$modalId.'" data-dependency-type="blocked_by" data-act="ajax-request" data-action-url="#">
                                        <div class="float-end"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-16"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div></a><a href="#" data-post-id="'.$oneDependency['id'].'" data-modal-lg="1" data-act="ajax-modal" data-title="" data-action-url="#">'.$oneDependency['title'].'</a></div>
                                        ';
                                    }else $blockedDependencies[]='
                                    <div id="dependency-task-row-'.$oneDependency['id'].'-'.$modalId.'" class="list-group-item mb5 dependency-task-row b-a rounded" style="border-left: 5px solid #F9A52D !important;">
                                    <a href="#" class="delete-dependency-task'.$modalId.'" title="Delete" data-fade-out-on-success="#dependency-task-row-'.$oneDependency['id'].'-'.$modalId.'" data-dependency-type="blocked_by" data-act="ajax-request" data-action-url="#">
                                    <div class="float-end"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-16"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div></a><a href="#" data-post-id="'.$oneDependency['id'].'" data-modal-lg="1" data-act="ajax-modal" data-title="" data-action-url="#">'.$oneDependency['title'].'</a></div>
                                    ';
                                    
                                };
                                ?>
                                <div class="p10 list-group-item mb15 dependency-section<?php echo $modalId;?> <?php echo (count($blockingDependencies)>0)?"":"hide"; ?>" id="blocking-area<?php echo $modalId; ?>">
                                    <div class="pb10"><strong><?php echo app_lang("blocking"); ?></strong></div>
                                    <div id="blocking-tasks<?php echo $modalId; ?>"><?php if(isset($blocking)) echo $blocking; ?>
                                    <?php
                                    
                                    foreach ($blockingDependencies as $oneBlocking) {
                                        echo $oneBlocking;
                                    }
                                    ?>
                                    </div>
                                </div>
                                <div class="p10 list-group-item mb15 dependency-section<?php echo $modalId; ?> <?php echo (count($blockedDependencies)>0)?"":"hide"; ?>" id="blocked-by-area<?php echo $modalId; ?>">
                                    <div class="pb10"><strong><?php echo app_lang("blocked_by"); ?></strong></div>
                                    <div id="blocked-by-tasks<?php echo $modalId; ?>"><?php if(isset($blocked_by)) echo $blocked_by; ?>
                                    <?php
                                    foreach ($blockedDependencies as $oneBlocked) {
                                        echo $oneBlocked;
                                    }
                                    ?>
                                    </div>
                                </div>

                                
                                <div id="edit-dependency-panel<?php echo $modalId; ?>" hidden  >
                                <?php //echo form_open(get_uri("tasks/save_dependency_tasks"), array("id" => "dependency_tasks_form", "class" => "general-form hide", "role" => "form")); ?>
                                <input hidden name="task_id<?php echo $modalId; ?>" value="<?php //echo $task_id; ?>" />

                                <div class="form-group mb0">
                                    <div class="mt5 col-md-12 p0" style="border:1px solid lightgray;border-radius:5px">

                                        <?php
                                        $dependency_dropdown=array();
                                        foreach ($allTasks as $oneTask) {
                                            $dependency_dropdown[]=array(
                                                "id"=>$oneTask->id,
                                                "text"=>$oneTask->title
                                            );
                                        }
                                        echo form_input(array(
                                            "id" => "dependency_task".$modalId,
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
                                    <button id="btn-insert-edit-dependency<?php echo $modalId;?>" type="button" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></button>
                                    <button id="btn-cancel-edit-dependency<?php echo $modalId;?>" type="button" class="dependency-tasks-close btn btn-default"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('cancel'); ?></button>
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
            <div stlyle="margin-top:10px" class="row" >
                <div class="col-md-2" >
                    <button id="btn-file-upload-task<?php echo $modalId;?>" class="btn btn-default upload-file-button float-start me-auto btn-sm round" type="button" style="color:#7988a2"><i data-feather="camera" class="icon-16"></i> <?php echo app_lang("upload_file"); ?></button>
                </div>
                <div class="col-md-9" ></div>
                <div class="col-md-1"  >
                    <button type="button"
                    style="float:right"
                    old-id="btn-task-save"
                    id="btn-save-task-library<?php echo $modalId;?>"
                    class="btn btn-primary" ><i data-feather="check-circle" class="icon-16"></i> Save</button>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
    <?php echo view("includes/cropbox"); ?>

<script type="text/javascript">
    $(document).ready(function () {
        // $("#cost_item_currency_symbol").on('mousedown', false);
        // $("#cost_item_currency_symbol").on('keydown', false);
        $("#file-selector-btn<?php echo $modalId;?>").on("click",function(){
            $("#file-selector<?php echo $modalId;?>")[0].click();
        })
        $("#task_library<?php echo $modalId;?>").select2({
            data: <?php 
                echo (json_encode($task_libraries_dropdown)); 
            ?>
        });
        $('#task_library<?php echo $modalId;?>').on('change', function (e) {
            // Get the selected data
            $.ajax({
                url: '<?php echo_uri("tasks/get_task_library"); ?>/'+e.target.value,
                type: 'GET',
                // dataType: 'json',
                // data: {value: $(this).attr('data-value')},
                success: function (response) {
                    var library_info=JSON.parse(response);
                    $("#title_of_task<?php echo $modalId; ?>")[0].value=library_info.title;
                    $("#category_input<?php echo $modalId; ?>").val(library_info.category).trigger('change');
                    $("#supplier<?php echo $modalId; ?>").val(library_info.supplier).trigger('change');
                    $("#status_id<?php echo $modalId; ?>").val(library_info.status_id).trigger('change');
                    $("#priority_id<?php echo $modalId; ?>").val(library_info.priority_id).trigger('change');
                    $("#milestone_id<?php echo $modalId; ?>").val(library_info.milestone_id).trigger('change');
                    $("#assigned_to<?php echo $modalId; ?>").val(library_info.assigned_to).trigger('change');
                    $("#collaborators<?php echo $modalId; ?>").val(library_info.collaborators).trigger('change');

                    $("#description<?php echo $modalId; ?>").summernote("code",library_info.description);
                    $("#location<?php echo $modalId; ?>")[0].value=library_info.location;
                    $("#specification<?php echo $modalId; ?>")[0].value=library_info.specification;
                    $("#gas_free_certificate_yes<?php echo $modalId; ?>")[0].value=library_info.gas_free_certificate;
                    $("#painting_after_completion_yes<?php echo $modalId; ?>")[0].value=library_info.painting_after_completion;
                    $("#light_yes<?php echo $modalId; ?>")[0].value=library_info.light;
                    $("#parts_on_board_yes<?php echo $modalId; ?>")[0].value=library_info.parts_on_board;
                    $("#ventilation_yes<?php echo $modalId; ?>")[0].value=library_info.vantilation;
                    $("#transport_to_yard_workshop_yes<?php echo $modalId; ?>")[0].value=library_info.transport_to_yard_workshop;
                    $("#crane_assistance_yes<?php echo $modalId; ?>")[0].value=library_info.crane_assistance;
                    $("#transport_outside_yard_yes<?php echo $modalId; ?>")[0].value=library_info.transport_outside_yard;
                    $("#cleaning_before_yes<?php echo $modalId; ?>")[0].value=library_info.cleaning_before;
                    $("#material_yards_supply_yes<?php echo $modalId; ?>")[0].value=library_info.material_yards_supply;
                    $("#cleaning_after_yes<?php echo $modalId; ?>")[0].value=library_info.cleaning_after;
                    $("#material_owners_supply_yes<?php echo $modalId; ?>")[0].value=library_info.material_owners_supply;
                    $("#work_permit_yes<?php echo $modalId; ?>")[0].value=library_info.work_permit;
                    $("#risk_assessment_yes<?php echo $modalId; ?>")[0].value=library_info.risk_assessment;
                    $("#maker<?php echo $modalId; ?>")[0].value=library_info.marker;
                    $("#type<?php echo $modalId; ?>")[0].value=library_info.type;
                    $("#serial_number<?php echo $modalId; ?>")[0].value=library_info.serial_number;
                    $("#pms_scs_number<?php echo $modalId; ?>")[0].value=library_info.pms_scs_number;
                    cost_items=JSON.parse(library_info.reference_drawing)
                    var table=$("#table-costs-item-list<?php echo $modalId;?>")[0].getElementsByTagName('tbody')[0];
                    table.innerHTML="";
                    for(var oneItem of cost_items){
                        
                        var newRow = table.insertRow();

                        var cell0 = newRow.insertCell(0);
                        var cell1 = newRow.insertCell(1);
                        var cell2 = newRow.insertCell(2);
                        var cell3 = newRow.insertCell(3);

                        cell0.innerHTML = oneItem.name;
                        cell1.innerHTML = Number(oneItem.quantity).toFixed(1)+' '+oneItem.measurement_unit+" X "+oneItem.currency+" "+Number(oneItem.unit_price).toFixed(2)+" ( "+oneItem.quaote_type+" ) ";
                        cell2.innerHTML = oneItem.currency+" "+(Number(oneItem.quantity)*Number(oneItem.unit_price)).toFixed(2);
                        cell3.innerHTML=`
                        <button onClick="start_edit_cost_item(${cost_items.length})" type="button" class="btn btn-sm" ><i style="color:gray" data-feather="edit" class="icon-16" ></i></button>
                        <button type="button" onClick="delete_item(${cost_items.length})" class="btn btn-sm" ><i style="color:gray" data-feather="x-circle" class="icon-16" ></i></button>
                        `;
                    }
                    // var prefix=e.target.value[0].toUpperCase();
                    // $("#dock_list_number<?php //echo $modalId;?>")[0].value=prefix+(Number(response)+1).toString().padStart(2, '0');
                }
            });
        });
        $("#category_input<?php echo $modalId;?>").select2({
            data: <?php 
                echo (json_encode($category_dropdown)); 
                ?>
        });
        $("#input_cost_item_currency_select<?php echo $modalId;?>").select2({
            data: <?php 
                echo (json_encode($cost_item_currency_dropdown)); 
            ?>
        });

        $("#category_input<?php echo $modalId;?>").on("change",function(e){
            
            $.ajax({
                url: '<?php echo_uri("tasks/get_count_category"); ?>/'+e.target.value,
                type: 'GET',
                // dataType: 'json',
                // data: {value: $(this).attr('data-value')},
                success: function (response) {
                    var prefix=e.target.value[0].toUpperCase();
                    $("#dock_list_number<?php echo $modalId;?>")[0].value=prefix+(Number(response)+1).toString().padStart(2, '0');
                }
            });
        })
        $("#collaborators<?php echo $modalId;?>").select2({
            data: <?php echo (json_encode($collaborators_dropdown)); ?>
        });
        $("#status_id<?php echo $modalId;?>").select2({
            data: <?php echo (json_encode($status_dropdown)); ?>
        });
        $("#priority_id<?php echo $modalId;?>").select2({
            data: <?php echo (json_encode($priority_dropdown)); ?>
        });
        $("#milestone_id<?php echo $modalId;?>").select2({
            data: <?php echo (json_encode($milestone_dropdown)); ?>
        });
        $("#assigned_to<?php echo $modalId;?>").select2({
            data: <?php echo (json_encode($assigned_to_dropdown)); ?>
        });
        $("#supplier<?php echo $modalId;?>").select2({
            data: <?php echo (json_encode($suppliers_dropdown)); ?>
        });
        $("#dependency-task<?php echo $modalId;?>").select2({
            data: <?php echo (json_encode($dependency_dropdown)); ?>
        });
        // $("#cost_item_budget_group<?php 
        // // echo $modalId;
        // ?>").select2({
        //     data: <?php 
        //         // echo (json_encode($budget_group_dropdown)); 
        //         ?>
        // });
        setDatePicker("#start_date<?php echo $modalId;?>");
        setDatePicker("#deadline<?php echo $modalId;?>");
        $("#description<?php echo $modalId;?>").summernote({
            height:250
        });
        $('.note-editor').css({
            'border-radius':'5px'
        });
        var $selector = $("#checklist-items-panel-modal<?php echo $modalId;?>");
        

        //show the items in checklist

        //show save & cancel button when the checklist-add-item-form is focused
        $("#checklist-add-item-modal<?php echo $modalId;?>").focus(function () {
            $(".checklist-options-panel-modal<?php echo $modalId;?>").removeClass("hide");
            $("#checklist-add-item-error<?php echo $modalId;?>").removeClass("hide");
        });

        $("#checklist-options-panel-close").click(function () {
            $(".checklist-options-panel-modal<?php echo $modalId;?>").addClass("hide");
            $("#checklist-add-item-error<?php echo $modalId;?>").addClass("hide");
            $("#checklist-add-item-modal<?php echo $modalId;?>").val("");

            $("#checklist-add-item-modal<?php echo $modalId;?>").select2("destroy").val("");
            $("#checklist-template-toggle-button<?php echo $modalId;?>").html("<?php echo "<i data-feather='hash' class='icon-16'></i> " . app_lang('select_from_template'); ?>");
            $("#checklist-template-toggle-button<?php echo $modalId;?>").addClass('checklist-template-button');
            feather.replace();

            $(".checklist_button<?php echo $modalId;?>").removeClass("active");
            $("#type-new-item-button<?php echo $modalId;?>").addClass("active");
        });

        //count checklists
        function count_checklists() {
            var checklists = $(".checklist-items-panel-modal<?php echo $modalId;?> .checklist-item-row-<?php echo $modalId;?>").length;
            $(".chcklists_count_modal<?php echo $modalId;?>").text(checklists);

            //reload kanban
        }

        checklists = $(".checklist-items-panel-modal<?php echo $modalId;?> .checklist-item-row-<?php echo $modalId;?>").length;
        $("#add-checklist-item-modal<?php echo $modalId;?>").on("click",function(){
            var checklist_item_title=$("#checklist-add-item-modal<?php echo $modalId;?>")[0].value;
            checklist_items.push({
                title:checklist_item_title,
                task_id:<?php echo isset($gotTask->id)?$gotTask->id:0; ?>,
                is_checked:0
            });
            var newTempId=checklist_items.length;
            $('#checklist-items-panel-modal<?php echo $modalId;?>').append(`
                <div id="checklist-item-row-${newTempId}" class="list-group-item mb5 checklist-item-row-${newTempId} b-a rounded text-break" data-id="${newTempId}"><a href="#" title="" data-id="${newTempId}" data-value="${newTempId}" data-act="update-checklist-item-status-checkbox<?php echo $modalId;?>"><span class="checkbox-blank mr15 float-start"></span></a><a href="#" onclick="delete_checklist_item(this)" item-id="${newTempId}" class="delete-checklist-item<?php echo $modalId;?>" title="Delete checklist item"><div class="float-end"><i data-feather="x" class="icon-16"></i></div></a><span class="font-13">${checklist_item_title}</span></div>
            `);
            $("#checklist-add-item-modal<?php echo $modalId;?>")[0].value="";
            checklists++;
            $(".chcklists_count_modal<?php echo $modalId;?>").text(checklists);
        })
        $(".delete-checklist-item<?php echo $modalId;?>").on('click',function () {
            checklist_items.splice(checklist_items.findIndex(oneItem=>oneItem.id==$(this).attr("item-id")),1)
            $(this).parent().remove();
            checklists--;
            $(".chcklists_count_modal<?php echo $modalId;?>").text(checklists);
        });

        

        count_checklists();

        checklist_complete = $(".checklist-items-panel-modal<?php echo $modalId;?> .checkbox-checked").length;
        $(".chcklists_status_count_modal<?php echo $modalId;?>").text(checklist_complete);

        $("#checklist_form<?php echo $modalId;?>").appForm({
            isModal: false,
            onSuccess: function (response) {
                $("#checklist-add-item-modal<?php echo $modalId;?>").val("");
                $("#checklist-add-item-modal<?php echo $modalId;?>").focus();
                $("#checklist-items-panel-modal<?php echo $modalId;?>").append(response.data);

                count_checklists();
            }
        });
         //change the add checklist input box type
         $("#select-from-template-button<?php echo $modalId;?>").click(function() {
            $(".checklist_button<?php echo $modalId;?>").removeClass("active");
            applySelect2OnChecklistTemplate();
            $(this).addClass("active");
            $("#is_checklist_group<?php echo $modalId;?>").val("0");
        });

        $("#select-from-checklist-group-button<?php echo $modalId;?>").click(function() {
            $(".checklist_button<?php echo $modalId;?>").removeClass("active");
            applySelect2OnChecklistGroup();
            $(this).addClass("active");
            $("#is_checklist_group<?php echo $modalId;?>").val("1");
        });

        $("#type-new-item-button<?php echo $modalId;?>").click(function() {
            $(".checklist_button<?php echo $modalId;?>").removeClass("active");
            $("#checklist-add-item-modal<?php echo $modalId;?>").select2("destroy").val("").focus();
            $("#is_checklist_group<?php echo $modalId;?>").val("0");
            $(this).addClass("active");
        });

        function applySelect2OnChecklistTemplate() {
            $("#checklist-add-item-modal<?php echo $modalId;?>").select2({
                showSearchBox: true,
                ajax: {
                    url: "<?php echo get_uri("tasks/get_checklist_template_suggestion"); ?>",
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
                        $("#checklist-add-item-modal<?php echo $modalId;?>").val("");
                    }
                }
            });
        }

        function applySelect2OnChecklistGroup() {
            $("#checklist-add-item-modal<?php echo $modalId;?>").select2({
                showSearchBox: true,
                ajax: {
                    url: "<?php echo get_uri("tasks/get_checklist_group_suggestion"); ?>",
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
                        $("#checklist-add-item-modal<?php echo $modalId;?>").val("");
                    }
                }
            });
        }
        
        $('body').on('click', '[data-act=update-checklist-item-status-checkbox<?php echo $modalId;?>]', function () {
            var status_checkbox = $(this).find("span");
            if(status_checkbox.hasClass('checkbox-checked')){
                status_checkbox.removeClass("checkbox-checked");
                checklist_complete--;
            }else {
                status_checkbox.addClass("checkbox-checked");
                checklist_complete++;
            }
            $(".chcklists_status_count_modal<?php echo $modalId;?>").text(checklist_complete);


        });
        $("#btn-add-new-quote-start<?php echo $modalId;?>").on("click",function(){
            if($("#insert-cost-item-panel-new<?php echo $modalId;?>").prop("hidden")){
                $("#insert-cost-item-panel-new<?php echo $modalId;?>").prop("hidden",false);
                // $("#btn-add-new-quote-start<?php echo $modalId;?>").prop("disabled", true);
            }else{
                $("#insert-cost-item-panel-new<?php echo $modalId;?>").prop("hidden",true);
                // $("#btn-add-new-quote-start<?php echo $modalId;?>").prop("disabled", false);
            }
            

        })
        $("#btn-insert-add-cost-item<?php echo $modalId;?>").on("click",function(){
            if($("#input_cost_item_name<?php echo $modalId;?>")[0].value==""||
            $("#input_cost_item_quantity<?php echo $modalId;?>")[0].value==""||
            $("#input_cost_item_unit_price<?php echo $modalId;?>")[0].value=="")
            return;
            var table=$("#table-costs-item-list<?php echo $modalId;?>")[0].getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();

            var cell0 = newRow.insertCell(0);
            var cell1 = newRow.insertCell(1);
            var cell2 = newRow.insertCell(2);
            var cell3 = newRow.insertCell(3);

            cell0.innerHTML = $("#input_cost_item_name<?php echo $modalId;?>")[0].value;
            cell1.innerHTML = Number($("#input_cost_item_quantity<?php echo $modalId;?>")[0].value).toFixed(1)+' '+$("#input_cost_item_measurement<?php echo $modalId;?>")[0].value+" X "+$("#input_cost_item_currency_select<?php echo $modalId;?>")[0].value+" "+Number($("#input_cost_item_unit_price<?php echo $modalId;?>")[0].value).toFixed(2)+" ( "+$("#cost_item_quote_type<?php echo $modalId;?>")[0].value+" ) ";
            cell2.innerHTML = $("#input_cost_item_currency_select<?php echo $modalId;?>")[0].value+" "+(Number($("#input_cost_item_quantity<?php echo $modalId;?>")[0].value)*Number($("#input_cost_item_unit_price<?php echo $modalId;?>")[0].value)).toFixed(2);
            cell3.innerHTML=`
            <button onClick="start_edit_cost_item(${cost_items.length})" type="button" class="btn btn-sm" ><i style="color:gray" data-feather="edit" class="icon-16" ></i></button>
            <button type="button" onClick="delete_item(${cost_items.length})" class="btn btn-sm" ><i style="color:gray" data-feather="x-circle" class="icon-16" ></i></button>
            `;
            $("#btn-add-new-quote-start<?php echo $modalId;?>").prop("disabled", false);
            $("#insert-cost-item-panel-new<?php echo $modalId;?>").prop("hidden",false);
            if($("#editing_cost_item<?php echo $modalId;?>")[0].value=="")
                cost_items.push({
                    name:$("#input_cost_item_name<?php echo $modalId;?>")[0].value,
                    quantity:$("#input_cost_item_quantity<?php echo $modalId;?>")[0].value,
                    measurement:$("#input_cost_item_measurement<?php echo $modalId;?>")[0].value,
                    unit_price:$("#input_cost_item_unit_price<?php echo $modalId;?>")[0].value,
                    quote_type:$("#cost_item_quote_type<?php echo $modalId;?>")[0].value,
                    currency:$("#input_cost_item_currency_select<?php echo $modalId;?>")[0].value,
                    description:$("#cost_item_description<?php echo $modalId;?>")[0].value,
                    yard_remarks:$("#cost_item_yard_remarks<?php echo $modalId;?>")[0].value,
                    discount:$("#cost_item_discount<?php echo $modalId;?>")[0].value,
                    // budget_group:$("#cost_item_budget_group<?php echo $modalId;?>")[0].value,
                });
            else{
                // $("#table-costs-item-list<?php 
                    // echo $modalId;
                    ?>")[0].getElementsByTagName('tbody')[0].deleteRow(Number($("#editing_cost_item<?php 
                    // echo $modalId;
                    ?>")[0].value));
                $("#table-costs-item-list<?php echo $modalId;?>")[0].getElementsByTagName('tbody')[0].deleteRow(editing_cost_item);
                // cost_items[Number($("#editing_cost_item<?php echo $modalId;?>")[0].value)]={
                cost_items[editing_cost_item]={
                    name:$("#input_cost_item_name<?php echo $modalId;?>")[0].value,
                    quantity:$("#input_cost_item_quantity<?php echo $modalId;?>")[0].value,
                    measurement:$("#input_cost_item_measurement<?php echo $modalId;?>")[0].value,
                    unit_price:$("#input_cost_item_unit_price<?php echo $modalId;?>")[0].value,
                    quote_type:$("#cost_item_quote_type<?php echo $modalId;?>")[0].value,
                    currency:$("#input_cost_item_currency_select<?php echo $modalId;?>")[0].value,
                    description:$("#cost_item_description<?php echo $modalId;?>")[0].value,
                    yard_remarks:$("#cost_item_yard_remarks<?php echo $modalId;?>")[0].value,
                    discount:$("#cost_item_discount<?php echo $modalId;?>")[0].value,
                    // budget_group:$("#cost_item_budget_group<?php echo $modalId;?>")[0].value,
                };
                // $("#editing_cost_item<?php echo $modalId;?>")[0].value=""
                editing_cost_item=null;
            }
            $("#input_cost_item_name<?php echo $modalId;?>")[0].value="";
            $("#input_cost_item_quantity<?php echo $modalId;?>")[0].value="";
            // $("#input_cost_item_measurement<?php echo $modalId;?>")[0].value="";
            $("#input_cost_item_unit_price<?php echo $modalId;?>")[0].value="";
            $("#cost_item_description<?php echo $modalId;?>")[0].value="";
            $("#cost_item_yard_remarks<?php echo $modalId;?>")[0].value="";
            $("#cost_item_discount<?php echo $modalId;?>")[0].value=""
        });
        $("#cancel-add-cost-item<?php echo $modalId;?>").on("click",function(){
            $("#insert-cost-item-panel-new<?php echo $modalId;?>").prop("hidden",true);
            $("#btn-add-new-quote-start<?php echo $modalId;?>").prop("disabled", false);
        })
        
        
        var uploadUrl = "<?php echo get_uri('tasks/upload_file'); ?>";
        var validationUri = "<?php echo get_uri('tasks/validate_task_file'); ?>";
        var dropzone = attachDropzoneWithForm("#tasks-dropzone", uploadUrl, validationUri);
        $("#btn-save-task-library<?php echo $modalId; ?>").on("click",function(){
            var rise_csrf_token = $('[name="rise_csrf_token"]').val();
            var id=$('[name="id"]').val();
            var title=$("#title_of_task<?php echo $modalId; ?>")[0].value;
            var category=$("#category_input<?php echo $modalId; ?>")[0].value;
            var dock_list_number=$("#dock_list_number<?php echo $modalId; ?>")[0].value;
            var supplier=$("#supplier<?php echo $modalId; ?>")[0].value;
            var status_id=$("#status_id<?php echo $modalId; ?>")[0].value;
            var priority_id=$("#priority_id<?php echo $modalId; ?>")[0].value;
            var milestone_id=$("#milestone_id<?php echo $modalId; ?>")[0].value;
            var assigned_to=$("#assigned_to<?php echo $modalId; ?>")[0].value;
            var collaborators=$("#collaborators<?php echo $modalId; ?>")[0].value;
            var description=$("#description<?php echo $modalId; ?>")[0].value;
            var location=$("#location<?php echo $modalId; ?>")[0].value;
            var specification=$("#specification<?php echo $modalId; ?>")[0].value;
            var gas_free_certificate_yes=$("#gas_free_certificate_yes<?php echo $modalId; ?>")[0].value;
            var painting_after_completion_yes=$("#painting_after_completion_yes<?php echo $modalId; ?>")[0].value;
            var light_yes=$("#light_yes<?php echo $modalId; ?>")[0].value;
            var parts_on_board_yes=$("#parts_on_board_yes<?php echo $modalId; ?>")[0].value;
            var ventilation_yes=$("#ventilation_yes<?php echo $modalId; ?>")[0].value;
            var transport_to_yard_workshop_yes=$("#transport_to_yard_workshop_yes<?php echo $modalId; ?>")[0].value;
            var crane_assistance_yes=$("#crane_assistance_yes<?php echo $modalId; ?>")[0].value;
            var transport_outside_yard_yes=$("#transport_outside_yard_yes<?php echo $modalId; ?>")[0].value;
            var cleaning_before_yes=$("#cleaning_before_yes<?php echo $modalId; ?>")[0].value;
            var material_yards_supply_yes=$("#material_yards_supply_yes<?php echo $modalId; ?>")[0].value;
            var cleaning_after_yes=$("#cleaning_after_yes<?php echo $modalId; ?>")[0].value;
            var material_owners_supply_yes=$("#material_owners_supply_yes<?php echo $modalId; ?>")[0].value;
            var work_permit_yes=$("#work_permit_yes<?php echo $modalId; ?>")[0].value;
            var risk_assessment_yes=$("#risk_assessment_yes<?php echo $modalId; ?>")[0].value;
            var maker=$("#maker<?php echo $modalId; ?>")[0].value;
            var type=$("#type<?php echo $modalId; ?>")[0].value;
            var serial_number=$("#serial_number<?php echo $modalId; ?>")[0].value;
            var pms_scs_number=$("#pms_scs_number<?php echo $modalId; ?>")[0].value;
            var start_date=$("#start_date<?php echo $modalId; ?>")[0].value;
            var deadline=$("#deadline<?php echo $modalId; ?>")[0].value;
            var project_id=`<?php echo $project_id; ?>`
            const myForm=new FormData();
            myForm.append("rise_csrf_token",rise_csrf_token);
            myForm.append("id",id);
            myForm.append("title",title);
            myForm.append("category",category);
            myForm.append("dock_list_number",dock_list_number);
            myForm.append("supplier",supplier);
            myForm.append("status_id",status_id);
            myForm.append("priority_id",priority_id);
            myForm.append("milestone_id",milestone_id);
            myForm.append("assigned_to",assigned_to);
            myForm.append("collaborators",collaborators);
            myForm.append("description",description);
            myForm.append("location",location);
            myForm.append("specification",specification);
            myForm.append("start_date",start_date);
            myForm.append("deadline",deadline);
            myForm.append("gas_free_certificate",gas_free_certificate_yes);
            myForm.append("painting_after_completion",painting_after_completion_yes);
            myForm.append("light",light_yes);
            myForm.append("parts_on_board",parts_on_board_yes);
            myForm.append("ventilation",ventilation_yes);
            myForm.append("transport_to_yard_workshop",transport_to_yard_workshop_yes);
            myForm.append("crane_assistance",crane_assistance_yes);
            myForm.append("transport_outside_yard",transport_outside_yard_yes);
            myForm.append("cleaning_before",cleaning_before_yes);
            myForm.append("material_yards_supply",material_yards_supply_yes);
            myForm.append("cleaning_after",cleaning_after_yes);
            myForm.append("material_owners_supply",material_owners_supply_yes);
            myForm.append("work_permit",work_permit_yes);
            myForm.append("risk_assessment",risk_assessment_yes);
            myForm.append("maker",maker);
            myForm.append("type",type);
            myForm.append("serial_number",serial_number);
            myForm.append("pms_scs_number",pms_scs_number);
            myForm.append("checklist_items",JSON.stringify(checklist_items));
            myForm.append("dependencies",dependencies);
            myForm.append("cost_items",JSON.stringify(cost_items));
            myForm.append("dependencies",JSON.stringify(dependencies));
            myForm.append("project_id",project_id);
            for(var oneFile of dropzone.files){
                myForm.append(oneFile.name,oneFile);
            }
            
            $.ajax({
                url: '<?php echo get_uri("tasks/save_ajax"); ?>',
                type: "POST",
                data: myForm,
                processData: false, // Prevent jQuery from automatically processing the data
                contentType: false, 
                success: function (response) {
                    // console.log(response)
                    if(JSON.parse(response).success) window.location.reload();
                    // appLoader.hide();
                    // window.location='<?php 
                    //echo get_uri('task_libraries/view/'); 
                    ?>'+JSON.parse(response).saved_id;
                }
            });
        });
        $('#toggle-blocking-panel<?php echo $modalId; ?>').on('click',function(){
            if($("#blocking-area<?php echo $modalId; ?>").hasClass('hide')) $("#blocking-area<?php echo $modalId; ?>").removeClass("hide");
            if(!$("#blocked-by-area<?php echo $modalId; ?>").hasClass('hide')) {
                if($("#blocked-by-area<?php echo $modalId; ?>").text=="")
                    $("#blocked-by-area<?php echo $modalId; ?>").addClass("hide")
                else {

                }
            }
            dependency_status=1;
            if($("#dependency-list-title<?php echo $modalId; ?>").hasClass('hide')) $("#dependency-list-title<?php echo $modalId; ?>").removeClass("hide")
            if($("#edit-dependency-panel<?php echo $modalId; ?>").prop('hidden')) $("#edit-dependency-panel<?php echo $modalId; ?>").prop("hidden",false)
            // if($("#dependency-area").hasClass('hide')) $("#dependency-area").removeClass("hide")
            $("#dependency_task<?php echo $modalId; ?>").select2({
            data: <?php echo (json_encode($dependency_dropdown)); ?>
            });
        });
        $('#toggle-blocked-by-panel<?php echo $modalId; ?>').on('click',function(){
            if(!$("#blocking-area<?php echo $modalId; ?>").hasClass('hide')) {
                if($("#blocking-area<?php echo $modalId; ?>").text=="")
                    $("#blocking-area<?php echo $modalId; ?>").addClass("hide");
                else{
                    
                }
            }
            dependency_status=2;
            if($("#blocked-by-area<?php echo $modalId; ?>").hasClass('hide')) $("#blocked-by-area<?php echo $modalId; ?>").removeClass("hide")
            if($("#dependency-list-title<?php echo $modalId; ?>").hasClass('hide')) $("#dependency-list-title<?php echo $modalId; ?>").removeClass("hide")
            if($("#edit-dependency-panel<?php echo $modalId; ?>").prop('hidden')) $("#edit-dependency-panel<?php echo $modalId; ?>").prop("hidden",false)
            // if($("#dependency-area").hasClass('hide')) $("#dependency-area").removeClass("hide")
            $("#dependency_task<?php echo $modalId; ?>").select2({
                data: <?php echo (json_encode($dependency_dropdown)); ?>
            });
        });
        $("#btn-cancel-edit-dependency<?php echo $modalId; ?>").on('click',function(){
            dependency_status=0;
            if(dependencies.length>0){
                if(!$("#blocking-area<?php echo $modalId; ?>").text()) console.log("empty")
                if(!$("#blocked-by-area<?php echo $modalId; ?>").text()) console.log("empty")
            }else {
                if(!$("#dependency-list-title<?php echo $modalId; ?>").hasClass('hide')) $("#dependency-list-title<?php echo $modalId; ?>").addClass("hide")
                if(!$("#blocking-area<?php echo $modalId; ?>").hasClass('hide')) $("#blocking-area<?php echo $modalId; ?>").addClass("hide");
                if(!$("#blocked-by-area<?php echo $modalId; ?>").hasClass('hide')) $("#blocked-by-area<?php echo $modalId; ?>").addClass("hide")
            }
            if(!$("#edit-dependency-panel<?php echo $modalId; ?>").prop('hidden')) $("#edit-dependency-panel<?php echo $modalId; ?>").prop("hidden",true)
        })
        $("#btn-insert-edit-dependency<?php echo $modalId; ?>").on('click',function(){
            var selectedId=$('#dependency_task<?php echo $modalId; ?>').val()
            var selectedText=""
            // console.log(selectedId,selectedText)
            for(var oneDependency of dependencies){
                if(String(oneDependency.id)==String(selectedId)) {
                    return;
                }
            }
            
            if(dependency_status==1){
                selectedText=$('#edit-dependency-panel<?php echo $modalId; ?> .select2-chosen').text();
                dependencies.push({id:selectedId,title:selectedText,blocking:dependency_status});
                $("#blocking-tasks<?php echo $modalId; ?>").append(`
                <div id="dependency-task-row-${selectedId}" class="list-group-item mb5 dependency-task-row b-a rounded" style="border-left: 5px solid #F9A52D !important;">
                <a href="#" class="delete-dependency-task<?php echo $modalId;?>" title="Delete" data-fade-out-on-success="#dependency-task-row-${selectedId}" data-dependency-type="blocked_by" data-act="ajax-request" data-action-url="#">
                <div class="float-end"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-16"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div></a><a href="#" data-post-id="${selectedId}" data-modal-lg="1" data-act="ajax-modal" data-title="" data-action-url="#">${selectedText}</a></div>
                `)
            }
            
            else if(dependency_status==2) {
                selectedText=$('#edit-dependency-panel<?php echo $modalId; ?> .select2-chosen').text();
                dependencies.push({id:selectedId,title:selectedText,blocking:dependency_status});
                $("#blocked-by-tasks<?php echo $modalId; ?>").append(`
                <div id="dependency-task-row-${selectedId}" class="list-group-item mb5 dependency-task-row b-a rounded" style="border-left: 5px solid #F9A52D !important;">
                <a href="#" class="delete-dependency-task<?php echo $modalId;?>" title="Delete" data-fade-out-on-success="#dependency-task-row-${selectedId}" data-dependency-type="blocked_by" data-act="ajax-request" data-action-url="#">
                <div class="float-end"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-16"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div></a><a href="#" data-post-id="${selectedId}" data-modal-lg="1" data-act="ajax-modal" data-title="" data-action-url="#">${selectedText}</a></div>
                `);
            }
            // if(!$("#blocking-area").hasClass('hide')) $("#blocking-area").addClass("hide");
            // if(!$("#blocked-by-area").hasClass('hide')) $("#blocked-by-area").addClass("hide")
            // if(!$("#dependency-list-title").hasClass('hide')) $("#dependency-list-title").addClass("hide")
            // if(!$("#edit-dependency-panel").prop('hidden')) $("#edit-dependency-panel").prop("hidden",true)
        })
        // $("#input_cost_item_currency_select").on("change",function(){
        //     $("#cost_item_currency_symbol")[0].selectedIndex=$("#input_cost_item_currency_select")[0].selectedIndex;
        // })
        $(".delete-dependency-task<?php echo $modalId;?>").on("click",function(){
            var deletedIndex=$(this).parent().index();
            dependencies.splice(deletedIndex,1);
        })
    });
    var dependencies=[]
    var dependency_status=0;
    var checklist_items=[];
    var cost_items=[];
    var checklists=0;
    var checklist_complete=0;
    var editing_cost_item=null;
    function save_new_quote(){
        var table=$("#table-costs-item-list<?php echo $modalId; ?>")[0].getElementsByTagName('tbody')[0];
        var newRow = table.insertRow();

        var cell0 = newRow.insertCell(0);
        var cell1 = newRow.insertCell(1);
        var cell2 = newRow.insertCell(2);
        var cell3 = newRow.insertCell(3);

        cell0.innerHTML = $("#quote_name<?php echo $modalId; ?>")[0].value;
        cell1.innerHTML = $("#quote_price<?php echo $modalId; ?>")[0].value;
        cell2.innerHTML = $("#quote_quote<?php echo $modalId; ?>")[0].value;
        cell3.innerHTML = "";
        $("#btn-save-new-quote<?php echo $modalId; ?>")[0].closest("tr").remove();
        $("#btn-add-new-quote-start<?php echo $modalId; ?>").prop("disabled", false);
    }
    function delete_item(index){
        cost_items.splice(index,1);
        $("#table-costs-item-list<?php echo $modalId; ?>")[0].getElementsByTagName('tbody')[0].deleteRow(index);
    }
    function start_edit_cost_item(index){
        editing_cost_item=index;
        $("#editing_cost_item<?php echo $modalId; ?>")[0].value=index;
        if($("#insert-cost-item-panel-new<?php echo $modalId; ?>").prop("hidden")) $("#btn-add-new-quote-start<?php echo $modalId; ?>")[0].click();
        $("#input_cost_item_name<?php echo $modalId; ?>")[0].value=cost_items[index].name;
        $("#input_cost_item_quantity<?php echo $modalId; ?>")[0].value=cost_items[index].quantity;
        $("#input_cost_item_measurement<?php echo $modalId; ?>")[0].value=cost_items[index].measurement;
        $("#input_cost_item_unit_price<?php echo $modalId; ?>")[0].value=cost_items[index].unit_price;
        $("#cost_item_quote_type<?php echo $modalId; ?>")[0].value=cost_items[index].quote_type;
        $("#input_cost_item_currency_select<?php echo $modalId; ?>")[0].value=cost_items[index].currency;
        $("#cost_item_description<?php echo $modalId; ?>")[0].value=cost_items[index].description;
        // $("#cost_item_budget_group<?php 
        // echo $modalId;
         ?>")[0].value=cost_items[index].budget_group;
        $("#cost_item_yard_remarks<?php echo $modalId; ?>")[0].value=cost_items[index].yard_remarks;
    }
    <?php
        if(isset($gotTask)&&$gotTask->dependencies)
        echo 'dependencies=JSON.parse(`'.$gotTask->dependencies.'`);';
    ?>
    <?php
        if(isset($gotChecklistItems)){
            echo 'checklist_items=JSON.parse(`'.json_encode($gotChecklistItems).'`);';
        }
        
    ?>
    <?php
        if(isset($gotTask)&&$gotTask->cost_items)
        echo 'cost_items=JSON.parse(`'.$gotTask->cost_items.'`);';
    ?>
    function delete_checklist_item(element){
        var deleteId=element.getAttribute("item-id");
        checklist_items.splice(checklist_items.findIndex(oneItem=>oneItem.id==deleteId),1)
        checklists--;
        $(".chcklists_count_modal<?php echo $modalId;?>").text(checklists);
        var parentElement = element.parentNode;
        parentElement.parentNode.removeChild(parentElement); 
    }
</script>