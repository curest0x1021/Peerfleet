<div class="modal-body clearfix " >
    <button class="btn btn-default insert-project-cost-overview-table" >Cost overview</button>
    <button class="btn btn-default insert-project-quotes-overview-table" >Quotes overview</button>
    <div class="vbox" ></div>
</div>
<script>
    $(document).ready(function(){
        $(".insert-project-cost-overview-table").on("click",function(){
            $.ajax({
                url:"<?php echo get_uri("projects/cost_overview/".$project_id);?>",
                method:"GET",
                success:function(response){
                    const virtual_box=document.createElement("div");
                    var result= response.replace(/data-bs-toggle="collapse"/g,"");
                    result= result.replace(/class="collapse"/g,"");
                    virtual_box.hidden=true;
                    
                    virtual_box.innerHTML=result;
                    
                    var table_els=virtual_box.querySelectorAll("table");
                    table_els.forEach(element => {
                        element.style.border="1px solid lightgray";
                        element.style.borderCollapse="collapse";
                    });
                    var th_els=virtual_box.querySelectorAll("td");
                    th_els.forEach(element => {
                        element.style.border="1px solid lightgray";
                        element.style.borderCollapse="collapse";
                    });
                    var td_els=virtual_box.querySelectorAll("th");
                    td_els.forEach(element => {
                        element.style.border="1px solid lightgray";
                        element.style.borderCollapse="collapse";
                    });
                    document.body.querySelector(".vbox").appendChild(virtual_box);
                    var code=virtual_box.querySelector("script").innerHTML
                    eval(code)
                    
                    
                    setTimeout(() => {
                        // window.watchdog.editor.insertData(table_code);
                        var table_code=document.body.querySelector(".vbox").querySelector("#table-panel-for-xlsx").innerHTML
                        console.log(table_code)
                        const viewFragment = window.watchdog.editor.data.processor.toView( table_code );
                        const modelFragment = window.watchdog.editor.data.toModel( viewFragment );

                        window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
                    }, 1000);
                    
                    
                }
            })
        })
        $(".insert-project-quotes-overview-table").on("click",function(){
            $.ajax({
                url:"<?php echo get_uri("projects/comparison_tab/".$project_id);?>",
                method:"GET",
                success:function(response){
                    const virtual_box=document.createElement("div");
                    var result= response.replace(/data-bs-toggle="collapse"/g,"");
                    result= result.replace(/class="collapse"/g,"");
                    virtual_box.hidden=true;
                    
                    virtual_box.innerHTML=result;

                    var first_row=virtual_box.querySelector("thead").querySelector("tr");
                    first_row.remove();

                    var table_els=virtual_box.querySelectorAll("table");
                    table_els.forEach(element => {
                        element.style.border="1px solid lightgray";
                        element.style.borderCollapse="collapse";
                    });
                    var th_els=virtual_box.querySelectorAll("td");
                    th_els.forEach(element => {
                        element.style.border="1px solid lightgray";
                        element.style.borderCollapse="collapse";
                    });
                    var td_els=virtual_box.querySelectorAll("th");
                    td_els.forEach(element => {
                        element.style.border="1px solid lightgray";
                        element.style.borderCollapse="collapse";
                    });

                    var dropdowns=virtual_box.querySelectorAll(".dropdown");
                    dropdowns.forEach(dropdown => {
                        dropdown.remove();
                    });
                    
                    
                    document.body.querySelector(".vbox").appendChild(virtual_box);
                    var code=virtual_box.querySelector("script").innerHTML
                    eval(code)
                    
                    
                    setTimeout(() => {
                        // window.watchdog.editor.insertData(table_code);
                        var table_code=document.body.querySelector(".vbox").querySelector("#quotes-overview-table-panel").innerHTML
                        console.log(table_code)
                        const viewFragment = window.watchdog.editor.data.processor.toView( table_code );
                        const modelFragment = window.watchdog.editor.data.toModel( viewFragment );

                        window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
                    }, 1000);
                    
                    
                }
            })
        })
    })
</script>