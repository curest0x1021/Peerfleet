<div id="ajaxModalContent" >
<div class="modal-body clearfix" id="apply_template_panel" >
    <div class="row" >
    <?php echo form_open(get_uri("tasks/apply_libraries"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?><?php echo form_close();?>
        <div class="col-md-1 d-flex align-items-center" >
            <div class="form-check" >
                <input  class="form-check-input  input-check-all-libraries" type="checkbox" />
            </div>
        </div>
        <div class="col-md-5" >
            <h4>Work order</h4>
        </div>
        <div class="col-md-3" >
            <h4>To be executed by</h4>
        </div>
    </div>
    <?php
    foreach ($allTaskLibraries as $oneLibrary) {
    ?>
        
        <div class="row" >
            <div class="col-md-1 d-flex align-items-center" >
                <div class="form-check" >
                    <input data-library-id="<?php echo $oneLibrary->id;?>" class="form-check-input input-check-library" type="checkbox" />
                </div>
            </div>
            <div class="col-md-5" >
                <div data-bs-toggle="collapse" data-bs-target="#library-<?php echo $oneLibrary->id;?>" >
                    <div class="d-flex align-items-center" >
                        <i data-feather="chevron-down" class="collapse-arrow icon-16 "></i>
                        <div>
                            <h4><?php echo $oneLibrary->title;?></h4>
                            <p><?php echo $oneLibrary->category; ?> <?php echo $oneLibrary->dock_list_number; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-center" >
                <span class="badge rounded-pill bg-secondary" ><?php echo $oneLibrary->supplier;?></span>
            </div>
        </div>
        <div class="collapse" id="library-<?php echo $oneLibrary->id;?>" >
            <div class="card" >
                <div class="card-body" >
                    <h5><?php echo $oneLibrary->title;?></h5>
                </div>
            </div>
            <div class="card" >
                <div class="card-header" >
                    <h5>Description<h5>
                </div>
                <div class="card-body" >
                    <?php echo $oneLibrary->description;?>
                </div>
            </div>
            <div class="row" >
                <div class="col-md-6" >
                    <div class="card" >
                        <div class="card-header" >Standard cost lines</div>
                        <div class="card-body" >
                            <table class="table" >
                                <thead>
                                    <tr>
                                        <th>Cost item name</th>
                                        <th>Quote type and quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $cost_items=json_decode($oneLibrary->reference_drawing);
                                        foreach ($cost_items as $oneItem) {
                                            # code...
                                        
                                    ?>
                                        <tr>
                                            <td><?php echo $oneItem->name; ?></td>
                                            <td><?php echo $oneItem->unit_price*$oneItem->quantity; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" >
                    <div class="card" >
                        <div class="card-header" >
                            Tags
                        </div>
                        <div class="card-body" >
                            Executed by
                        </div>
                        <div class="card-footer" >
                            <?php echo $oneLibrary->supplier;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<div class="modal-footer" >
    <div class="d-flex" >
        <button data-bs-dismiss="modal" class="btn btn-default" >
            Cancel
        </button>
        <div class="flex-grow-1" ></div>
        <button class="btn btn-primary btn-apply-libraries" >
            Save
        </button>
    </div>
</div>
</div>
<script>
    var selected_libraries=[];
    $(document).ready(function(){
        $(".input-check-all-libraries").change(function(){
            if($(this).is(":checked")){
                console.log($(".input-check-library"))
                $(".input-check-library").prop("checked", true);
                selected_libraries=[];
                for(var oneEl of $(".input-check-library")){
                    selected_libraries.push(oneEl.getAttribute('data-library-id'));
                }
                console.log(selected_libraries)

            }
                
            else{
                // for(var oneEl of $(".input-check-library")){
                //     var indexToDel=selected_libraries.indexOf(oneEl.getAttribute('data-library-id'));
                //     selected_libraries.splice(indexToDel,1);
                // }
                selected_libraries=[];
                console.log(selected_libraries)
                $(".input-check-library").prop("checked", false);
            }
        })
        $(".input-check-library").change(function(){
            if(!$(this).is(":checked")){
                $(".input-check-all-libraries").prop("checked",false);
                var indexToDel=selected_libraries.indexOf($(this).attr('data-library-id'));
                selected_libraries.splice(indexToDel,1);
                console.log(selected_libraries)
            }else{
                selected_libraries.push($(this).attr("data-library-id"));
                console.log(selected_libraries)
            }
        })
        $(".btn-apply-libraries").on("click",function(){
            if(selected_libraries.length==0) return;
            var rise_csrf_token = $('[name="rise_csrf_token"]').val();
            $.ajax({
                url:'<?php echo get_uri('tasks/apply_libraries');?>',
                method:"POST",
                data:{selected_libraries,project_id:<?php echo $project_id;?>,rise_csrf_token},
                success:function(response){
                    if(JSON.parse(response).success){
                        $maskTarget=$("#ajaxModalContent").find(".modal-body");
                        var padding = $maskTarget.height() - 80;
                        if (padding > 0) {
                            padding = Math.floor(padding / 2);
                        }
                        $maskTarget.after("<div class='modal-mask'><div class='circle-loader'></div></div>");
                        //check scrollbar
                        var height = $maskTarget.outerHeight();
                        $('.modal-mask').css({"width": $maskTarget.width() + 22 + "px", "height": height + "px", "padding-top": padding + "px"});
                        $maskTarget.closest('.modal-dialog').find('[type="submit"]').attr('disabled', 'disabled');
                        $maskTarget.addClass("hide");
                        window.apply_template_modal.closeModal();
                        window.location.reload()
                    }
                }
            })
        })
        window.apply_template_modal=$("#apply_template_modal").appForm({
            closeModalOnSuccess: false,
        })
    });
</script>