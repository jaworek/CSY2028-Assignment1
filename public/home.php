<article>
    <h3>Home</h3>
    <?php
    ob_start();
    ?>

    <p>These accounts can be used as showcase of the system:</p>
    <p>Admin:</p>
    <ul>
        <li>Email: admin@admin.com</li>
        <li>Password: admin</li>
    </ul>
    <p>User:</p>
    <ul>
        <li>Email: user@user.com</li>
        <li>Password: user</li>
    </ul>

    <?php
    $welcomeMsg = ob_get_clean();
    if (isset($_SESSION['email'])) {
        echo '<p>You are logged in as: ' . $_SESSION['email'] . '</p>';
        echo '<p>Today is: ' . date('d/m/Y') . '</p>';
    } else {
        echo $welcomeMsg;
    }

    ?>
</article>
