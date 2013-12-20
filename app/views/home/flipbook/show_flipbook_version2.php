
<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Digital Magazine</title>

    <link rel="stylesheet" href="/css/flipbook/viewer.css">
    <link rel="stylesheet" href="/css/flipbook/book.css">
    <link rel="resource" type="application/l10n" href="locale.properties"/><!-- PDFJSSCRIPT_REMOVE_CORE -->
   <!-- 
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/turn.js"></script>
    <script type="text/javascript" src="compatibility.js"></script> PDFJSSCRIPT_REMOVE_FIREFOX_EXTENSION -->
    <!--
    <script type="text/javascript" src="../external/webL10n/l10n.js"></script>PDFJSSCRIPT_REMOVE_CORE 
    <script type="text/javascript" src="js/pdf.js"></script>PDFJSSCRIPT_REMOVE_CORE -->
    <!--
    <script type="text/javascript" src="debugger.js"></script>
    <script type="text/javascript" src="viewer.js"></script> -->

    <script src="/js/vendor/jquery.js"></script>
     <script src="/js/vendor/zoom.min.js"></script>
    <script src="/js/vendor/turn4.min.js"></script>
    <script src="/js/vendor/compatibility.js"></script>
    <script src="/js/vendor/changes_in_pdfjs.js"></script>
    <script src="/js/vendor/oldpdf.js"></script>
    <script src="/js/vendor/hash.js"></script>
     <!--<script src="/js/vendor/modernizr.js"></script>-->
    <script src="/js/flipbookV2.0.js"></script>

  </head>

  <body>
    <div id="outerContainer" style="float:left">

      <div id="sidebarContainer">
        <div id="toolbarSidebar">
          <div class="splitToolbarButton toggled">
            <button id="viewThumbnail" class="toolbarButton toggled" title="Show Thumbnails" onclick="PDFView.switchSidebarView('thumbs')" tabindex="1" data-l10n-id="thumbs">
               <span data-l10n-id="thumbs_label">Thumbnails</span>
            </button>
            <button id="viewOutline" class="toolbaYOJANA  January 2012rButton" title="Show Document Outline" onclick="PDFView.switchSidebarView('outline')" tabindex="2" data-l10n-id="outline">
               <span data-l10n-id="outline_label">Document Outline</span>
            </button>
          </div>
        </div>
        <div id="sidebarContent">
          <div id="thumbnailView">
          </div>
          <div id="outlineView" class="hidden">
          </div>
        </div>
      </div>  <!-- sidebarContainer -->

      <div id="mainContainer">
        <div class="toolbar" style="position:fixed">
          <div id="toolbarContainer">

            <div id="toolbarViewer">
              <div id="toolbarViewerLeft">
                <div class="toolbarButtonSpacer"></div>
                <div class="splitToolbarButton">
                  <button class="toolbarButton pageUp" title="Previous Page" onclick="PDFView.page--" id="previous" tabindex="4" data-l10n-id="previous">
                    <span data-l10n-id="previous_label">Previous</span>
                  </button>
                  <div class="splitToolbarButtonSeparator"></div>
                  <button class="toolbarButton pageDown" title="Next Page" onclick="PDFView.page++" id="next" tabindex="5" data-l10n-id="next">
                    <span data-l10n-id="next_label">Next</span>
                  </button>
                </div>
                <label id="pageNumberLabel" class="toolbarLabel" for="pageNumber" data-l10n-id="page_label">Page: </label>
                <input type="number" id="pageNumber" class="toolbarField pageNumber" onchange="PDFView.page = this.value;" value="1" size="4" min="1" tabindex="6">
                </input>
                <span id="numPages" class="toolbarLabel"></span>
              </div>
              <div id="toolbarViewerRight">
                <input id="fileInput" class="fileInput" type="file" oncontextmenu="return false;" style="visibility: hidden; position: fixed; right: 0; top: 0" />
                        
              <button style="width: 130px;" onclick="launchFullscreen(document.documentElement);" class="sexyButton">Launch Fullscreen</button>
          
              <button style="width: 120px;" onclick="cancelFullscreen(document.documentElement);" class="sexyButton">Exit Fullscreen</button>
          
                <!-- <div class="toolbarButtonSpacer"></div> -->
                <!--
                <a href="#" id="viewBookmark" class="toolbarButton bookmark" title="Current view (copy or open in new window)" tabindex="13" data-l10n-id="bookmark"><span data-l10n-id="bookmark_label">Current View</span></a> -->
              </div>
              <div class="outerCenter">
                <button style="width: 130px;" id="reset_initial" hidden="true">Reset</button>
                <div class="innerCenter" id="toolbarViewerMiddle">
                  <div class="splitToolbarButton">

                    <button class="toolbarButton zoomOut" title="Zoom Out" tabindex="7" id="zoom_out">
                      <span data-l10n-id="zoom_out_label">ZOOM OUT</span>
                    </button>
                    <div class="splitToolbarButtonSeparator"></div>
                    <button class="toolbarButton zoomIn" title="Zoom In" tabindex="8" id="zoom_in">
                      <span data-l10n-id="zoom_in_label">ZOOM IN</span>
                     </button>
                  </div>
                  <span id="scaleSelectContainer" class="dropdownToolbarButton">
                     <select id="scaleSelect" onchange="PDFView.parseScale(this.value);" title="Zoom" oncontextmenu="return false;" tabindex="9" data-l10n-id="zoom">
                      <option id="pageAutoOption" value="auto" selected="selected" data-l10n-id="page_scale_auto">Automatic Zoom</option>
                      <option id="pageActualOption" value="page-actual" data-l10n-id="page_scale_actual">Actual Size</option>
                      <option id="pageFitOption" value="page-fit" data-l10n-id="page_scale_fit">Fit Page</option>
                      <option id="pageWidthOption" value="page-width" data-l10n-id="page_scale_width">Full Width</option>
                      <option id="customScaleOption" value="custom"></option>
                      <option value="0.5">50%</option>
                      <option value="0.75">75%</option>
                      <option value="1">100%</option>
                      <option value="1.25">125%</option>
                      <option value="1.5">150%</option>
                      <option value="2">200%</option>
                    </select>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="viewerContainer">
          <div class="magazine-viewport">
            <div id="viewer"></div>
          </div> 
        </div>

        <div id="loadingBox">
            <div id="loading" style="color: black;" data-l10n-id="loading" data-l10n-args='{"percent": 0}'>Loading... 0%</div>
            <div id="loadingBar"><div class="progress"></div></div>
        </div>

        <div id="errorWrapper" hidden='true'>
          <div id="errorMessageLeft" hidden='true'>
            <span id="errorMessage"></span>
            <button id="errorShowMore" onclick="" oncontextmenu="return false;" data-l10n-id="error_more_info">
              More Information
            </button>
            <button id="errorShowLess" onclick="" oncontextmenu="return false;" data-l10n-id="error_less_info" hidden='true'>
              Less Information
            </button>
          </div>
          <div id="errorMessageRight" hidden='true'>
            <button id="errorClose" oncontextmenu="return false;" data-l10n-id="error_close">
              Close
            </button>
          </div>
          <div class="clearBoth"></div>
          <textarea id="errorMoreInfo" hidden='true' readonly="readonly"></textarea>
        </div>

      </div> <!-- mainContainer -->

<!--     <div style="float:left">
        <button style="width: 122px;" onclick="launchFullscreen(document.documentElement);" class="sexyButton">Launch Fullscreen</button>
    </div>
    <div>
        <button style="width: 120px;" onclick="cancelFullscreen(document.documentElement);" class="sexyButton">Exit Fullscreen</button>
    </div> -->
    </div> <!-- outerContainer -->
<!--     <div style="float:left">
      <button style="width: 122px;" onclick="launchFullscreen(document.documentElement);" class="sexyButton">Launch Fullscreen</button>
    </div> -->

     <!--script for full screen -->
      <script type="text/javascript">
          function launchFullscreen(element) {
            if(element.requestFullScreen) {
              element.requestFullScreen();
            } else if(element.mozRequestFullScreen) {
              element.mozRequestFullScreen();
            } else if(element.webkitRequestFullScreen) {
              element.webkitRequestFullScreen();
            }
          }

          function cancelFullscreen() {
            if(document.cancelFullScreen) {
              document.cancelFullScreen();
            } else if(document.mozCancelFullScreen) {
              document.mozCancelFullScreen();
            } else if(document.webkitCancelFullScreen) {
              document.webkitCancelFullScreen();
            }
          }

            // Events
          document.addEventListener("fullscreenchange", function(e) {
            console.log("fullscreenchange event! ", e);
          });
          document.addEventListener("mozfullscreenchange", function(e) {
            console.log("mozfullscreenchange event! ", e);
          });
          document.addEventListener("webkitfullscreenchange", function(e) {
            console.log("webkitfullscreenchange event! ", e);
          });
      </script>



  </body>
</html>
