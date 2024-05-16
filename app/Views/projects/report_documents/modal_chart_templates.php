
<div id="ajaxModalContent" >
<div class="modal-body clearfix" id="modal-insert-chart" >
    <button class="btn btn-default insert-chart-task-status" >Task status</button>
    <button class="btn btn-default insert-chart-project-progress" >Project progress</button>
    <button class="btn btn-default insert-chart-all-tasks-overview" >All tasks overview</button>
    <button class="btn btn-default insert-chart-my-tasks-overview" >My tasks overview</button>
    <div style="overflow:hidden;" >
        <div class="preview" ></div>
        <iframe id="iframe_box" ></iframe>
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
                url:"<?php echo get_uri("projects/overview/".$project_id);?>",
                method:"GET",
                success:function(response){
                    const virtual_box=document.createElement("div");
                    const preview_box=document.body.querySelector(".preview");
                    preview_box.style.width="100vw";
                    preview_box.style.height="200vh"
                    preview_box.style.overflowX="hidden"
                    preview_box.style.overflowY="hidden"
                    
                    virtual_box.innerHTML=response;
                    var code=virtual_box.querySelector("script").innerHTML
                    preview_box.appendChild(virtual_box);
                    eval(code)
                    setTimeout(() => {


                        var element = document.getElementById('card-project-progress-chart');
                        element.style.height="40vh;"
                        html2canvas(element).then(canvas=>{
                            const dataURL=canvas.toDataURL();
                            virtual_box.hidden=true;
                            const viewFragment = window.watchdog.editor.data.processor.toView( `<img src="${dataURL}" />` );
                            const modelFragment = window.watchdog.editor.data.toModel( viewFragment );
                            window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
                            window.modal_insert_chart.closeModal();
                        })

                        
                    }, 800);
                    
                }
            })
        })
        $(".insert-chart-all-tasks-overview").on("click",function(){
            const virtual_box=document.createElement("div");
            const preview_box=document.body.querySelector(".preview");
            var iframe_box=document.getElementById("iframe_box");
            preview_box.appendChild(iframe_box);
            iframe_box.style.height="90vh";
            iframe_box.style.width="30vw";
            iframe_box.style.overflow="hidden";
            iframe_box.src="<?php echo get_uri("projects/tasks_overview_chart/all_tasks_overview");?>";
            console.log(iframe_box)
            
            setTimeout(() => {
                var iframe_document=iframe_box.contentDocument || iframe_box.contentWindow.document;
                var element = iframe_document.getElementById('card-tasks-overview-chart');
                console.log(element)
                html2canvas(element).then(canvas=>{
                    console.log(canvas)
                    const dataURL=canvas.toDataURL();
                    // virtual_box.hidden=true;
                    const viewFragment = window.watchdog.editor.data.processor.toView( `<img src="${dataURL}" />` );
                    const modelFragment = window.watchdog.editor.data.toModel( viewFragment );
                    window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
                    window.modal_insert_chart.closeModal();
                })
            }, 3000);
        })
        $(".insert-chart-my-tasks-overview").on("click",function(){
            const virtual_box=document.createElement("div");
            const preview_box=document.body.querySelector(".preview");
            var iframe_box=document.getElementById("iframe_box");
            preview_box.appendChild(iframe_box);
            iframe_box.style.height="90vh";
            iframe_box.style.width="30vw";
            iframe_box.style.overflow="hidden";
            iframe_box.src="<?php echo get_uri("projects/tasks_overview_chart/my_tasks_overview");?>";
            console.log(iframe_box)
            
            setTimeout(() => {
                var iframe_document=iframe_box.contentDocument || iframe_box.contentWindow.document;
                var element = iframe_document.getElementById('card-tasks-overview-chart');
                console.log(element)
                html2canvas(element).then(canvas=>{
                    console.log(canvas)
                    const dataURL=canvas.toDataURL();
                    // virtual_box.hidden=true;
                    const viewFragment = window.watchdog.editor.data.processor.toView( `<img src="${dataURL}" />` );
                    const modelFragment = window.watchdog.editor.data.toModel( viewFragment );
                    window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
                    window.modal_insert_chart.closeModal();
                })
            }, 3000);
        })
        window.modal_insert_chart=$("#modal-insert-chart").appForm({
            closeModalOnSuccess: false,
        });
    })
</script>