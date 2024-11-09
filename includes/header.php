<header class="header">
        <div class="header-container">
            <a href="/../index.php" class="logo">E-Dino</a>
            <div class="header-buttons">
                <button id="theme-toggle" class="header-btn">
                    <img id="theme-icon" src="/assets/images/dark-icon.png" alt="/assets/images/dark-icon.png" />
                </button>
                <p class="component-title"></p>
                <div class="container">
                    <input type="checkbox" class="checkbox" id="checkbox">
                    <label class="switch" for="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>
                <?php
                $currentPage = basename($_SERVER['PHP_SELF']);
                if (!in_array($currentPage, ['login.php', 'register.php'])):
                    if (isset($_SESSION['user_id'])): ?>
                        <form action="/public/logout.php" method="post" class="logout-form">
                            <button class="Btn">
                                <div class="sign"><svg viewBox="0 0 512 512">
                                        <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                                    </svg></div>
                                <div class="text">Logout</div>
                            </button>
                        </form>
                        <div class="user-info">
                            <span class="user-name"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                        </div>
                    <?php else: ?>
                        <button onclick="window.location.href='/../public/login.php'" class="header-btn">Sign in</button>
                        <button onclick="window.location.href='/../public/register.php'" class="header-btn">Sign up</button>
                <?php endif;
                endif; ?>
            </div>
        </div>
    </header>