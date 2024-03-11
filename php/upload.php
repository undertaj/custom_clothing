<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the file input is set and not empty
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        // Database connection parameters
        $servername = "localhost";
        $username = "admin";
        $password = "Boogie12@";
        $dbname = "clothing";

        // Create database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check database connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement
        $sql = "INSERT INTO images (name, image_data) VALUES (?, ?)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sb", $name, $imageData);

        // Set parameters
        $name = $_FILES["file"]["name"];
        $imageData = file_get_contents($_FILES["file"]["tmp_name"]);

        // Execute SQL statement
        if ($stmt->execute()) {
            echo "File uploaded successfully and stored in the database.";
        } else {
            echo "Error uploading file and storing in the database: " . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "No file uploaded or an error occurred.";
    }
} else {
    // If the form is not submitted via POST request, redirect the user
    header("Location: index.html");
    exit;
}
?>
