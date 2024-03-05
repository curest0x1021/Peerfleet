<div class="container" >
    <h3>Currencies</h3>
    <?php
    $currencies=array();
    foreach ($allCostItemCurrencies as $oneCurrency) {
        $currencies[$oneCurrency]=$oneCurrency;
    }
    ?>
    <!-- <div class="card bg-warning" >
        <div class="card-body" >
            <div class="d-flex align-items-center" >
                <i data-feather="alert-triangle" ></i>
                &nbsp;<h5>Missing correct exchanging rates.</h5>
            </div>
            <p>It is crucial to specify the accurate exchange rates that will be utilized to convert the cost provided from the specific yard.</p>
        </div>
    </div> -->
    <div class="card" >
        <div class="card-body" >
            <p><i data-feather="alert-circle" class="icon-16" ></i>Please enter the exchange rates for the currencies used in quotations. peerfleet will use these exchange rates to convert the quotes into your set project currency.</p>
            <div style="min-height:30vh;" >
                <table class="table">
                    <thead>
                        <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Rate</th>
                        <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($allCurrencyRates as $oneRate) {
                        ?>
                        <tr>
                            <td>
                                <p> <?php echo $oneRate->from;?></p>
                            </td>
                            <td><?php echo $oneRate->to;?></td>
                            <td><?php echo $oneRate->rate;?></td>
                            <td>
                                <?php echo modal_anchor(get_uri("projects/modal_edit_currency_rate/".$oneRate->id),'EDIT',array()); ?>
                                | <?php echo js_anchor("DELETE", array('title' => app_lang('delete_project'),"data-bs-toggle"=>"modal", "data-bs-target"=>"#confirmationModal", "class" => "delete", "data-id" => $oneRate->id, "data-action-url" => get_uri("projects/delete"), "data-action" => "delete-confirmation"));?>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex" >
                        <a class="btn btn-ddefault" href="<?php echo get_uri("projects/view/").$project_id;?>" >Cancel</a>
                    <!-- <button class="btn btn-primary" >Add exchange rate</button> -->
                    <div class="flex-grow-1" ></div>
                    <?php echo modal_anchor(get_uri("projects/modal_add_currency_rate/").$project_id,'<button class="btn btn-primary" >Add exchange rate</button>',array()); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

    })
</script>