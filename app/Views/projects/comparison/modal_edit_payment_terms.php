<div id="ajaxModalContent" >
<div class="modal-body" id="panel-edit-payment-terms">
    <h3>Edit payment terms of <?php echo $shipyard_info->title;?></h3>
    <?php echo form_open(get_uri("projects/edit_payment_terms"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
    <?php echo form_close();?>
    <div class="form-group" >
        <label>Payment before departure</label>
        <input type="number" class="form-control payment_before_departure" />
    </div>
    <div class="form-group" >
        <label>Payment within 30 days</label>
        <input type="number" class="form-control payment_within_30" />
    </div>
    <div class="form-group" >
        <label>Payment within 60 days</label>
        <input type="number" class="form-control payment_within_60" />
    </div>
    <div class="form-group" >
        <label>Payment within 90 days</label>
        <input type="number" class="form-control payment_within_90" />
    </div>
</div>

    <!-- Modal footer -->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary save_payment_terms" >Save</button>
</div>
</div>
<script>
    $(document).ready(function(){
        $(".save_payment_terms").on("click",function(){
            var payment_before_departure=$(".payment_before_departure")[0].value;
            var payment_within_30=$(".payment_within_30")[0].value;
            var payment_within_60=$(".payment_within_60")[0].value;
            var payment_within_90=$(".payment_within_90")[0].value;
            var rise_csrf_token = $('[name="rise_csrf_token"]').val();
            $.ajax({
                url:'<?php echo get_uri('projects/save_payment_terms');?>',
                method:"POST",
                data:{
                    shipyard:<?php echo $shipyard_info->id;?>,
                    payment_before_departure,
                    payment_within_30,
                    payment_within_60,
                    payment_within_90,
                    rise_csrf_token
                },
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
                        window.panel_edit_payment_terms.closeModal()
                        window.location.reload();
                    }
                }
            })
        });
        window.panel_edit_payment_terms=$("#panel-edit-payment-terms").appForm({
            closeModalOnSuccess:false
        })
    })
</script>