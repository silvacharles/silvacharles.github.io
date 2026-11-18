<?php
// ================================
// DIAGNÓSTICO TÉCNICO DE REDE
// + GEOLOCALIZAÇÃO + ASN
// Compatível com PHP antigo
// ================================

// Função IP
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ipList[0]);
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['REMOTE_ADDR'];
    } else {
        return 'Desconhecido';
    }
}

$ip = getUserIP();
$hostname = php_uname('n');
$reverse_dns = @gethostbyaddr($ip);
$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Desconhecido';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "HTTPS" : "HTTP";
$port = isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : 'Desconhecida';
$proxy = (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) || !empty($_SERVER['HTTP_CLIENT_IP'])) ? "Possível uso de Proxy/VPN" : "Conexão direta";

// Detectar Sistema Operacional
function detectOS($user_agent) {
    $os_array = array(
        '/windows/i' => 'Windows',
        '/linux/i' => 'Linux',
        '/macintosh|mac os x/i' => 'Mac OS',
        '/android/i' => 'Android',
        '/iphone/i' => 'iOS',
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            return $value;
        }
    }
    return 'Desconhecido';
}

// Detectar Navegador
function detectBrowser($user_agent) {
    $browser_array = array(
        '/edge/i' => 'Microsoft Edge',
        '/chrome/i' => 'Google Chrome',
        '/firefox/i' => 'Mozilla Firefox',
        '/safari/i' => 'Safari',
        '/opera/i' => 'Opera',
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            return $value;
        }
    }
    return 'Desconhecido';
}

$os = detectOS($user_agent);
$browser = detectBrowser($user_agent);

// ================================
// GEOLOCALIZAÇÃO + ASN
// ================================
$geoData = @file_get_contents("http://ip-api.com/json/" . $ip);
$country = $city = $region = $isp = $asn = "Indisponível";

if ($geoData !== false) {
    $geo = json_decode($geoData, true);
    if ($geo && $geo['status'] == 'success') {
        $country = $geo['country'];
        $city = $geo['city'];
        $region = $geo['regionName'];
        $isp = $geo['isp'];
        $asn = isset($geo['as']) ? $geo['as'] : "Indisponível";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Diagnóstico Técnico de Rede</title>
<style>
body {
    background-color: #0f172a;
    color: #e2e8f0;
    font-family: Arial, sans-serif;
    padding: 40px;
}
.container {
    max-width: 900px;
    margin: auto;
    background: #1e293b;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.5);
}
h1 {
    text-align: center;
    color: #38bdf8;
}
.section-title {
    margin-top: 25px;
    color: #facc15;
}
.item {
    margin: 10px 0;
    padding: 10px;
    background: #0f172a;
    border-left: 4px solid #38bdf8;
}
.label {
    font-weight: bold;
    color: #94a3b8;
}
.value {
    color: #22c55e;
    word-wrap: break-word;
}
.footer {
    text-align: center;
    margin-top: 30px;
    font-size: 12px;
    color: #64748b;
}
</style>
</head>
<body>
<div class="container">
    <h1>Diagnóstico Técnico de Rede</h1>

    <div class="section-title">Conexão</div>
    <div class="item"><span class="label">IP Público:</span><br><span class="value"><?php echo htmlspecialchars($ip); ?></span></div>
    <div class="item"><span class="label">DNS Reverso:</span><br><span class="value"><?php echo htmlspecialchars($reverse_dns); ?></span></div>
    <div class="item"><span class="label">Protocolo:</span><br><span class="value"><?php echo $protocol; ?></span></div>
    <div class="item"><span class="label">Porta Remota:</span><br><span class="value"><?php echo $port; ?></span></div>
    <div class="item"><span class="label">Status da Conexão:</span><br><span class="value"><?php echo $proxy; ?></span></div>

    <div class="section-title">Dispositivo</div>
    <div class="item"><span class="label">Sistema Operacional:</span><br><span class="value"><?php echo $os; ?></span></div>
    <div class="item"><span class="label">Navegador:</span><br><span class="value"><?php echo $browser; ?></span></div>

    <div class="section-title">Geolocalização</div>
    <div class="item"><span class="label">País:</span><br><span class="value"><?php echo $country; ?></span></div>
    <div class="item"><span class="label">Região:</span><br><span class="value"><?php echo $region; ?></span></div>
    <div class="item"><span class="label">Cidade:</span><br><span class="value"><?php echo $city; ?></span></div>
    <div class="item"><span class="label">Operadora (ISP):</span><br><span class="value"><?php echo $isp; ?></span></div>
    <div class="item"><span class="label">ASN:</span><br><span class="value"><?php echo $asn; ?></span></div>

    <div class="footer">
        Ferramenta Profissional de Diagnóstico de Rede
    </div>
</div>
</body>
</html>