<script>
class MyUploadAdapter {
    constructor( loader ) {
        // The file loader instance to use during the upload.
        this.loader = loader;
    }

    // Starts the upload process.
    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                var reader=new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend=()=>{
                    return resolve({default:reader.result})
                }
            } ) );
    }

    // Aborts the upload process.
    abort() {
    }




}

function MyCustomUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new MyUploadAdapter( loader );
    };
}
</script>