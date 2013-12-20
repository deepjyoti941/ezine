
var pdfDoc = null
  , pageNum = 70
  , scale = 0.4
  , mozL10n = document.mozL10n || document.webL10n;
  //, canvas = document.getElementById('the-canvas')
  //, ctx = canvas.getContext('2d');

total_pages = 0;
drawn = 0;

var SinglePage = function () {

  this.annotationLayer = null;
  var self = this;

  this.setupAnnotations = function (pageDiv, pdfPage, viewport) {

    function bindLink(link, dest) {
      link.href = PDFView.getDestinationHash(dest);
      link.onclick = function pageViewSetupLinksOnclick() {
        if (dest) {
          PDFView.navigateTo(dest);
        }
        return false;
      };
      if (dest) {
        link.className = 'internalLink';
      }
    }

    function bindNamedAction(link, action) {
      link.href = PDFView.getAnchorUrl('');
      link.onclick = function pageViewSetupNamedActionOnClick() {
        // See PDF reference, table 8.45 - Named action
        switch (action) {
          case 'GoToPage':
            document.getElementById('pageNumber').focus();
            break;

          case 'GoBack':
            PDFHistory.back();
            break;

          case 'GoForward':
            PDFHistory.forward();
            break;

          case 'Find':
            if (!PDFView.supportsIntegratedFind) {
              PDFFindBar.toggle();
            }
            break;

          case 'NextPage':
            PDFView.page++;
            break;

          case 'PrevPage':
            PDFView.page--;
            break;

          case 'LastPage':
            PDFView.page = PDFView.pages.length;
            break;

          case 'FirstPage':
            PDFView.page = 1;
            break;

          default:
            break; // No action according to spec
        }
        return false;
      };
      link.className = 'internalLink';
    }

    pdfPage.getAnnotations().then(function(annotationsData) {
      if (self.annotationLayer) {
        // If an annotationLayer already exists, delete it to avoid creating
        // duplicate annotations when rapidly re-zooming the document.
        pageDiv.removeChild(self.annotationLayer);
        self.annotationLayer = null;
      }
      viewport = viewport.clone({ dontFlip: true });
      for (var i = 0; i < annotationsData.length; i++) {
        var data = annotationsData[i];
        var annotation = PDFJS.Annotation.fromData(data);
        if (!annotation || !annotation.hasHtml()) {
          continue;
        }

        var element = annotation.getHtmlElement(pdfPage.commonObjs);
        mozL10n.translate(element);

        data = annotation.getData();
        var rect = data.rect;
        var view = pdfPage.view;
        rect = PDFJS.Util.normalizeRect([
          rect[0],
          view[3] - rect[1] + view[1],
          rect[2],
          view[3] - rect[3] + view[1]
        ]);
        element.style.left = rect[0] + 'px';
        element.style.top = rect[1] + 'px';
        element.style.position = 'absolute';

        var transform = viewport.transform;
        var transformStr = 'matrix(' + transform.join(',') + ')';
        CustomStyle.setProp('transform', element, transformStr);
        var transformOriginStr = -rect[0] + 'px ' + -rect[1] + 'px';
        CustomStyle.setProp('transformOrigin', element, transformOriginStr);

        if (data.subtype === 'Link' && !data.url) {
          if (data.action) {
            bindNamedAction(element, data.action);
          } else {
            bindLink(element, ('dest' in data) ? data.dest : null);
          }
        }

        if (!self.annotationLayer) {
          var annotationLayerDiv = document.createElement('div');
          annotationLayerDiv.className = 'annotationLayer';
          pageDiv.appendChild(annotationLayerDiv);
          self.annotationLayer = annotationLayerDiv;
        }
        self.annotationLayer.appendChild(element);
      }
    });
  };


  // Main Code for rendering a page

  this.renderPage = function (num) {

    // Using promise to fetch the page
    pdfDoc.getPage(num).then(function(page) {
      var viewport = page.getViewport(scale);

      var div = document.createElement('div');
      div.id = 'pageContainer' + num;
      div.className = 'page';
      div.style.width = Math.floor(viewport.width) + 'px';
      div.style.height = Math.floor(viewport.height) + 'px';

      document.getElementById('pdfContainer').appendChild(div);

      // Wrap the canvas so if it has a css transform for highdpi the overflow
      // will be hidden in FF.
      var canvasWrapper = document.createElement('div');
      canvasWrapper.style.width = div.style.width;
      canvasWrapper.style.height = div.style.height;
      canvasWrapper.classList.add('canvasWrapper');

      var canvas = document.createElement('canvas');
      canvas.id = 'page' + num;
      canvasWrapper.appendChild(canvas);
      div.appendChild(canvasWrapper);

      var ctx = canvas.getContext('2d');
      var outputScale = getOutputScale(ctx);

      canvas.width = Math.floor(viewport.width * outputScale.sx);
      canvas.height = Math.floor(viewport.height * outputScale.sy);
      canvas.style.width = Math.floor(viewport.width) + 'px';
      canvas.style.height = Math.floor(viewport.height) + 'px';
      // Add the viewport so it's known what it was originally drawn with.
      canvas._viewport = viewport;

      //var $pdfContainer = $('#pdfContainer');
      //$pdfContainer.css('height', canvas.height + 'px').css('width', canvas.width + 'px');
      //$pdfContainer.append($canvas);

      var textLayerDiv = null;
      if (!PDFJS.disableTextLayer) {
        textLayerDiv = document.createElement('div');
        textLayerDiv.className = 'textLayer';
        textLayerDiv.style.width = canvas.width + 'px';
        textLayerDiv.style.height = canvas.height + 'px';
        div.appendChild(textLayerDiv);
      }
      var textLayer = this.textLayer =
        textLayerDiv ? new TextLayerBuilder({
          textLayerDiv: textLayerDiv,
          //pageIndex: this.id - 1,
          //lastScrollSource: PDFView,
          //viewport: this.viewport,
          //isViewerInPresentationMode: PresentationMode.active
        }) : null;
      // TODO(mack): use data attributes to store these
      ctx._scaleX = outputScale.sx;
      ctx._scaleY = outputScale.sy;
      if (outputScale.scaled) {
        ctx.scale(outputScale.sx, outputScale.sy);
      }
      if (outputScale.scaled && textLayerDiv) {
        var cssScale = 'scale(' + (1 / outputScale.sx) + ', ' +
                                  (1 / outputScale.sy) + ')';
        CustomStyle.setProp('transform' , textLayerDiv, cssScale);
        CustomStyle.setProp('transformOrigin' , textLayerDiv, '0% 0%');
      }

      //The following few lines of code set up scaling on the context if we are on a HiDPI display
      /*var outputScale = getOutputScale(context);
      if (outputScale.scaled) {
          var cssScale = 'scale(' + (1 / outputScale.sx) + ', ' +
              (1 / outputScale.sy) + ')';
          CustomStyle.setProp('transform', canvas, cssScale);
          CustomStyle.setProp('transformOrigin', canvas, '0% 0%');

          if ($textLayerDiv.get(0)) {
              CustomStyle.setProp('transform', $textLayerDiv.get(0), cssScale);
              CustomStyle.setProp('transformOrigin', $textLayerDiv.get(0), '0% 0%');
          }
      }

      context._scaleX = outputScale.sx;
      context._scaleY = outputScale.sy;
      if (outputScale.scaled) {
          context.scale(outputScale.sx, outputScale.sy);
      }*/

      //$pdfContainer.append($textLayerDiv);

      /*page.getTextContent().then(function (textContent) {
        var textLayer = new TextLayerBuilder({ textLayerDiv: $textLayerDiv.get(0) });

        textLayer.setTextContent(textContent);

        // annotations
        //console.log(page.getAnnotations());

        var renderContext = {
          canvasContext: context,
          viewport: viewport,
          textLayer: textLayer
        };

        page.render(renderContext);
        setupAnnotations($pdfContainer.get(0), page, viewport);
      });*/

      var renderContext = {
        canvasContext: ctx,
        viewport: viewport,
        textLayer: textLayer,
        /*continueCallback: function pdfViewcContinueCallback(cont) {
          if (PDFView.highestPriorityPage !== 'page' + self.id) {
            self.renderingState = RenderingStates.PAUSED;
            self.resume = function resumeCallback() {
              self.renderingState = RenderingStates.RUNNING;
              cont();
            };
            return;
          }
          cont();
        }*/
      };
      var renderTask = page.render(renderContext);

      renderTask.then(
        function pdfPageRenderCallback() {
          drawn++;

          if (drawn === total_pages)
            initTurnJS();
        },
        function pdfPageRenderError(error) {
          pageViewDrawCallback(error);
        }
      );

      if (textLayer) {
        page.getTextContent().then(
          function textContentResolved(textContent) {
            textLayer.setTextContent(textContent);
          }
        );
      }

      self.setupAnnotations(div, page, viewport);
      //div.setAttribute('data-loaded', true);

      // Render PDF page into canvas context
      //var renderContext = {
      //  canvasContext: ctx,
      //  viewport: viewport
      //};

      //page.render(renderContext);
    });

    // Update page counters
    //document.getElementById('page_num').textContent = pageNum;
    //document.getElementById('page_count').textContent = pdfDoc.numPages;
  };
};


// Load the document
PDFJS.getDocument('/ezine/web/magz/india-today-travel-plus-2013-11-nov.pdf').then(function getPdfHelloWorld(_pdfDoc) {
  pdfDoc = _pdfDoc;
  total_pages = pdfDoc.numPages;

  //renderPage(69);

  //renderPage(70);

  for (var i = 1; i <= total_pages; i++) {
    var single_page = new SinglePage();
    single_page.renderPage(i)
  }

  // TURNJS

initTurnJS = function() {
  console.log('turnjs');
  alert('Ready to rock and roll!');
  //return;
  var height = $('.page').height();
  $('#pdfContainer').height(height);
  var width = $('.page').width();
  $('#pdfContainer').width(width*2);

$('#pdfContainer').turn({
  display: 'double',
  acceleration: true,
  gradients: !$.isTouch,
  elevation:50,
  when: {
    turned: function(e, page) {
      /*console.log('Current view: ', $(this).turn('view'));*/
    }
  }
});

$(window).bind('keydown', function(e) {
  if (e.keyCode==37)
    $('#pdfContainer').turn('previous');
  else if (e.keyCode==39)
    $('#pdfContainer').turn('next');
});

};

});