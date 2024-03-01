<div class="container" >
    <h1>Currencies</h1>
    <div class="card bg-warning" >
        <div class="card-body" >
            <div class="d-flex align-items-center" >
                <i data-feather="alert-triangle" ></i>
                &nbsp;<h5>Missing correct exchanging rates.</h5>
            </div>
            <p>It is crucial to specify the accurate exchange rates that will be utilized to convert the cost provided from the specific yard.</p>
        </div>
    </div>
    <table class="table table-hover tabel-bordered">
        <thead>
            <tr>
            <th>From</th>
            <th>To</th>
            <th>Rate</th>
            <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <p><i data-feather="alert-triangle" ></i> United Arab Emirates Dirham (AED)</p>
                </td>
                <td>United States Dollar (USD)</td>
                <td>1.0</td>
                <td><a href="#" >EDIT</a> | <a href="#" >DELETE</a></td>
            </tr>
            <tr>
                <td>
                    <p><i data-feather="alert-triangle" ></i> Afghan Afghani (AFN)</p>
                </td>
                <td>United States Dollar (USD)</td>
                <td>1.0</td>
                <td><a href="#" >EDIT</a> | <a href="#" >DELETE</a></td>
            </tr>
            <?php
            foreach ($allCurrencyRates as $oneRate) {
            ?>
            <tr>
                <td>
                    <p><i data-feather="alert-triangle" ></i> <?php echo $oneRate->from;?></p>
                </td>
                <td><?php echo $oneRate->to;?></td>
                <td><?php echo $oneRate->rate;?></td>
                <td><a href="#" >EDIT</a> | <a href="#" >DELETE</a></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <div class="row" >
        <div class="col-md-3" >
            <!-- <button class="btn btn-primary" >Add exchange rate</button> -->
            <?php echo modal_anchor(get_uri("projects/modal_add_currency_rate/").$project_id,'<button class="btn btn-primary" >Add exchange rate</button>',array()); ?>
        </div>
    </div>
</div>