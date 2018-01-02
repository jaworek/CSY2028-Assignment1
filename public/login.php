<article>
    <h3>Login</h3>
    <?php
    isLogged();
    login($database);
    ?>

    <form class="login" action="index.php?title=login" method="post">
        <label for="login">Email</label>
        <input id="login" type="email" name="login" placeholder="user@email.com">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="********">
        <div class="g-recaptcha" data-sitekey="6Lca2j4UAAAAABUiGsB5g1QZy6L9XFtO9aoXK__u"></div>
        <input type="submit" name="submit" value="Login">
    </form>
</article>
