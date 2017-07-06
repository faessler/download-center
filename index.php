<html lang="de">
    <head>

        <meta charset="utf-8">

        <meta name="robots" content="noindex,follow">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Download Center</title>

        <link rel="stylesheet" type="text/css" href="vendor/css/main.css" media="all">
        <link rel="stylesheet" type="text/css" href="vendor/css/font-awesome.min.css" media="all">
    </head>
    <body>

        <div class="wrapper">
            <h1>Download Center</h1>
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
