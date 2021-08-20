<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>RML Baseball</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/bs4_backgrounds.css" type="text/css" />
    <link rel="stylesheet" href="css/bs4_base.css" type="text/css" />
    <link rel="stylesheet" href="css/bs4_borders.css" type="text/css" />
    <link rel="stylesheet" href="css/bs4_display.css" type="text/css" />
    <link rel="stylesheet" href="css/bs4_flexbox.css" type="text/css" />
    <link rel="stylesheet" href="css/bs4_float_position_overflow.css" type="text/css" />
    <link rel="stylesheet" href="css/bs4_margins_padding.css" type="text/css" />
    <link rel="stylesheet" href="css/bs4_sizing.css" type="text/css" />
    <link rel="stylesheet" href="css/bs4_tables.css" type="text/css" />
    <link rel="stylesheet" href="css/bs4_text.css" type="text/css" />
    <link rel="stylesheet" href="css/main.css?v=1.4" type="text/css" />
    <link rel="stylesheet" href="css/my_base.css?v1.2" type="text/css" />
</head>

<body>
    <div class="wrapper">
        <header class="header">
            <div class="headerLeft">
                <h1 class="heading">
                    <a href="index.php" class="logoText">RML Baseball</a>
                </h1>
                <p class="subHeading">
                    <span class="subHeadingIcon">Since 1978</span>
                </p>
            </div>
            <div class="headerRight">
            <?php
            $query_contact = $conn->query("SELECT contact_email FROM settings WHERE setting_id=1");
            $result_contact = $query_contact->fetch_assoc();
            echo '<div><span class="headerRightItems"><a href="index.php">home</a></span><span class="headerRightItems"><a href="mailto:' . $result_contact['contact_email'] . '">contact us</a></span></div>';
            $query_contact->free_result();
            if ($user->data['user_id'] == ANONYMOUS) {
                echo '<div><span class="headerRightItems"><a href="login.php">login</a></span></div>';
            } else {
                echo '<div>logged in as: ' . $user->data['username_clean'] . ' &nbsp;&nbsp;| <span class="headerRightItems"><a href="logout.php">logout</a></span></div>';
            }
            ?>
            </div>
        </header>