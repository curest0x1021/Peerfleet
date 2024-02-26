<div class="modal-body clearfix">
<?php echo form_open(get_uri("tasks/save_variation_order"), array()); ?>
<?php echo form_close()?>
    <div>
        <p>
            Are you sure you want to create a variation order for this work order?
            You can change the cost and start/completion date and you must add notes explaining the work order.
            Try to explain what the change is about and what the change is. For the record, all previous data is stored on Peerfleet.
        </p>
        <div class="form-group" >
            <label>New, additional name:</label>
            <input
            name="order_name"
            id="order_name"
            class="form-control"
            />
        </div>
        <div class="form-group" >
            <label>New, additional cost:</label>
            <input
            name="order_cost"
            id="order_cost"
            class="form-control"
            />
        </div>
        <div class="row" >
            <div class="col-md-3" >
                <div class="form-group" >
                    <label>New start date:</label>
                    <input
                    name="order_start_date"
                    id="order_start_date"
                    class="form-control"
                    placeholder= "DD.MM.YYYY"
                    />
                </div>
            </div>
            <div class="col-md-3" >
                <div class="form-group" >
                    <label>New finish date:</label>
                    <input
                    name="order_finish_date"
                    id="order_finish_date"
                    class="form-control"
                    placeholder= "DD.MM.YYYY"
                    />
                </div>
            </div>
        </div>
        <div class="form-group" >
            <label>Notes:</label>
            <textarea
            name="order_notes"
            id="order_notes"
            class="form-control"
            style="min-height:15vh;"
            ></textarea>
        </div>
        <div class="form-group" >
            <label>Add uploads:</label>
            <div class="select-upload-file d-flex align-items-center justify-content-center" style="min-height:15vh;border:1px dashed lightgray;border-radius:10px;" >
                <div class="text-center" >
                    <i  data-feather="image" ></i>
                    <p>Click here to select a file or drag and drop.</p>
                </div>
            </div>
            <input class="input-file" type="file" hidden />
        </div>
    </div>
</div>
<div class="modal-footer" >
    <div class="d-flex" ></div>
    <button class="btn btn-default" data-bs-dismiss="modal" >Cancel</button>
    <div class="flex-grow-1" ></div>
    <button class="btn btn-success btn-save-variation-order" data-bs-dismiss="modal" >Save</button>
</div>
<script>
    $(document).ready(function(){
        $(".select-upload-file").on("click",function(){
            $(this).parent().find(".input-file").click();
        });
        setDatePicker("#order_start_date");
        setDatePicker("#order_finish_date");
        $(".btn-save-variation-order").on("click",function(){
            var order_name=$(this).parent().parent().find("#order_name")[0].value;
            var order_cost=$(this).parent().parent().find("#order_cost")[0].value;
            var order_notes=$(this).parent().parent().find("#order_notes")[0].value;
            var order_start_date=$(this).parent().parent().find("#order_start_date")[0].value;
            var order_finish_date=$(this).parent().parent().find("#order_finish_date")[0].value;
            var myForm=new FormData();
            myForm.append("rise_csrf_token",$("[name=rise_csrf_token]")[0].value);
            myForm.append("task_id",'<?php echo $task_id;?>');
            myForm.append("name",order_name);
            myForm.append("cost",order_cost);
            myForm.append("notes",order_notes);
            myForm.append("start_date",order_start_date);
            myForm.append("finish_date",order_finish_date);
            $.ajax({
                url:'<?php echo get_uri('tasks/save_variation_order');?>',
                method:"POST",
                data:myForm,
                processData: false,
                contentType: false, 
                success:function(response){
                    if(JSON.parse(response).success){
                        var new_row=`
                            <tr>
                            <td>${order_name}</td>
                            <td>${order_cost}</td>
                            <td>${order_start_date}</td>
                            <td>${order_finish_date}</td>
                            <td><input hidden value="${JSON.parse(response).save_id}"/><button onclick="delete_variation_order(event)" class="btn btn-sm btn-default delete-variation-order" ><i class="icon-16" data-feather="x" ></i></button></td>
                            </tr>
                        `;
                        $(".table-variation-orders tbody").append(new_row);
                    }
                    
                }
            })
        })
    })
</script>