<div class="modal-body clearfix" >
    <div class="form-group" >
        <label>Corrective Action : </label>
        <?php
        $corrective_action_dropdown=array(
            array("id"=>"Arrange service","text"=>"Arrange service"),
            array("id"=>"Guatantee claim","text"=>"Guatantee claim"),
            array("id"=>"Reconditioning / Redelivery","text"=>"Reconditioning / Redelivery"),
            array("id"=>"Repair by crew","text"=>"Repair by crew"),
            array("id"=>"Repair on dry dock","text"=>"Repair on dry dock"),
            array("id"=>"Request maker information","text"=>"Request maker information"),
            array("id"=>"Supply spare","text"=>"Supply spare"),
            array("id"=>"Support","text"=>"Support"),
        );
        ?>
        <input
        class="form-control corrective-action"
        name="corrective_action"
        id="corrective_action"

        />
    </div>
    <p>The following processes can be linked to this corrective action.</p>
    <div class="form-group" >
        <label for="remark" >Remark : </label>
        <textarea
        class="form-control remark"
        id="remark"
        name="remakr"
        placeholder="Enter..."
        style="height:20vh;"
        >

        </textarea>
    </div>
</div>
<div class="modal-footer" >
    <button type="button" class="btn btn-default cancel-upload" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
</div>
<script>
    $(document).ready(function(){
        $(".corrective-action").select2({
            data: <?php echo (json_encode($corrective_action_dropdown)); ?>
        });
    })
</script>