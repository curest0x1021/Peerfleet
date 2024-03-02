<div id="ajaxModalContent" >
<div class="modal-body clearfix" id="add-currency-rate-modal" >
    <!-- <div class="card" > -->
        <!-- <div class="card-header" > -->
            <h3>
                Edit exchange rate from <b><?php echo $rate_info->from?></b> to <b><?php echo $rate_info->to?></b>
            </h3>
        <!-- </div> -->
        <!-- <div class="card-body" > -->
            <div class="row" >
                <div class="col-md-4" >
                    <div class="form-group" >
                        <label>From:</label>
                        <input
                        name="input_from_currency"
                        id="input_from_currency"
                        class="form-control"
                        value="<?php echo $rate_info->from;?>"
                        readonly
                        />
                    </div>
                    <div class="form-group" >
                        <label>To:</label>
                        <input
                        name="input_to_currency"
                        id="input_to_currency"
                        class="form-control currency_dropdown"
                        value="<?php echo $rate_info->to;?>"
                        readonly
                        />
                    </div>
                    <div class="form-group" >
                        <label>Rate:</label>
                        <input
                        name="input_rate"
                        id="input_rate"
                        class="form-control"
                        type="number"
                        value="<?php echo $rate_info->rate;?>"
                        step="0.01"
                        />
                    </div>
                </div>
            </div>
        <!-- </div> -->
        <!-- <div class="card-footer" > -->
            <div class="d-flex align-items-center" >
                <button class="btn btn-default" >Cancel</button>
                <div class="flex-grow-1" ></div>
                <button id="btn-save-currency-rate" class="btn btn-primary " >Save</button>
            </div>
        <!-- </div> -->
    <!-- </div> -->
</div>
</div>
<script>
    $(document).ready(function(){
        $(".modal-dialog").addClass('modal-xl').addClass('modal-dialog-centered');
        $("#btn-save-currency-rate").on("click",function(){
            var from=$("#input_from_currency")[0].value;
            var to=$("#input_to_currency")[0].value;
            var rate=$("#input_rate")[0].value;
            if(!rate) return;
            $.ajax({
                url:'<?php echo get_uri("projects/edit_currency_rate");?>',
                method:"POST",
                data:{
                    id:<?php echo $rate_info->id;?>,
                    rate:rate
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
                        window.add_currency_rate_panel.closeModal();
                        window.location.reload();
                    }
                    
                }
            })
            
        })
        window.add_currency_rate_panel=$("#add-currency-rate-modal").appForm({
            closeModalOnSuccess: false,
        })
    })
</script>
