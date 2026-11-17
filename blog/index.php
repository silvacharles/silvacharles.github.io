<?php
function Redirecionar_URL($url = null){
    if(!$url)
        $url = $_SERVER['SCRIPT_NAME'];
    echo '<script type="text/javascript">
            <!--
            location.href = "'.$url.'";
            //-->
          </script>';
    exit;
}

// Redirecionar com mensagem animada
$redirectUrl = 'https://blog.rootsys.com.br';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3;url=<?php echo $redirectUrl; ?>">
    <title>Redirecionando...</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .container {
            text-align: center;
            padding: 2rem;
        }
        .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }
        p {
            font-size: 1.1rem;
            opacity: 0.8;
            margin-bottom: 1.5rem;
            opacity: 0;
            animation: fadeInUp 0.6s ease 0.2s forwards;
        }
        .progress-bar {
            width: 200px;
            height: 4px;
            background: rgba(255,255,255,0.2);
            border-radius: 2px;
            margin: 0 auto;
            overflow: hidden;
            opacity: 0;
            animation: fadeInUp 0.6s ease 0.4s forwards;
        }
        .progress-fill {
            height: 100%;
            background: white;
            width: 0%;
            border-radius: 2px;
            animation: progress 2.5s ease forwards;
        }
        @keyframes progress {
            to { width: 100%; }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .dots::after {
            content: '';
            animation: dots 1.5s infinite;
        }
        @keyframes dots {
            0%, 20% { content: ''; }
            40% { content: '.'; }
            60% { content: '..'; }
            80%, 100% { content: '...'; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="spinner" aria-hidden="true"></div>
        <h1>Redirecionando</h1>
        <p>Você será redirecionado em <span class="dots"></span></p>
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
        <p style="margin-top: 1.5rem; font-size: 0.9rem; opacity: 0.6;">
            Se não for redirecionado automaticamente, <a href="<?php echo $redirectUrl; ?>" style="color: white; text-decoration: underline;">clique aqui</a>.
        </p>
    </div>
    <script>
        // Redirecionamento via JavaScript após 3 segundos
        setTimeout(function() {
            window.location.href = '<?php echo $redirectUrl; ?>';
        }, 3000);
    </script>
</body>
</html>
<?php
// Fallback caso o HTML não carregue
Redirecionar_URL($redirectUrl);
?>