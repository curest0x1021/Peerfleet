<div id="ajaxModalContent" >
<div class="modal-body clearfix" id="add-variation-order" >
<?php echo form_open(get_uri("tasks/save_variation_order"), array()); ?>
<?php echo form_close()?>
<div id="link-of-new-view" class="hide">
    <?php
    echo modal_anchor(get_uri("tasks/view"), "", array("data-modal-lg" => "1"));
    ?>
</div>
    <div>
        <p>
        Please note: With this process, you change the total cost of this task and a subtask will be created with its own start date and deadline. Within this process, you have to explain the reasons for the variation order. Please provide a clear explanation of the variation order and the reason for it.
        </p>
        <div class="form-group" >
            <label>Variation order name:</label>
            <input
            name="order_name"
            id="order_name"
            class="form-control"
            />
        </div>
        <!-- <div class="form-group" >
            <label>Additional cost:</label>
            <input
            name="order_cost"
            id="order_cost"
            class="form-control"
            />
        </div> -->
        <div class="col-md-6" >
            <div class="form-group" >
                <label>Additional cost:</label>
                <div class="input-group mb-3" style="border:1px solid lightgray;border-radius:5px">
                    <input value="0.00" class="form-control" id="order_cost" type="number" />
                    <?php
                    $order_currency_dropdown=array(
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
                        "id" => "order_currency",
                        "name" => "order_currency",
                        "value" => isset($project_info->currency)?$project_info->currency:"USD",
                        "class" => "form-control",
                        "data-rule-required" => true,
                        "style"=>"border:1px solid lightgray;",
                        "data-msg-required" => app_lang("field_required"),
                        "autocomplete" => "off"
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-3" >
                <div class="form-group" >
                    <label>Start date:</label>
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
                    <label>Deadline:</label>
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
    <button class="btn btn-success btn-save-variation-order"  >Save</button>
</div>
</div>
<script>
    $(document).ready(function(){
        $(".select-upload-file").on("click",function(){
            $(this).parent().find(".input-file").click();
        });
        $("#order_currency").select2({
            data: <?php echo (json_encode($order_currency_dropdown)); ?>
        });
        setDatePicker("#order_start_date");
        setDatePicker("#order_finish_date");
        $(".btn-save-variation-order").on("click",function(){
            var order_name=$(this).parent().parent().find("#order_name")[0].value;
            var order_cost=$(this).parent().parent().find("#order_cost")[0].value;
            var order_notes=$(this).parent().parent().find("#order_notes")[0].value;
            var order_start_date=$(this).parent().parent().find("#order_start_date")[0].value;
            var order_finish_date=$(this).parent().parent().find("#order_finish_date")[0].value;
            var order_currency=$(this).parent().parent().find("#order_currency")[0].value;
            var myForm=new FormData();
            myForm.append("rise_csrf_token",$("[name=rise_csrf_token]")[0].value);
            myForm.append("task_id",'<?php echo $task_id;?>');
            myForm.append("name",order_name);
            myForm.append("cost",order_cost);
            myForm.append("notes",order_notes);
            myForm.append("start_date",order_start_date);
            myForm.append("finish_date",order_finish_date);
            myForm.append("currency",order_currency);
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
                            <td>${order_currency} ${order_cost}</td>
                            <td>${order_start_date}</td>
                            <td>${order_finish_date}</td>
                            <td><input hidden value="${JSON.parse(response).save_id}"/><button onclick="delete_variation_order(event)" class="btn btn-sm btn-default delete-variation-order" ><i class="icon-16" data-feather="x" ></i></button></td>
                            </tr>
                        `;
                        $(".table-variation-orders tbody").append(new_row);
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
                        if(window.modal_opened==1){
                            window.modal_opened=null;
                            var $taskViewLink = $("#link-of-new-view").find("a");
                            $taskViewLink.attr("data-action-url", "<?php echo get_uri("tasks/view"); ?>");
                            // $taskViewLink.attr("data-title", taskShowText + " #" + JSON.parse(response).saved_id);
                            $taskViewLink.attr("data-post-id", <?php echo $task_id;?>);
                            $taskViewLink.trigger("click");
                        }else{
                            window.modal_opened=null;
                            window.add_variation_order.closeModal()
                            window.location.reload();
                        }
                        
                    }
                    
                }
            })
        })
        window.add_variation_order=$("#add-variation-order").appForm({
            closeModalOnSuccess: false,
            
        });
    })
</script>