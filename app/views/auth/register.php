<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - FreshJuice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        body { background-color: #f0f7f4; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; margin: 0; padding: 20px; box-sizing: border-box; }
        
        .auth-card { background: white; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); overflow: hidden; max-width: 900px; width: 100%; display: flex; }
        
        
        .left-panel { background: #a8d5ba; color: white; padding: 60px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; width: 40%; }
        
        
        .right-panel { padding: 50px; width: 60%; display: flex; flex-direction: column; justify-content: center; }
        
        .btn-green-pastel { background-color: #82b998; border: none; color: white; padding: 12px; border-radius: 10px; font-weight: 600; }
        .btn-green-pastel:hover { background-color: #6da583; color: white; }
        .btn-outline-pastel { border: 2px solid white; color: white; border-radius: 25px; padding: 8px 30px; text-decoration: none; transition: 0.3s; }
        .btn-outline-pastel:hover { background-color: white; color: #a8d5ba; }
        
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #e1e1e1; background: #f9f9f9; }

        /* responsive */
        @media (max-width: 768px) {
            .auth-card {
                flex-direction: column; 
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
        <h2 class="fw-bold mb-3">Welcome!</h2>
        <p class="mb-4">Join us and discover the best fresh juice tailored for your healthy lifestyle.</p>
        <p class="small mb-3">Already have an account?</p>
        <a href="index.php?action=login" class="btn btn-outline-pastel">Sign In</a>
    </div>

    <div class="right-panel">
        <h3 class="fw-bold mb-4">SIGN UP</h3>
        
        
        <?php if (isset($_GET['error']) && $_GET['error'] == 'telepon_tidak_valid'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Pendaftaran Gagal!</strong> Pastikan nomor telepon hanya berisi angka.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] == 'gagal_simpan'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Pendaftaran Gagal!</strong> Terjadi kesalahan pada sistem, coba lagi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <!-- Akhir dari tambahan Alert -->

        <form action="index.php?action=process_register" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small">No Telepon</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted small">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted small">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted small">Alamat Lengkap</label>
                <textarea name="address" class="form-control" rows="2" required></textarea>
            </div>

            <button type="submit" class="btn btn-green-pastel w-100">Sign Up</button>
        </form>
    </div>
</div>

<!-- Tambahan Script Bootstrap agar tombol close (X) pada alert bisa diklik -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>