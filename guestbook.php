<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $data = array(
            'name' => $name,
            'email' => $email,
            'message' => $message
        );

        $jsonString = json_encode($data);
        $fileStream = fopen('guestbook.json', 'a');
        fwrite($fileStream, $jsonString . "\n");
        fclose($fileStream);

        header('Location: guestbook.php');
        exit();
    }
}

?>
<!DOCTYPE html>
<html>
<?php require_once 'sectionHead.php'; ?>
<body>
<div class="container">
    <?php require_once 'sectionNavbar.php'; ?>
    <br>

    <div class="card card-primary">
        <div class="card-header bg-primary text-light">
            GuestBook form
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <form method="POST" action="guestbook.php">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea class="form-control" id="message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card card-primary">
        <div class="card-header bg-body-secondary text-dark">
            Comments
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    if (file_exists('guestbook.json')) {
                        $fileStream = fopen('guestbook.json', 'r');
                        while (!feof($fileStream)) {
                            $jsonString = fgets($fileStream);
                            $data = json_decode($jsonString, true);
                            if (!empty($data)) {
                                echo '<div class="card mb-3">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . $data['name'] . '</h5>';
                                echo '<h6 class="card-subtitle mb-2 text-muted">' . $data['email'] . '</h6>';
                                echo '<p class="card-text">' . $data['message'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        fclose($fileStream);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
