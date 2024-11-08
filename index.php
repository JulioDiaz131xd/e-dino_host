<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="E-Dino es una plataforma de aprendizaje personalizada. Aprende a tu ritmo con nuestros planes de estudio flexibles.">
    <title>E-Dino</title>
    <link rel="stylesheet" href="./assets/css/style-index.css">
    <link rel="icon" href="./assets/images/logo.ico">
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.21/build/spline-viewer.js"></script>
</head>

<body>
    <?php
    include './includes/navbar.php';
    ?>
    <!-- Sección Header -->
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
    <main>
        <!-- Sección Hero -->
        <section class="hero fade-in-scroll">
            <!-- Render -->
            <script type="module" src="/assets/js/spline-viewer.js"></script>
            <spline-viewer id="spline-viewer" url="/assets/spline/robot_follow_cursor_for_landing_page.spline"></spline-viewer>
            <!-- End Render -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <button id="button-betas" onclick="window.location.href='./public/dashboard.php'">
                    <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                    </svg>
                    <p>Ir a mis cases!</p>
                    <span class="circle"></span>
                    <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                    </svg>
                </button>
            <?php else: ?>
                <button id="button-betas" onclick="window.location.href='./public/register.php'">
                    <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                    </svg>
                    <p>Registrate</p>
                    <span class="circle"></span>
                    <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                    </svg>
                </button>
            <?php endif; ?>
        </section>
        <!-- Sección Beneficios -->
        <section class="benefits slide-left-scroll">
            <h2>Beneficios de E-Dino</h2>
            <div class="benefit-item">
                <img src="./assets/images/benefit1.svg" alt="Beneficio 1">
                <h3>Estudio Flexible</h3>
                <p>Accede a los cursos y programas en cualquier momento, desde cualquier lugar.</p>
            </div>
            <div class="benefit-item">
                <img src="https://blog.comparasoftware.com/wp-content/uploads/2020/07/Soporte-Tecnico-presencial-1.png" alt="Beneficio 2">
                <h3>Soporte 24/7</h3>
                <p>Siempre tendrás asistencia, ya sea técnica o académica, en cualquier momento.</p>
            </div>
        </section>
        <!-- Sección Testimonios -->
        <section class="testimonials zoom-in-scroll">
            <h2>Lo que dicen nuestros usuarios</h2>
            <div class="testimonial-item">
                <img src="./assets/images/user1.jpg" alt="Usuario 1">
                <blockquote>“E-Dino cambió mi forma de aprender. Puedo ajustar mi horario de estudio y avanzar a mi propio ritmo.”</blockquote>
                <h4>Juan Pérez</h4>
                <span>Estudiante</span>
            </div>
            <div class="testimonial-item">
                <img src="./assets/images/user2.jpg" alt="Usuario 2">
                <blockquote>“La plataforma es intuitiva y fácil de usar. Estoy muy satisfecho con el contenido y la forma en que se presenta.”</blockquote>
                <h4>María López</h4>
                <span>Docente</span>

            </div>
        </section>
        <!-- Sección Call to Action -->
        <section class="cta slide-right-scroll">
            <h2>Únete hoy</h2>
            <p>No pierdas la oportunidad de ser parte de la revolución educativa. ¡Inscríbete ahora!</p>
           <center><button class="ui-btn" onclick="window.location.href='./public/register.php'">
                <span>
                    Empezar
                </span>
            </button>
            </center> 
        </section>
    </main>
    <?php include './includes/footer.php'; ?>
    <script src="./assets/js/scripts.js">
    </script>
</body>

</html>