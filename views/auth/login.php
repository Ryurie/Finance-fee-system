<?php
// views/auth/login.php
session_start();

// ==========================================================
// THE BOUNCER: Kapag naka-login na, bawal na dito!
// I-re-redirect natin sila pabalik sa kani-kanilang dashboard.
// ==========================================================
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    if ($role === 'admin') {
        header("Location: ../admin/dashboard.php");
        exit;
    } elseif ($role === 'registrar') {
        header("Location: ../registrar/dashboard.php");
        exit;
    } elseif ($role === 'faculty') {
        header("Location: ../faculty/dashboard.php");
        exit;
    } elseif ($role === 'student') {
        header("Location: ../student/dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHCC Finance - Secure Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        /* =========================================
           MODERN GLASSMORPHISM CSS ✨
           ========================================= */
        :root {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --bg-dark: #0f172a;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body, html {
            margin: 0; padding: 0; font-family: 'Inter', sans-serif; height: 100vh; width: 100%;
            background-color: var(--bg-dark); overflow: hidden; display: flex;
            justify-content: center; align-items: center; position: relative;
        }

        /* ✨ EXIT ANIMATION MAGIC ✨ */
        .page-exit {
            animation: pageExit 0.6s cubic-bezier(0.8, 0, 0.2, 1) forwards;
            pointer-events: none;
        }
        @keyframes pageExit {
            0% { opacity: 1; transform: scale(1); filter: blur(0); }
            100% { opacity: 0; transform: scale(1.05); filter: blur(10px); }
        }

        /* Abstract Floating Background Shapes */
        .shape { position: absolute; filter: blur(60px); z-index: 1; opacity: 0.6; animation: float 8s ease-in-out infinite; }
        .shape-1 { width: 400px; height: 400px; background: #3b82f6; top: -100px; left: -100px; border-radius: 50%; }
        .shape-2 { width: 300px; height: 300px; background: #8b5cf6; bottom: -50px; right: -50px; border-radius: 50%; animation-delay: -4s; }
        .shape-3 { width: 250px; height: 250px; background: #10b981; bottom: 20%; left: 20%; border-radius: 50%; animation-duration: 10s; }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
            100% { transform: translateY(0px) scale(1); }
        }

        /* Glassmorphism Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 3rem 2.5rem; border-radius: 20px; width: 100%; max-width: 400px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); z-index: 10;
            position: relative; transform: translateY(20px); opacity: 0;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideUp { to { transform: translateY(0); opacity: 1; } }

        .input-group { margin-bottom: 1.5rem; position: relative; }
        .input-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.85rem; color: var(--text-main); }
        .input-group input { width: 100%; padding: 0.85rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; font-family: inherit; box-sizing: border-box; background: #f8fafc; transition: all 0.3s ease; }
        .input-group input:focus { outline: none; border-color: var(--primary); background: #ffffff; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }

        .btn-login { width: 100%; padding: 0.9rem; background: linear-gradient(135deg, var(--primary) 0%, #60a5fa 100%); color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3); margin-top: 1rem; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.4); filter: brightness(1.05); }
        .btn-login:active { transform: translateY(0); }

        #error-msg { display: none; background: #fee2e2; color: #991b1b; padding: 0.75rem; border-radius: 6px; font-size: 0.85rem; margin-bottom: 1.5rem; text-align: center; border: 1px solid #fca5a5; font-weight: 500; }
        .login-footer { text-align: center; margin-top: 2rem; font-size: 0.8rem; color: var(--text-muted); }
    </style>
</head>
<body>

    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>

    <div class="login-card">
        
        <div class="logo-container" style="display: flex; flex-direction: column; align-items: center; margin-bottom: 2.5rem;">
            
            <div style="width: 65px; height: 65px; background: linear-gradient(135deg, var(--primary), #8b5cf6); border-radius: 18px; display: flex; justify-content: center; align-items: center; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4); margin-bottom: 1rem; transform: rotate(-10deg);">
                <span style="color: white; font-weight: 900; font-size: 2.2rem; font-family: 'Inter', sans-serif; transform: rotate(10deg);">CH</span>
            </div>
            
            <h1 style="margin: 0; font-size: 1.8rem; color: var(--text-main); letter-spacing: -0.5px; font-weight: 900;">
                CHCC <span style="color: var(--primary);">FINANCE</span>
            </h1>
            <p style="margin: 0.5rem 0 0; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">
                System Portal
            </p>
        </div>

        <div id="error-msg"></div>

        <form id="loginForm">
            <div class="input-group">
                <label for="username">Email or Student No.</label>
                <input type="text" id="username" name="username" placeholder="Enter your registered email/ID" required autocomplete="username">
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            </div>

            <button type="submit" class="btn-login" id="loginBtn">Secure Login</button>
        </form>

        <div class="login-footer">
            &copy; <?php echo date('Y'); ?> CHCC Finance System.<br>Authorized Personnel & Students Only.
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const btn = document.getElementById('loginBtn');
            const errorBox = document.getElementById('error-msg');
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            btn.innerHTML = 'Authenticating...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';
            errorBox.style.display = 'none';

            try {
                const response = await fetch('../../api/auth/login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ username, password })
                });

                const result = await response.json();

                if (result.success) {
                    btn.innerHTML = 'Success! Redirecting...';
                    btn.style.background = 'linear-gradient(135deg, #10b981 0%, #34d399 100%)';
                    
                    // ✨ HAKBANG 1: I-trigger ang Exit Animation
                    setTimeout(() => {
                        document.body.classList.add('page-exit');
                        
                        // ✨ HAKBANG 2: Hintayin matapos ang animation bago lumipat ng pahina
                        setTimeout(() => {
                            if (result.role === 'admin') window.location.href = '../admin/dashboard.php';
                            else if (result.role === 'registrar') window.location.href = '../registrar/dashboard.php';
                            else if (result.role === 'faculty') window.location.href = '../faculty/dashboard.php';
                            else if (result.role === 'student') window.location.href = '../student/dashboard.php';
                            else window.location.reload();
                        }, 500); 

                    }, 600); 
                } else {
                    errorBox.innerHTML = '⚠️ ' + (result.message || 'Invalid credentials.');
                    errorBox.style.display = 'block';
                    btn.innerHTML = 'Secure Login';
                    btn.style.opacity = '1';
                    btn.style.pointerEvents = 'auto';
                }
            } catch (error) {
                errorBox.innerHTML = '⚠️ System error. Cannot connect to server.';
                errorBox.style.display = 'block';
                btn.innerHTML = 'Secure Login';
                btn.style.opacity = '1';
                btn.style.pointerEvents = 'auto';
            }
        });
    </script>
</body>
</html>