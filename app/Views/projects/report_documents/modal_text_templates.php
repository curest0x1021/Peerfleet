<div id="ajaxModalContent" >
<div class="modal-body clearfix" id="modal-insert-text" >
    <?php foreach ($text_templates as $key => $template) {
    ?>
        <button class="btn btn-default" onclick="insert_text(<?php echo $key;?>)" ><?php echo $template->title;?></button>
    <?php
    }?>
</div>
</div>
<script>
    var text_templates=<?php echo json_encode($text_templates);?>;
    console.log(text_templates)
    function insert_text(index){
        const viewFragment = window.watchdog.editor.data.processor.toView( text_templates[index].content);
        const modelFragment = window.watchdog.editor.data.toModel( viewFragment );

        window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
        window.modal_insert_text.closeModal();
    }
    $(document).ready(function(){
        window.modal_insert_text=$("#modal-insert-text").appForm({
            closeModalOnSuccess: false,
            // onSuccess: function (result) {
            //     if (window.continueShow) {
            //         console.log(window.responseData)
            //     }else{
            //         window.edit_task_panel.closeModal()
            //     }
            // }
        });
    })
</script>