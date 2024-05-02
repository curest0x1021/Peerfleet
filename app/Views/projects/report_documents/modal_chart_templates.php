
<div id="ajaxModalContent" >
<div class="modal-body clearfix" id="modal-insert-chart" >
    <button class="btn btn-default insert-chart-task-status" >Task status</button>
    <button class="btn btn-default insert-chart-project-progress" >Project progress</button>
    <div style="width:0px;height:0px;overflow:hidden;" >
        <div class="preview" ></div>
    </div>
</div>
</div>
<script src="<?php echo base_url("assets/js/html2canvas.min.js");?>" ></script>
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
                //url:"<?php// echo get_uri("projects/chart_project_progress/".$project_id);?>",
                url:"<?php echo get_uri("projects/overview/".$project_id);?>",
                method:"GET",
                success:function(response){
                    const virtual_box=document.createElement("div");
                    const preview_box=document.body.querySelector(".preview");
                    preview_box.style.width="100vw";
                    preview_box.style.height="200vh"
                    preview_box.style.overflowX="hidden"
                    preview_box.style.overflowY="hidden"
                    // virtual_box.hidden=true;
                    // virtual_box.style.display="none";
                    
                    virtual_box.innerHTML=response;
                    var code=virtual_box.querySelector("script").innerHTML
                    preview_box.appendChild(virtual_box);
                    eval(code)
                    setTimeout(() => {
                        //var image_dataURL=window.chart_project_progress.toBase64Image();


                        var element = document.getElementById('card-project-progress-chart');
                        element.style.height="40vh;"
                        html2canvas(element).then(canvas=>{
                            // console.log(canvas)
                            // canvas.width = element.width;
                            // canvas.height = element.height;
                            const dataURL=canvas.toDataURL();
                            virtual_box.hidden=true;
                            const viewFragment = window.watchdog.editor.data.processor.toView( `<img src="${dataURL}" />` );
                            const modelFragment = window.watchdog.editor.data.toModel( viewFragment );
                            window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
                            window.modal_insert_chart.closeModal();
                        })
                        // var canvas = document.createElement('canvas');
                        // canvas.width = element.offsetWidth;
                        // canvas.height = element.offsetHeight;

                        // // Get the canvas context
                        // var context = canvas.getContext('2d');

                        // // Draw the div content onto the canvas
                        // context.drawWindow(window, element.offsetLeft, element.offsetTop, element.offsetWidth, element.offsetHeight, 'rgb(255,255,255)');

                        // // Convert the canvas to a data URL representing a PNG image
                        // var dataURL = canvas.toDataURL('image/png');

                        
                    }, 800);
                    
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