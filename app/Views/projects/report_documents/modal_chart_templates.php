
<div id="ajaxModalContent" >
<div class="modal-body clearfix" id="modal-insert-chart" >
    <button class="btn btn-default insert-chart-task-status" >Task status</button>
    <button class="btn btn-default insert-chart-project-progress" >Project progress</button>
    <div class="preview"  ></div>
</div>
</div>
<script>
    $(document).ready(function(){
        $(".insert-chart-task-status").on("click",function(){
            $.ajax({
                url:"<?php echo get_uri("projects/chart_task_status/".$project_id);?>",
                method:"GET",
                success:function(response){
                    const virtual_box=document.createElement("div");
                    virtual_box.hidden=false;
                    // virtual_box.style.display="none";
                    
                    virtual_box.innerHTML=response;
                    var code=virtual_box.querySelector("script").innerHTML
                    document.body.querySelector(".preview").appendChild(virtual_box);
                    eval(code)
                    setTimeout(() => {
                        var image_dataURL=window.chart_task_status.toBase64Image();
                        const viewFragment = window.watchdog.editor.data.processor.toView( `<img src="${image_dataURL}" />` );
                        const modelFragment = window.watchdog.editor.data.toModel( viewFragment );

                        window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
                        window.modal_insert_chart.closeModal();
                    }, 500);
                    
                }
            })
        })
        $(".insert-chart-project-progress").on("click",function(){
            $.ajax({
                url:"<?php echo get_uri("projects/chart_project_progress/".$project_id);?>",
                method:"GET",
                success:function(response){
                    const virtual_box=document.createElement("div");
                    virtual_box.hidden=false;
                    // virtual_box.style.display="none";
                    
                    virtual_box.innerHTML=response;
                    var code=virtual_box.querySelector("script").innerHTML
                    document.body.querySelector(".preview").appendChild(virtual_box);
                    eval(code)
                    setTimeout(() => {
                        var image_dataURL=window.chart_project_progress.toBase64Image();
                        const viewFragment = window.watchdog.editor.data.processor.toView( `<img src="${image_dataURL}" />` );
                        const modelFragment = window.watchdog.editor.data.toModel( viewFragment );

                        window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
                        window.modal_insert_chart.closeModal();
                    }, 500);
                    
                }
            })
        })
        window.modal_insert_chart=$("#modal-insert-chart").appForm({
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