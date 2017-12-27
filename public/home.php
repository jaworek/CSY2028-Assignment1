<section>
    <article>
        <?php

        if (isset($_SESSION['email'])) {
            echo '<p>You are logged in as: ' . $_SESSION['email'] . '</p>';
            echo '<p>Today is: ' . date('d/m/Y') . '</p>';
        }

        ?>
    </article>
</section>
