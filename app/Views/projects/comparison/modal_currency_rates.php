<div class="modal-body clearfix" >
    <table class="table table-bordered table-currency-rates" >
        <thead>
            <tr>
                <th>Currency</th>
                <th>Rate</th>
                <th><i data-feather="tool" class="icon-16" ></i></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php  
                    $currency_dropdown=array(
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
                    ?>
                    <input class="form-control" id="input_currency_name" />
                </td>
                <td><input class="form-control" type="number" id="input_currency_rate" /></td>
                <td><button class="btn btn-sm btn-default btn-save-currency-rate " ><i class="icon-16" data-feather="save" ></i></button></td>
            </tr>
            <?php foreach ($allRates as $oneRate) {
            ?>
            <tr>
                <td><?php echo $oneRate->name;?></td>
                <td><?php echo $oneRate->rate;?></td>
                <td><button onclick="delete_rate(event)" class="btn btn-sm btn-default" ><i class="icon-16" data-feather="x" ></i></button></td>
            </tr>
            <?php  # code...
            } ?>
        </tbody>
    </table>
</div>
<script>
$(document).ready(function(){
    $("#input_currency_name").select2({
        data:<?php echo json_encode($currency_dropdown);?>
    });
    $(".modal-dialog").removeClass('modal-lg').addClass('modal-sm').addClass('modal-dialog-centered');
    $(".btn-save-currency-rate").on("click",function(){
        var name=$(this).parent().parent().find("#input_currency_name")[0].value;
        var rate=$(this).parent().parent().find("#input_currency_rate")[0].value;
        var tbodyEl=$(this).parent().parent().parent();
        $.ajax({
            url:'<?php echo get_uri('projects/save_currency_rate'); ?>',
            method:"POST",
            data:{
                name:name,
                rate:rate,
                project_id:<?php echo $project_id; ?>
            },
            success:function(response){
                if(JSON.parse(response).success){
                    var newRow=`
                    <tr>
                        <td>${name}</td>
                        <td>${rate}</td>
                        <td><button onclick="delete_rate(event)" class="btn btn-sm btn-default" ><i class="icon-16" data-feather="x" ></i></button></td>
                    </tr>
                    `;
                    tbodyEl.append(newRow);
                }
            }
        })
    })
    
})
function delete_rate(e){
    var trEl=e.target.parentNode.parentNode;
    trEl.parentNode.removeChild(trEl)
}
</script>