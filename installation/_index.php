<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>###DCNAME###</title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" media="all">
        <style>body{margin:0 auto;width:100%;min-height:100vh;background-color:#2c3e50;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif}.wrapper{width:600px;margin:60px auto}h1{color:#ecf0f1}ul{list-style:none;margin:0;padding:0}ul li a{position:relative;display:block;padding:20px 20px 20px 43px;background-color:#ecf0f1;color:#2c3e50;text-decoration:none}ul li a:hover{background-color:#bdc3c7}ul li+li a{border-top:1px solid #2c3e50}ul li a:before{position:absolute;left:20px;padding-right:10px;font-family:fontawesome;font-size:100%;content:"\f016"}ul li a[href$=".txt"]:before{content:"\f0f6"}ul li a[href$=".pdf"]:before{content:"\f1c1"}ul li a[href$=".doc"]:before,ul li a[href$=".docx"]:before{content:"\f1c2"}ul li a[href$=".xlsx"]:before,ul li a[href$=".xls"]:before{content:"\f1c3"}ul li a[href$=".ppt"]:before,ul li a[href$=".pptx"]:before{content:"\f1c4"}ul li a[href$=".png"]:before,ul li a[href$=".jpg"]:before,ul li a[href$=".jpeg"]:before,ul li a[href$=".gif"]:before,ul li a[href$=".tiff"]:before,ul li a[href$=".svg"]:before,ul li a[href$=".svgz"]:before,ul li a[href$=".eps"]:before{content:"\f1c5"}ul li a[href$=".zip"]:before,ul li a[href$=".7z"]:before,ul li a[href$=".rar"]:before,ul li a[href$=".tar"]:before,ul li a[href$=".tar.gz"]:before{content:"\f1c6"}ul li a[href$=".3gp"]:before,ul li a[href$=".m4a"]:before,ul li a[href$=".mp3"]:before,ul li a[href$=".oga"]:before,ul li a[href$=".wma"]:before{content:"\f1c7"}ul li a[href$=".mp4"]:before,ul li a[href$=".m4v"]:before,ul li a[href$=".m4p"]:before,ul li a[href$=".webm"]:before,ul li a[href$=".ogg"]:before,ul li a[href$=".avi"]:before,ul li a[href$=".mov"]:before,ul li a[href$=".wmv"]:before{content:"\f1c8"}ul li a[href$=".html"]:before,ul li a[href$=".php"]:before,ul li a[href$=".ts"]:before,ul li a[href$=".css"]:before,ul li a[href$=".scss"]:before,ul li a[href$=".js"]:before,ul li a[href$=".java"]:before{content:"\f1c9"}ul li a[href$=".ttf"]:before,ul li a[href$=".otf"]:before,ul li a[href$=".woff"]:before,ul li a[href$=".woff2"]:before,ul li a[href$=".eot"]:before{content:"\f031"}.filesize{display:inline-block;padding-left:10px;font-size:55%;font-style:italic;vertical-align:bottom}@media screen and (max-width:600px){body{background-color:#ecf0f1}.wrapper{margin:0 auto;width:100%}h1{color:#2c3e50;padding:20px;margin:0}ul li+li a{border-top:none}ul li:first-child a{border-top:1px solid #2c3e50}ul li a{border-bottom:1px solid #2c3e50}}</style>
    </head>
    <body>

        <div class="wrapper">
            <h1>###DCNAME###</h1>
            <ul>
                <?php
                    $path = "files/";
                    $files = array_slice(scandir($path), 2);
                    foreach ($files as &$value) {
                        $filesize = filesize($path.$value);
                        if ($filesize < 1000) {
                            $filesize = filesize($path.$value)." B";
                        } elseif ($filesize < 1000000) {
                            $filesize = round((filesize($path.$value)/1000), 2)." KB";
                        } elseif ($filesize < 1000000000) {
                            $filesize = round((filesize($path.$value)/1000000), 2)." MB";
                        } else {
                            $filesize = round((filesize($path.$value)/1000000000), 2)." GB";
                        }

                        echo "<li><a href='".$path.$value."' download><span class='filename'>".$value."</span><span class='filesize'>".$filesize."</span>"."</a></li>";
                    }
                ?>
            </ul>
        </div>

    </body>
</html>
