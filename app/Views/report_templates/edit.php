<link type="text/css" href="<?php echo base_url("assets/ckeditor5-document/");?>sample/css/sample.css" rel="stylesheet" media="screen" />
<div id="page-content" class="page-wrapper clearfix grid-button">
    <div class="card" >
        <div class="card-body" >
            <main>
                <div class="centered">
                    <div class="document-editor">
                        <div class="toolbar-container"></div>
                        <div class="content-container">
                            <div id="editor">
                                
                            </div>
                        </div>
                    </div>

                    
                </div>
            </main>
        </div>
        <div class="card-footer" >
            <button class="btn btn-default" ><i data-feather="x" class="icon-16" ></i>Cancel</button>
            <button class="btn btn-primary" ><i data-feather="check-circle" class="icon-16" ></i>save</button>
        </div>
    </div>
</div>


<script src="<?php echo base_url("assets/ckeditor5-document/");?>ckeditor.js"></script>

<script>
	DecoupledEditor
		.create( document.querySelector( '#editor' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			const toolbarContainer = document.querySelector( 'main .toolbar-container' );

			toolbarContainer.prepend( editor.ui.view.toolbar.element );

			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>

