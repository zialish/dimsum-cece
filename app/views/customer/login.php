<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dimsum Cece</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/style.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        .login-container { max-width: 400px; margin-top: 100px; }
        .register-container { max-width: 450px; margin-top: 60px; }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <h3 class="text-center mb-4 text-primary font-weight-bold">Dimsum Cece</h3>
            <h5 class="text-center text-muted mb-4">Silakan Login</h5>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error']; ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success']; ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/auth/login" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required autocomplete="off">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-pill mb-3">Masuk</button>
            </form>

            <div class="text-center">
                <p class="mb-0 text-muted">Belum punya akun? <a href="<?= BASEURL; ?>/auth/register" class="text-decoration-none">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="<?= BASEURL; ?>/../fruitables-1.0.0/js/main.js"></script>
</body>
</body>
</html>