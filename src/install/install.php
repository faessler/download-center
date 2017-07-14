<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Download Center Installer</title>
        <style><!-- inject:css --><!-- endinject --></style>
    </head>
    <body>
    <?php if (!empty($_POST)): ?>
        <div class="wrapper">
            <div class="content">
                <?php
                    // OVERRIDE DOWNLOAD CENTER NAME
                    $dcName = file_get_contents('installation/_index.php', true);
                    if (empty($_POST["dcName"])) {
                        $dcName = str_replace("###DCNAME###", "Download Center", $dcName);
                    } else {
                        $dcName = str_replace("###DCNAME###", htmlspecialchars($_POST["dcName"]), $dcName);
                    }
                    file_put_contents('index.php', $dcName);


                    // MOVE FILES FOLDER TO CURRENT DIRECTORY
                    if (!is_dir("files")) {
                        rename("installation/files", "files");
                    }


                    // CREATING USER
                    if (!isset($_POST["dcProtection"])) {
                        unlink("installation/_.htaccess");
                        unlink("installation/_.htpasswd");
                    } else {
                        $fileCheckAccess = '.htaccess';
                        $fileCheckPw = '.htpasswd';
                        if (file_exists($fileCheckAccess) || file_exists($fileCheckPw)) {
                            if (file_exists($fileCheckAccess) && !file_exists($fileCheckPw)) {
                                echo "ALERT: There is already an .htaccess file in the current directory. Couldn't add password protection for your Download Center!";
                            } elseif (file_exists($fileCheckPw) && !file_exists($fileCheckAccess)) {
                                echo "ALERT: There is already an .htpasswd file in the current directory. Couldn't add password protection for your Download Center!";
                            } else {
                                echo "ALERT: There is already a .htaccess & a .htpasswd file in the current directory. Couldn't add password protection for your Download Center!";
                            }
                        } else {
                            // username
                            $dcUser = file_get_contents('installation/_.htpasswd', true);
                            $dcUser = str_replace("###USERNAME###", htmlspecialchars($_POST["dcLoginUsr"]), $dcUser);

                            // password
                            $clearTextPassword = htmlspecialchars($_POST["dcLoginPw"]);
                            $encodedPassword = crypt($clearTextPassword, base64_encode($clearTextPassword));
                            $dcUser = str_replace("###PASSWORD###", $encodedPassword, $dcUser);
                            file_put_contents('.htpasswd', $dcUser);

                            // set path to .htpasswd
                            $path = dirname($_SERVER['SCRIPT_FILENAME']);
                            $dcHtaccess = file_get_contents('installation/_.htaccess', true);
                            $dcHtaccess = str_replace("###PATHTOHT###", $path, $dcHtaccess);
                            file_put_contents('.htaccess', $dcHtaccess);
                        }
                    }


                    // REMOVE FILES AND FOLDERS
                    unlink("README.md");
                    function rrmdir($dir) {
                        if (is_dir($dir)) {
                            $objects = scandir($dir);
                            foreach ($objects as $object) {
                                if ($object != "." && $object != "..") {
                                    if (is_dir($dir."/".$object))
                                        rrmdir($dir."/".$object);
                                    else
                                        unlink($dir."/".$object);
                                }
                            }
                            rmdir($dir);
                        }
                    }
                    rrmdir(".git");
                    rrmdir("installation");
                ?>

                <b>Congrats your Download Center is installed!</b><br />
                Refresh this page to start. <br /><br />
                <?php if (isset($_POST["dcProtection"])) { ?>
                    Psssst... Here you can see your login datas for the last time:<br />
                    Username: <?php echo htmlspecialchars($_POST["dcLoginUsr"]); ?><br />
                    Password: <?php echo htmlspecialchars($_POST["dcLoginPw"]); ?>
                <?php } ?>
            </div>
        </div>
    <?php else: ?>
        <div class="wrapper">
            <h1>Download Center Installer</h1>
            <div class="content">
                <h3>Please fill in the form below to install the Download Center.</h3>
                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                    <div class="formgroup">
                        <label for="dcName">Name <span class="info"><span class="info__qmark">?</span><span class="info__legend">Name of your Download Center</span></label></span>
                        <input type="text" id="dcName" name="dcName" placeholder="Download Center">
                    </div>
                    <div class="formgroup">
                        <label for="dcProtection">Protection <span class="info"><span class="info__qmark">?</span><span class="info__legend">If unchecked the Download Center will not be password protected via ".htaccess" & ".htpasswd"</span></label></span>
                        <input type="checkbox" id="dcProtection" name="dcProtection" checked>
                    </div>
                    <div class="formgroup">
                        <label for="dcLoginUsr">Username <span class="info"><span class="info__qmark">?</span><span class="info__legend">Create a Username for Download Center login</span></label></span>
                        <input type="text" id="dcLoginUsr" name="dcLoginUsr" placeholder="Jan">
                    </div>
                    <div class="formgroup">
                        <label for="dcLoginPw">Password <span class="info"><span class="info__qmark">?</span><span class="info__legend">Create a Password for Download Center login</span></label></span>
                        <input type="password" id="dcLoginPw" name="dcLoginPw" placeholder="•••••••••">
                    </div>
                    <div class="formgroup">
                        <input type="submit" value="Install Now">
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <script>function protectionCheck(){document.getElementById("dcProtection").checked?(document.getElementsByClassName("formgroup")[2].style.display="block",document.getElementsByClassName("formgroup")[3].style.display="block"):(document.getElementsByClassName("formgroup")[2].style.display="none",document.getElementsByClassName("formgroup")[3].style.display="none")}document.getElementById("dcProtection").addEventListener("click",protectionCheck),protectionCheck();</script>
    </body>
</html>
