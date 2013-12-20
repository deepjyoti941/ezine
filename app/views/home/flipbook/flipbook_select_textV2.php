<html>
    <head>
        <title>Minimal pdf.js text-selection demo</title>
        <link href="/css/flipbook/minimal.css" rel="stylesheet" media="screen" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

        <!-- you will need to run "node make generic" first before you can use this -->
        <script src="/js/vendor/pdf.js" type="text/javascript"></script>

        <!-- These files are viewer components that you will need to get text-selection to work -->
        <script src="/js/vendor/web/pdf_find_bar.js"></script>
        <!-- <script src="/js/vendor/web/pdf_find_controller.js"></script> -->
        <script src="/js/vendor/web/ui_utils.js"></script>
        <script src="/js/vendor/web/text_layer_builder.js"></script>

        <script src="/js/appV2.js" type="text/javascript"></script>
    </head>
    <body>
        This is a minimal pdf.js text-selection demo. The existing minimal-example shows you how to render a PDF, but not
        how to enable text-selection. This example shows you how to do both. <br /><br />
        <div id="pdfContainer" class="pdf-content">
        </div>
    </body>
</html>
