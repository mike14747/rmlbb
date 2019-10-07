<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>RML Baseball</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css?v=1.1" type="text/css" />
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <?php
            echo '<div class="headl"><a href="index.php"><img src="components/header/images/logo.gif" alt="RML Baseball" /></a></div>';
            $query_contact = $conn->query("SELECT contact_email FROM settings WHERE setting_id=1");
            $result_contact = $query_contact->fetch_assoc();
            echo '<p class="padding10r"><img src="components/header/images/arrow.gif" alt="RML Homepage" width="11" height="11" /><a href="index.php">home</a>&nbsp;&nbsp;&nbsp;&nbsp;<img src="components/header/images/arrow.gif" alt="Contact Us" width="11" height="11" /><a href="mailto:' . $result_contact['contact_email'] . '">contact us</a></p>';
            $query_contact->free_result();
            if ($user->data['user_id'] == ANONYMOUS) {
                echo '<p class="padding10r"><img src="components/header/images/arrow.gif" alt="Login" width="11" height="11" /><a href="login.php">login</a></p>';
            } else {
                echo '<p class="padding10r">logged in as: ' . $user->data['username_clean'] . ' &nbsp;| &nbsp;<a href="logout.php">logout</a></p>';
            }
            ?>
        </div>
        <div class="content">