<div class="modal-body clearfix" >
    <div class="d-flex" >
    <?php foreach ($project_files as $key => $oneFile) {
        if(is_image_file($oneFile->file_name)){
    ?>
        <a href="#" onclick="insert_image('<?php echo $oneFile->file_name;?>')" ><img src="<?php echo base_url("files/project_files/$project_id/$oneFile->file_name");?>" style="width:7vw;height:8vh;" /></a>
    <?php
    }} ?>
    </div>
</div>
<script>
    $(document).ready(function(){
        var files='<?php echo json_encode($project_files);?>'
        console.log(files)
    })
    function insert_image(file_name){
        fetch(`<?php echo base_url("files/project_files/$project_id/");?>${file_name}`)
        .then(response => response.blob())
        .then(blob => {
            // Convert blob to Data URL
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = () => {
            const dataUrl = reader.result;
            const viewFragment = window.watchdog.editor.data.processor.toView( `<img src="${dataUrl}" />` );
            const modelFragment = window.watchdog.editor.data.toModel( viewFragment );

            window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
            window.modal_insert_chart.closeModal();
            };
        })
        .catch(error => {
            console.error("Error fetching the image:", error);
        });
        
    }
</script>