<?PHP
//echo 'Current PHP version: ' . phpversion();
$sampleRSS = "sample-rss.xml";
$XML = "https://news.ycombinator.com/rss";

include "lib/Tools.php";
include "lib/XMLTools.php";

$XMLTools = new XMLTools( array('XMLURL' => $XML) );
    if (!$XMLTools->init()) {
        echo "<div class='alert alert-danger'> Page could not load (init is failing) </div>";

    }



?>
<!DOCTYPE html>
 <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<style>

</style>
        <link rel="stylesheet" href="css/main.css">

    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->


        <div class="page">
          <?php echo $XMLTools->fillPosts(); ?>
        </div>

        <script src="js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>