(function() {

	var query  = window.location.href;
    query = query.split("/");
    var magazine_id = query[5];
	$.post('/get-magazine-pdf',{ magazine_id:magazine_id }, function (res) {
		
		var data = JSON.parse(res);
		var url = data[0].pdf_path;
		var numberOfPages = 0;
		var rendered = [];
		var firstPagesRendered = false;
		var pdf = null
        	,pageNum = 1
        	,scale = 0.45;


        function renderPage(num) {

		    pdf.getPage(num).then(function(page) {
		        var scale = 0.41;
		        var viewport = page.getViewport(scale);
		        
		        //Prepare canvas using PDF page dimensions
		       
				var canvasID = 'canv' + num;
		        var canvas = document.getElementById(canvasID);
				if (canvas == null) return;
		        var context = canvas.getContext('2d');
		        canvas.height = viewport.height;
		        canvas.width = viewport.width;

		        // Render the PDF page into canvas context
		        var renderContext = {
		          canvasContext: context,
		          viewport: viewport
		        };
		        page.render(renderContext);

		        // Update the page counters i.e grab it from the label with id of page-number and span with id number-pages
		        document.getElementById('page-number').textContent = pageNum;
		        document.getElementById('number-pages').textContent = pdf.numPages;
	        }
		)}
	

		// Adds the pages that the book will need
		function addPage(page, book) {
			// 	First checking if the page is already in the book
			if (!book.turn('hasPage', page)) {
			
				// Create an element for this page
				var element = $('<div />', {'class': 'page '+((page%2==0) ? 'odd' : 'even'), 'id': 'page-'+page})
				element.html('<div class="data"><canvas id="canv' + page + '"></canvas></div>');
				// If not then add the page
				book.turn('addPage', element, page);
			}
		}

		//creating workspace for pdf file
		PDFJS.disableWorker = true;
	
		PDFJS.getDocument(url).then(function(pdfDoc) {
	  
			numberOfPages = pdfDoc.numPages;
			pdf = pdfDoc;
			$('#book').turn.pages = numberOfPages;
	  
		
		$('#book').turn({acceleration: false,
			pages: numberOfPages,
			elevation: 50,
			gradients: !$.isTouch,
			display: 'double',
			when: {
				turning: function(e, page, view) {

					// Gets the range of pages that the book needs right now
					var range = $(this).turn('range', page);

					// Check if each page is within the book
					for (page = range[0]; page<=range[1]; page++) {
						addPage(page, $(this));
					};
				},

				turned: function(e, page) {
					$('#page-number').val(page);
					
					if (firstPagesRendered) {
						var range = $(this).turn('range', page);
						for (page = range[0]; page<=range[1]; page++) {
							if (!rendered[page]) {
								renderPage(page);
								rendered[page] = true;
							}
						};
					}
					
				}
			}
		});

		$('#number-pages').html(numberOfPages);

		$('#page-number').keydown(function(e){
		
			var p = $('#page-number').val();
			if (e.keyCode==13) {
				$('#book').turn('page', p);
				renderPage(p);
			}
				
		});
		
		var n = numberOfPages;
		if (n > 6 ) n = 6;
			for (page = 1; page <= n; page++) {
				renderPage(page);
				rendered[page] = true;
			};
			firstPagesRendered = true;
		});

	});

})();

	$(window).bind('keydown', function(e) {

		if (e.target && e.target.tagName.toLowerCase()!='input')
			if (e.keyCode==37)
				$('#book').turn('previous');
			else if (e.keyCode==39)
				$('#book').turn('next');

	});
	