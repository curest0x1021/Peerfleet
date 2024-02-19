<div class="page-content project-details-view clearfix">
    <div class="container">
        <h2>New Yard Candidate</h2>
        <div class="divider" ></div>
        <div class="card" >
            <div class="card-body" >
                <p>Create a yard candidate that will provide you quotes based on the work orders in your project.</p>
                <form action="#" method="POST" >
                    <div class="form-group" >
                        <label>Yard:</label>
                        <?php
                        $yards_dropdown=array();
                        foreach ($allYardTitles as $key=>$oneYardTitle) {
                            $yards_dropdown[]=array(
                                "id"=>$allYardIds[$key],
                                "text"=>$allYardTitles[$key],
                            );
                        }
                        ?>
                        <input
                            name="yard"
                            id="yard"
                            class="form-control"
                            style="border:1px solid lightgray;"
                            required
                        />
                        <p>If you can’t find the yard in the list, please send an email to support@maindeck.io and we will add it to the list.</p>
                    </div>
                    <div class="form-group d-flex" >
                        <div class="flex-grow-1" >
                            <button type="button"  class="btn btn-default" style="float:right;margin-right:10px"  >Cancel</button>
                        </div>
                        <a href="<?php echo get_uri('projects/yard_settings/12');?>" type="submit" class="btn btn-success"  >Save</a>
                    </div>
                </form>
                <div class="divider" ></div>
                <p>
                    <i data-feather="info" ></i>
                    If you can’t find the yard in the list, please send an email to support@maindeck.io and we will add it to the list.
                </p>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $("#yard").select2({
        data:<?php echo json_encode($yards_dropdown);?>
    })
})
</script>