<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>PHP Deletion Page</title>
</head>
<body>
    <h3 style="display:inline;">Type a filename or directory to delete:</h3>
    <a href="javascript:showInstructions();" style="color:black;text-decoration:none;"><p><i>Note: Directories with sub-directories cannot be deleted. Click for more instructions.</i></p></a>
    <div id="instructions" style="display:none;">
        <p style="display:inline;">To delete a file you must type the full filename and extension. Do not type an extension or forward slash when deleting directories, only the directory name.<br>
        For safety reasons, the text input deliberately has no autocomplete. This is to ensure purposeful intent when deleting files or directories.<br>
        You must have correct permissions assigned to the file or directory you wish to delete. Change permissions to allow everyone to read/write.<br>
        Upon deletion of a directory, an error message saying "no such file or directory" will appear. This is normal. The directory has in fact been deleted.</p><br>
        <p style="display:inline; color:red;">Warning: While the filesystem innodes ( .  and  .. ) are listed and can be deleted, doing so will delete either everything in the current directory or everything in the parent directory. This is not advised.</p><br><br>
    </div>
    <!-- Form to type filename or directory to delete -->
    <form action="" id="deletionForm" method="post" onsubmit="checkChoice()" autocomplete="off">        
        <input type="text" name="filepath" id="filepath">
        <input type="submit" value="Delete" name="submit">
    </form>
    <br>
    <h3 style="display:inline;">Current working directory contents:</h3>
    <br>
    <?php
    // List files in current working directory
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

    // Process form and delete files
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
        // Confirmation prompt after form submission
        function checkChoice() {
            var x = document.getElementById("deletionForm").elements[0].value;
            return confirm('WARNING!\nYou are about to delete ' + x + '\nIf this is the wrong file or directory, close the tab now!\nClicking cancel will not stop the deletion!');
        }
        // Show/hide instructions
        function showInstructions() {
            var x = document.getElementById("instructions");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
</body>
