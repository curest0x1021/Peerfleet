<div id="page-content" class="page-wrapper clearfix">
    <div class="row" >
        <div class="col-md-2" >
            <?php echo view('projects/comparison/tab');?>
        </div>
        <div class="col-md-10" >
            <div class="card" >
                <div class="card-body" >
                    <div class="tab-content" >
                        <div class="tab-pane container active" id="currencies_tab">
                            <?php echo view('projects/comparison/setting_currencies');?>
                        </div>
                        <div class="tab-pane container fade" id="ownership_tab">
                            <?php echo view('projects/comparison/setting_ownership');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
