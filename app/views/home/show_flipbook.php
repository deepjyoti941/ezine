<!doctype html>
<html>
  <head>
    <title><? if (isset($page_title)) echo $page_title; ?></title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="/css/flipbook.css">
    <style type="text/css">
            /* html */
      :-webkit-full-screen {
        background: grey;
      }
      :-moz-full-screen {
        background: grey;
      }

      /* deeper elements */
      :-webkit-full-screen video {
        width: 100%;
        height: 100%;
      }

    </style>

    <script src="/js/vendor/jquery.js"></script>
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="/js/vendor/turn3.js"></script>
    <script src="/js/vendor/pdf.js"></script>
    <script src="/js/vendor/hash.js"></script>
    <script src="/js/vendor/textlayerbuilder.js"></script>
    <script src="/js/flipbookV1.0.js"></script>


  </head>

  <body>
        <label style="float:left;margin-top:0px;padding-left: 90px;padding-right:8px"><strong>Magazine name comes here with all details</strong></label>
        <div id="slider" style=""></div>
        <div id="zoom-viewport">          
          <div class="container" style="float:left; padding-right:60px;">
            <div id="book">
              <!-- <div class="cover"><h1>The Test</h1></div> -->
            </div>
          </div>
          <div style="float:left">
              <button style="width: 122px;" onclick="launchFullscreen(document.documentElement);" class="sexyButton">Launch Fullscreen</button>
          </div>
          <div style="float:left">
              <button style="width: 120px;" onclick="cancelFullscreen(document.documentElement);" class="sexyButton">Exit Fullscreen</button>

          </div>
        </div>
      <div id="controls"style="visibility:hidden;">
        <label for="page-number">Page:</label> <input type="text" size="3" id="page-number"> of <span id="number-pages"></span>
      </div>
      
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

      <script>

        // $('#book').on('click',function(event){
        //   alert('clicked on data');
        // });
        //$("#book").click(ZoomIn());

        //$("#book").click(ZoomOut());

      //   function ZoomIn (event) {

      //     $("#div img").width(
      //         $("#div img").width() * 1.2
      //     );

      //     $("#div img").height(
      //         $("#div img").height() * 1.2
      //     );
      // },

      // function  ZoomOut (event) {

      //     $("#div img").width(
      //         $("#imgDtls").width() * 0.5
      //     );

      //     $("#div img").height(
      //         $("#div img").height() * 0.5
      //     );
      // }


        // document.querySelector( '.container' ).addEventListener( 'click', function( event ) {
        // zoom.to({ element: event.target });
        // });



      // $(document).ready( function() {
      // $('#book').hover(
      //     function() {
      //         $(this).animate({ 'zoom': 1.2 }, 400);
      //     },
      //     function() {
      //         $(this).animate({ 'zoom': 1 }, 400);
      //     });
      // });
    </script>

  </body>

</html>