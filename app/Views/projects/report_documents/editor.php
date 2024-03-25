
<link type="text/css" href="<?php echo base_url("assets/ckeditor5-document/");?>sample/css/sample.css" rel="stylesheet" media="screen" />



<main>
	<div class="centered">
		<div class="document-editor">
			<div class="toolbar-container"></div>
			<div class="content-container">
				<div id="editor">
					<h2>The three greatest things you learn from traveling</h2>
		
					<p>Like all the great things on earth traveling teaches us by example. Here are some of the most precious lessons I’ve learned over the years of traveling.</p>
		
					<h3>Appreciation of diversity</h3>
		
					<p>Getting used to an entirely different culture can be challenging. While it’s also nice to learn about cultures online or from books, nothing comes close to experiencing <a href="https://en.wikipedia.org/wiki/Cultural_diversity">cultural diversity</a> in person. You learn to appreciate each and every single one of the differences while you become more culturally fluid.</p>
		
					<figure class="image image-style-align-right"><img src="<?php echo base_url("assets/ckeditor5-document/");?>sample/img/umbrellas.jpg" alt="Three Monks walking on ancient temple.">
						<figcaption>Leaving your comfort zone might lead you to such beautiful sceneries like this one.</figcaption>
					</figure>
		
					<h3>Confidence</h3>
		
					<p>Going to a new place can be quite terrifying. While change and uncertainty makes us scared, traveling teaches us how ridiculous it is to be afraid of something before it happens. The moment you face your fear and see there was nothing to be afraid of, is the moment you discover bliss.</p>
				</div>
			</div>
		</div>

		
	</div>
</main>

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
