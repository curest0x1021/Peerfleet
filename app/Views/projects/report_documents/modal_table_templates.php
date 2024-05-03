<div id="ajaxModalContent" >
<div class="modal-body clearfix " id="modal-insert-table" >
    <button class="btn btn-default insert-project-cost-overview-table" >Cost overview</button>
    <button class="btn btn-default insert-project-quotes-overview-table" >Quotes overview</button>
    <button class="btn btn-default insert-completion-dates-table" >Completion dates</button>
    <button class="btn btn-default insert-tasks-list-table" >Tasks list</button>
    <div class="vbox" ></div>
</div>
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
                        const viewFragment = window.watchdog.editor.data.processor.toView( table_code );
                        const modelFragment = window.watchdog.editor.data.toModel( viewFragment );

                        window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
                        window.modal_insert_table.closeModal();
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
                        window.modal_insert_table.closeModal();
                    }, 1000);
                    
                    
                }
            })
        });
        $(".insert-completion-dates-table").on("click",function(){
            $.ajax({
                url:"<?php echo get_uri("projects/get_project_info/".$project_id);?>",
                method:"GET",
                success:function(response){
                    console.log(response)
                    var contractual_delivery_date=new Date(JSON.parse(response).contractual_delivery_date);
                    contractual_delivery_date=JSON.parse(response).contractual_delivery_date?contractual_delivery_date.toLocaleDateString(undefined, { dateStyle: 'short' }):"";
                    var yard_estimated_completion_date=new Date(JSON.parse(response).yard_estimated_completion_date);
                    yard_estimated_completion_date=JSON.parse(response).yard_estimated_completion_date?yard_estimated_completion_date.toLocaleDateString(undefined, { dateStyle: 'short' }):"";
                    var own_estimated_completion_date=new Date(JSON.parse(response).deadline);
                    own_estimated_completion_date=JSON.parse(response).deadline?own_estimated_completion_date.toLocaleDateString(undefined, { dateStyle: 'short' }):"";
                    // var own_estimated_completion_date=new Date(JSON.parse(response).own_estimated_completion_date);
                    // own_estimated_completion_date=own_estimated_completion_date.toLocaleDateString(undefined, { dateStyle: 'short' });
                    var actual_completion_date=new Date(JSON.parse(response).actual_completion_date);
                    actual_completion_date=JSON.parse(response).actual_completion_date?actual_completion_date.toLocaleDateString(undefined, { dateStyle: 'short' }):"";
                    var table_code=`
                    
                    <table>
                        <caption>Completion dates<caption>
                        <tbody>
                            <tr>
                                <td>Contractual delivery date</td>
                                <td>${contractual_delivery_date}</td>
                            </tr>
                            <tr>
                                <td>Yard's estimated completion date</td>
                                <td>${yard_estimated_completion_date}</td>
                            </tr>
                            <tr>
                                <td>Own estimated completion date</td>
                                <td>${own_estimated_completion_date}</td>
                            </tr>
                            <tr>
                                <td>Actual completion date</td>
                                <td>${actual_completion_date}</td>
                            </tr>
                        </tbody>
                    </table>
                    `;
                        const viewFragment = window.watchdog.editor.data.processor.toView( table_code );
                        const modelFragment = window.watchdog.editor.data.toModel( viewFragment );

                        window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
                        window.modal_insert_table.closeModal();                    
                    
                }
            })
        });
        $(".insert-tasks-list-table").on("click",function(){
            $.ajax({
                url:"<?php echo get_uri("projects/tasks_list/".$project_id);?>",
                method:"GET",
                success:function(response){
                    
                    var tasks=JSON.parse(response).tasks;
                    console.log(tasks)
                    var table_code=`
                    
                    <table>
                        <caption>Tasks list<caption>
                        <thead>
                            <tr>
                                <th>DLN</th>
                                <th>Title</th>
                            </tr>
                        </thead>
                        <tbody>`;

                            
                    tasks.forEach(task => {
                        table_code+= `
                            <tr>
                                <td>${task.dock_list_number?task.dock_list_number:""}</td>
                                <td>${task.title}</td>
                            </tr>
                        `
                    })
                       table_code+= `</tbody>
                    </table>
                    `;
                        const viewFragment = window.watchdog.editor.data.processor.toView( table_code );
                        const modelFragment = window.watchdog.editor.data.toModel( viewFragment );

                        window.watchdog.editor.model.insertContent( modelFragment,window.watchdog.editor.model.document.selection.getFirstPosition());
                        window.modal_insert_table.closeModal();                    
                    
                }
            })
        });
        window.modal_insert_table=$("#modal-insert-table").appForm({
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