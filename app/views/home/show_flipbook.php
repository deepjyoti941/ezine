<!doctype html>
<html>
  <head>
    <title><? if (isset($page_title)) echo $page_title; ?></title>
    <link rel="stylesheet" href="/css/flipbook.css">

    <script src="/js/vendor/jquery.js"></script>
    <script src="/js/vendor/turn.js"></script>
    <script src="/js/vendor/pdf.js"></script>
    <script src="/js/flipbook.js"></script>
   </head>

  <body>
    <div id="book">
      <!-- <div class="cover"><h1>The Test</h1></div> -->
    </div>

<div id="controls">
  <label for="page-number">Page:</label> <input type="text" size="3" id="page-number"> of <span id="number-pages"></span>
</div>
  </body>

  </html>