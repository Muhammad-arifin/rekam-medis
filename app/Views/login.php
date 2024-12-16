<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <img src="<?= base_url('images/gambar.png'); ?>" alt="Login Photo">
        </div>
        <div class="login-right">
            <div class="login-form">
                <h2>Login</h2>
                <?php if (session()->getFlashdata('error')): ?>
                    <p class="error"><?= session()->getFlashdata('error'); ?></p>
                <?php endif; ?>
                <form action="<?= base_url('auth/authenticate'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                    
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                    
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
