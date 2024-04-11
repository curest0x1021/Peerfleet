<script>
const watchdog = new CKSource.EditorWatchdog();

window.watchdog = watchdog;

watchdog.setCreator( ( element, config ) => {
	return CKSource.Editor
		.create( element, config )
		.then( editor => {
			// Set a custom container for the toolbar.
			document.querySelector( '.document-editor__toolbar' ).appendChild( editor.ui.view.toolbar.element );
			document.querySelector( '.ck-toolbar' ).classList.add( 'ck-reset_all' );
            window.editor=editor;
			return editor;
		} );
} );

watchdog.setDestructor( editor => {
	// Remove a custom container from the toolbar.
    window.editor=null;
	document.querySelector( '.document-editor__toolbar' ).removeChild( editor.ui.view.toolbar.element );

	return editor.destroy();
} );

watchdog.on( 'error', handleSampleError );

watchdog
	.create( document.querySelector( '#editor' ), {
		// Editor configuration.
        simpleUpload: {
            uploadUrl: '<?php echo get_uri("report_templates/upload_editor_image");?>',
        }
	} )
    .then(editor=>{
        window.editor=editor
    })
	.catch( handleSampleError );

function handleSampleError( error ) {
	const issueUrl = 'https://github.com/ckeditor/ckeditor5/issues';

	const message = [
		'Oops, something went wrong!',
		`Please, report the following error on ${ issueUrl } with the build id "lziiqesknuoj-aradtqxhkpgl" and the error stack trace:`
	].join( '\n' );

	console.error( message );
	console.error( error );
}
</script>