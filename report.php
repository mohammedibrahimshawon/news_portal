<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Upload</title>
</head>
<body>
    <h1>Upload Your Report</h1>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["reportFile"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is a actual file or fake file
        if (isset($_POST["submit"])) {
            $check = filesize($_FILES["reportFile"]["tmp_name"]);
            if ($check !== false) {
                echo "File is a valid file - " . $check["mime"] . ".<br>";
                $uploadOk = 1;
            } else {
                echo "File is not a valid file.<br>";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }

        // Check file size (5MB limit)
        if ($_FILES["reportFile"]["size"] > 5000000) {
            echo "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowed_types = ['pdf', 'doc', 'docx', 'txt'];
        if (!in_array($fileType, $allowed_types)) {
            echo "Sorry, only PDF, DOC, DOCX, and TXT files are allowed.<br>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["reportFile"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars(basename($_FILES["reportFile"]["name"])) . " has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }
    }
    ?>
    <form action="report.php" method="post" enctype="multipart/form-data">
        Select report to upload:
        <input type="file" name="reportFile" id="reportFile">
        <input type="submit" value="Upload Report" name="submit">
    </form>
</body>
</html>
