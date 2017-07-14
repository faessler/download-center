<?php
function listDirectory($path) {
    // Path to file directory
    if (empty($path)) {
        $path = "files/";
    }

    // Set $path as current php directory
    chdir ($path);

    // Show back link if current dir is a sub dir
    $pathInfo = pathinfo($path);
    $filePath = $pathInfo['dirname'];
    $fileName = $pathInfo['filename'];
    if ($filePath !== ".") {
        echo "<div class='list__header'>";
        echo "<div class='list__header__back'><a onclick='showFolder(this.getAttribute(\"data-parenturl\"))' data-parenturl='".$filePath."/'><i class='fa fa-arrow-left' aria-hidden='true'></i> Back</a></div>";
        echo "<div class='list__header__path'>".$filePath."/<b>".$fileName."</b></div>";
        echo "</div>";
    }

    // Create Array / Scan directory
    $contents = array_diff (scandir ('.'), array ('.', '..', '.DS_Store', 'Thumbs.db'));

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
            echo "<li class='folder'><a onclick='showFolder(this.getAttribute(\"data-folderurl\"), this.getAttribute(\"data-foldername\"))' data-folderurl='".$path."' data-foldername='".$content."'><span class='filename'>".$content."</span></a></li>";
        } else {
            echo "<li><a href='".$path.$content."' data-filesize='".$contentSize."' download><span class='filename'>".$content."</span><span class='filesize'>".$getFilesize."</span>"."</a></li>";
        }
    }
}

// SHOW SUB FOLDER
$folderUrl = $_REQUEST["folderUrl"];
$folderName = $_REQUEST["folderName"];

if (!empty($folderName)) {
    $folderName = $folderName."/";
}

if (!empty($folderUrl)) {
    $path = $folderUrl.$folderName;
    listDirectory($path);
} else {
?>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="robots" content="noindex, nofollow">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>###DCNAME###</title>
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" media="all">
            <style><!-- inject:css --><!-- endinject --></style>
            <script><!-- inject:js --><!-- endinject --></script>
        </head>
        <body>

            <div class="wrapper">
                <h1>###DCNAME###</h1>
                <ul id="list">
                    <?php
                    listDirectory();
                    ?>
                </ul>
            </div>

        </body>
    </html>
<?php
}
?>