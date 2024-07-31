<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = date('Y-m-d');

    $sql = "INSERT INTO news (title, content, date) VALUES ('$title', '$content', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "News uploaded successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
