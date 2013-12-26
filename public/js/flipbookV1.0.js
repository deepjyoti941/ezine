(function() {

	var query  = window.location.href;
    query = query.split("/");
    var magazine_id = query[5];
	$.post('/get-magazine-pdf',{ magazine_id:magazine_id }, function (res) {
		
		var data = JSON.parse(res);
		var url = data[0].pdf_path;
		console.log(url);
		var numberOfPages = 0;
		var rendered = [];
		var firstPagesRendered = false;
		var pdf = null
        	,pageNum = 1
        	,scale = 0.8

        function renderPage(num) {

		    pdf.getPage(num).then(function(page) {
		        var scale = 0.8;
		        var viewport = page.getViewport(scale);
		        console.log(page);
		        viewport.offsetX=1.5;
		        viewport.offsetY=1.5;
		        console.log(viewport);
		        
		        //First Prepare canvas for using PDF page dimensions
				var canvasID = 'canv' + num;
		        var canvas = document.getElementById(canvasID);
				if (canvas == null) return;
		        var context = canvas.getContext('2d');
		        canvas.height = viewport.height;
		        canvas.width = viewport.width;

		        //Render the PDF page into canvas context
		        var renderContext = {
		          canvasContext: context,
		          viewport: viewport
		        };

		        page.render(renderContext);

		        //Update the page counters i.e grab it from the label with id of page-number and span with id number-pages
		        document.getElementById('page-number').textContent = pageNum;
		        document.getElementById('number-pages').textContent = pdf.numPages;
	        }
		)}
	
		// Adds the pages that the book will need
		function addPage(page, book) {
			// 	First checking if the page is already in the book
			if (!book.turn('hasPage', page)) {
				console.log(page);
				// Create an element for this page
				var element = $('<div />', {'class': 'page '+((page%2==0) ? 'odd' : 'even'), 'id': 'page-'+page})
				element.html('<div class="data"><canvas id="canv' + page + '"></canvas></div>');
				// If not then add the page
				book.turn('addPage', element, page);
			}	
		}

		//creating workspace for the pdf file
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

					var book = $(this),
					currentPage = book.turn('page'),
					pages = book.turn('pages');
		
					// Update the current URI
					Hash.go('page/' + page).update();

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

	/* zoom using Zoom.js */

	// $('.magazine-viewport').zoom({
	// 	flipbook: $('#book'),
	// 	max: function() { 
			
	// 		return largeMagazineWidth()/$('#book').width();

	// 	}, 
	// 	when: {
	// 		tap: function(event) {

	// 			if ($(this).zoom('value')==1) {
	// 				$('#book').
	// 					removeClass('animated').
	// 					addClass('zoom-in');
	// 				$(this).zoom('zoomIn', event);
	// 			} else {
	// 				$(this).zoom('zoomOut');
	// 			}
	// 		},

	// 		resize: function(event, scale, page, pageElement) {

	// 			if (scale==1)
	// 				loadSmallPage(page, pageElement);
	// 			else
	// 				loadLargePage(page, pageElement);

	// 		},

	// 		zoomIn: function () {
				
	// 			$('.thumbnails').hide();
	// 			$('.made').hide();
	// 			$('.magazine').addClass('zoom-in');

	// 			if (!window.escTip && !$.isTouch) {
	// 				escTip = true;	

	// 				$('<div />', {'class': 'esc'}).
	// 					html('<div>Press ESC to exit</div>').
	// 						appendTo($('body')).
	// 						delay(2000).
	// 						animate({opacity:0}, 500, function() {
	// 							$(this).remove();
	// 						});
	// 			}
	// 		},

	// 		zoomOut: function () {

	// 			$('.esc').hide();
	// 			$('.thumbnails').fadeIn();
	// 			$('.made').fadeIn();

	// 			setTimeout(function(){
	// 				$('.magazine').addClass('animated').removeClass('zoom-in');
	// 				resizeViewport();
	// 			}, 0);

	// 		},

	// 		swipeLeft: function() {

	// 			$('.magazine').turn('next');

	// 		},

	// 		swipeRight: function() {
				
	// 			$('.magazine').turn('previous');

	// 		}
	// 	}
	// });

	// $('#book').on('click' , '.data' , function(){
	// 	alert('heloo');
	// 	$("#zoom-viewport").zoom({
	// 		flipbook: $("#book"),
	// 		max: 3
	// 	});

	// });



	// URIs - Format #/page/1 
	Hash.on('^page\/([0-9]*)$', {
		yep: function(path, parts) {
			//console.log(parts);
			var page = parts[1];
			// console.log(page);
			//if (page!==undefined) {
				//if ($('#book').turn('is'))
					$('#book').turn('page', page);
			//}

		},
		nop: function(path) {

			//if ($('#book').turn('is'))
				$('#book').turn('page', 1);
		}
	});


	//resize the window after zoom or any operation
	// $(window).resize(function() {
	// 	resizeViewport();
	// }).bind('orientationchange', function() {
	// 	resizeViewport();
	// });

	//FOR THE ZOOM FUNCTIONALITY






//for the jquery range slider
$(document).ready(function(){

	   $( "#slider" ).slider({
      range: "min",
            min: 0,
            max: 1,
            value: 0,
            step: 0.05,
      		create: function( event, ui ) {
      			setSliderTicks(event.target);
    		},

		    slide: function( event, ui ) {
		        // While sliding, update the value in the #amount div element
		    	$( "#amount" ).html( ui.value );
		        
		    }
    	});
	   function setSliderTicks(el) {
	    var $slider =  $(el);
	    var max =  $slider.slider("option", "max");    
	    var min =  $slider.slider("option", "min");    
	    var spacing =  100 / (max - min);

	    $slider.find('.ui-slider-tick-mark').remove();
	    for (var i = 0; i < max-min ; i++) {
	        $('<span class="ui-slider-tick-mark"></span>').css('left', (spacing * i) +  '%').appendTo($slider); 
	     }
	}

});


