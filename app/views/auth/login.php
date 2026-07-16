<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - FreshJuice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
  
        body { background-color: #f0f7f4; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; margin: 0; padding: 20px; box-sizing: border-box; }
        
        /* Layout Card */
        .auth-card { background: white; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); overflow: hidden; max-width: 900px; width: 100%; min-height: 550px; display: flex; }
        
        .left-panel { background: #a8d5ba; color: white; padding: 60px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; width: 40%; }
        
        .right-panel { padding: 60px; display: flex; flex-direction: column; justify-content: center; width: 60%; }
        
        /* Tombol & Form */
        .btn-green-pastel { background-color: #82b998; border: none; color: white; padding: 12px; border-radius: 10px; font-weight: 600; }
        .btn-green-pastel:hover { background-color: #6da583; color: white; }
        .btn-outline-pastel { border: 2px solid white; color: white; border-radius: 25px; padding: 8px 30px; text-decoration: none; transition: 0.3s; }
        .btn-outline-pastel:hover { background-color: white; color: #a8d5ba; }
        
        .form-control { border-radius: 10px; padding: 15px; border: 1px solid #e1e1e1; background: #f9f9f9; }
        .form-control:focus { border-color: #a8d5ba; box-shadow: 0 0 0 0.2rem rgba(168, 213, 186, 0.25); }

        /* responsive */
        @media (max-width: 768px) {
            .auth-card {
                flex-direction: column; 
                min-height: auto;
            }
            .left-panel, .right-panel {
                width: 100%; 
                padding: 40px 30px; 
            }
            .left-panel {
                order: 2; 
            }
            .right-panel {
                order: 1; 
            }
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="left-panel">
        <h2 class="fw-bold mb-3">Hey There!</h2>
        <p class="mb-4">Welcome Back.<br>You are just one step away to your refreshing juice.</p>
        <p class="small mb-3">Don't have an account?</p>
        <a href="index.php?action=register" class="btn btn-outline-pastel">Sign Up</a>
    </div>

    <div class="right-panel">
        <h3 class="fw-bold mb-4">SIGN IN</h3>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger small"><?= $error ?></div>
        <?php endif; ?>

        <form action="index.php?action=process_login" method="POST">
            <div class="mb-3">
                <label class="form-label text-muted small">Email</label>
                <input type="email" name="email" class="form-control" placeholder="JohnDoe@gmail.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-muted small">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="d-flex justify-content-between mb-4 small">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="check">
                    <label class="form-check-label text-muted" for="check">Keep me logged in</label>
                </div>
                <a href="#" class="text-decoration-none" style="color: #82b998;">Forgot Password?</a>
            </div>
            <button type="submit" class="btn btn-green-pastel w-100 mb-4">Sign In</button>
        </form>

        <div class="text-center text-muted small">Or, Use social media to sign in</div>
        <div class="text-center mt-3">
            <a href="#" class="text-secondary mx-2"><i class="fab fa-facebook fa-lg"></i></a>
            <a href="#" class="text-secondary mx-2"><i class="fab fa-twitter fa-lg"></i></a>
            <a href="#" class="text-secondary mx-2"><i class="fab fa-linkedin fa-lg"></i></a>
        </div>
    </div>
</div>

</body>
</html>