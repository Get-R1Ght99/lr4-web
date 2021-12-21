<header>
    <div class="wrapper">
        <div class="header">
            <div class="header-row">
                <a href="http://edushare.lr4/" class="logo">
                    <div class="logo__img">
                        <img src="Img/Logo.png" alt="logo">
                    </div>
                    <div class="logo__text">EduShare</div>
                </a>
                <?php if ($_SESSION['user'] == null) : ?>
                    <button id="openAuthForm_button" class="login-button">Войти</button>
                <?php else : ?>
                    <a href="logout.php" class="login-button">Выйти</a>
                <?php endif; ?>
            </div>
            <?php if ($_SESSION['user'] != null) : ?>
                <div class="header-row header-row_welcome">
                    <div class="header-row__welcome-text">Здравствуйте, <?= $_SESSION['user']['name']; ?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>