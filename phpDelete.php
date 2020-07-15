<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>PHP Deletion Page</title>
</head>
<body>
    <form action="" id="deletionForm" method="post" onsubmit="checkChoice()">
        <h3 style="display:inline;">Enter filename or path of directory to destroy:</h3>
        <br>
        <br>
        <input type="text" name="filepath" id="filepath">
        <input type="submit" value="Delete" name="submit">
    </form>
    <br>
    <h3 style="display:inline;">Directory list:</h3>
    <br>
    <?php
    // List current files in directory
    $fileList = scandir(getcwd());
    for($i = 0; $i < sizeof($fileList); $i ++) {
        // if file is directory output it in red
        if(is_dir($fileList[$i])){
            echo("<p style='color:red;display:inline;'>" . $fileList[$i] . "</p>");
        } else {
            // if file is file output it in black
            echo("<p style='color:black;display:inline;'>" . $fileList[$i] . "</p>");
        }
        // create a new line after each file
       echo("<br>");
    }


    if(isset($_POST["submit"])) {
        function delete_files($target) {
            if(is_dir($target)){
                $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

                foreach( $files as $file ){
                    delete_files( $file );      
                }
                rmdir( $target );
            } elseif(is_file($target)) {
                unlink( $target );  
            }
        }
        delete_files($_POST["filepath"]);      
    }
    ?>
    <script>
        function checkChoice() {
        var x = document.getElementById("deletionForm").elements[0].value;
        return confirm('WARNING!\nYou are about to delete ' + x + '\nIf this is the wrong file or directory, close the tab now!\nClicking cancel will not stop the deletion!');
        }
    </script>
</body>
