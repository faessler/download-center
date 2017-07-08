<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>###DCNAME###</title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" media="all">
        <style>body{margin:0 auto;width:100%;min-height:100vh;background-color:#2c3e50;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif}.wrapper{width:600px;margin:60px auto}h1{color:#ecf0f1}ul{list-style:none;margin:0;padding:0}ul li.extgroup{text-transform:uppercase;color:#ecf0f1;margin:25px 0 5px}ul li a{position:relative;display:block;padding:20px 20px 20px 43px;background-color:#ecf0f1;color:#2c3e50;text-decoration:none}ul li a:hover{background-color:#bdc3c7}ul li+li a{border-top:1px solid #2c3e50}ul li a:before{position:absolute;left:20px;padding-right:10px;font-family:fontawesome;font-size:100%;content:"\f016"}ul li.folder a:before{content:"\f114"}ul li a[href$=".txt"]:before{content:"\f0f6"}ul li a[href$=".pdf"]:before{content:"\f1c1"}ul li a[href$=".doc"]:before,ul li a[href$=".docx"]:before{content:"\f1c2"}ul li a[href$=".xlsx"]:before,ul li a[href$=".xls"]:before{content:"\f1c3"}ul li a[href$=".ppt"]:before,ul li a[href$=".pptx"]:before{content:"\f1c4"}ul li a[href$=".png"]:before,ul li a[href$=".jpg"]:before,ul li a[href$=".jpeg"]:before,ul li a[href$=".gif"]:before,ul li a[href$=".tiff"]:before,ul li a[href$=".svg"]:before,ul li a[href$=".svgz"]:before,ul li a[href$=".eps"]:before{content:"\f1c5"}ul li a[href$=".zip"]:before,ul li a[href$=".7z"]:before,ul li a[href$=".rar"]:before,ul li a[href$=".tar"]:before,ul li a[href$=".tar.gz"]:before{content:"\f1c6"}ul li a[href$=".3gp"]:before,ul li a[href$=".m4a"]:before,ul li a[href$=".mp3"]:before,ul li a[href$=".oga"]:before,ul li a[href$=".wma"]:before{content:"\f1c7"}ul li a[href$=".mp4"]:before,ul li a[href$=".m4v"]:before,ul li a[href$=".m4p"]:before,ul li a[href$=".webm"]:before,ul li a[href$=".ogg"]:before,ul li a[href$=".avi"]:before,ul li a[href$=".mov"]:before,ul li a[href$=".wmv"]:before{content:"\f1c8"}ul li a[href$=".html"]:before,ul li a[href$=".php"]:before,ul li a[href$=".ts"]:before,ul li a[href$=".css"]:before,ul li a[href$=".scss"]:before,ul li a[href$=".js"]:before,ul li a[href$=".java"]:before{content:"\f1c9"}ul li a[href$=".ttf"]:before,ul li a[href$=".otf"]:before,ul li a[href$=".woff"]:before,ul li a[href$=".woff2"]:before,ul li a[href$=".eot"]:before{content:"\f031"}.filesize{display:inline-block;padding-left:10px;font-size:55%;font-style:italic;vertical-align:bottom}@media screen and (max-width:600px){body{background-color:#ecf0f1}.wrapper{margin:0 auto;width:100%}h1{color:#2c3e50;padding:20px;margin:0}ul li.extgroup{text-transform:uppercase;color:#2c3e50;margin:35px 0 0;padding:0 0 10px 20px;border-bottom:1px solid;font-weight:700}ul li+li a{border-top:none}ul li:first-child a{border-top:1px solid #2c3e50}ul li a{border-bottom:1px solid #2c3e50}}</style>
    </head>
    <body>

        <div class="wrapper">
            <h1>###DCNAME###</h1>
            <ul>
                <?php
                // Path to file directory
                $path = "files/";

                // Set $path as current php directory
                chdir ($path);

                // Create Array / Scan directory
                $contents = array_diff (scandir ('.'),

                    // Files and Folder to ignore
                    array ('.', '..', '.DS_Store', 'Thumbs.db')
                );

                // Sort Array (1.Folder, 2.Type, 3.Alphabetically)
                usort ($contents, create_function ('$a,$b', '
                        return is_dir ($a)
                        ? (is_dir ($b) ? strnatcasecmp ($a, $b) : -1)
                        : (is_dir ($b) ? 1 : (
                        strcasecmp (pathinfo ($a, PATHINFO_EXTENSION), pathinfo ($b, PATHINFO_EXTENSION)) == 0
                        ? strnatcasecmp ($a, $b)
                        : strcasecmp (pathinfo ($a, PATHINFO_EXTENSION), pathinfo ($b, PATHINFO_EXTENSION))
                        ));
                    '));

                // List Array
                foreach ($contents as &$content) {
                    $path_parts = pathinfo($content);
                    $contentExt = $path_parts['extension'];
                    $contentSize = filesize($content);

                    // Get file size human readable
                    if ($contentSize < 1000) {
                        $getFilesize = filesize($content)." B";
                    } elseif ($contentSize < 1000000) {
                        $getFilesize = round((filesize($content)/1000), 2)." KB";
                    } elseif ($contentSize < 1000000000) {
                        $getFilesize = round((filesize($content)/1000000), 2)." MB";
                    } else {
                        $getFilesize = round((filesize($content)/1000000000), 2)." GB";
                    }

                    // Echo to screen
                    if ($previous !== $contentExt) {
                        echo "<li class='extgroup' data-extgroup='".$contentExt."'>".$contentExt."</li>";
                    }
                    $previous = $contentExt;

                    if (is_dir($content)) {
                        echo "<li class='folder'><a data-folderurl='".$content."'><span class='filename'>".$content."</span></a></li>";
                    } else {
                        echo "<li><a href='".$content."' data-filesize='".$contentSize."' download><span class='filename'>".$content."</span><span class='filesize'>".$getFilesize."</span>"."</a></li>";
                    }
                }
                ?>
            </ul>
        </div>

    </body>
</html>
