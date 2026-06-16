<?php
// 1. Load the map from the PHP array (OPcache handles the memory part)
$map = include(__DIR__ . '/map.php');

// Get the slug from the URL path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$slug = trim($path, '/');

// REDIRECT LOGIC
if (!empty($slug) && isset($map[$slug])) {
    header("Location: " . $map[$slug], true, 302);
    exit;
}

// DISPLAY LOGIC (If no ID or ID not found)
?>
<!DOCTYPE html>
<html>

<head>
    <title>QR Link Manager</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            line-height: 1.6;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .card {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        code {
            background: #eee;
            padding: 2px 4px;
        }
    </style>
</head>

<body>
    <h1>Active Redirects</h1>
    <div class="grid">
        <?php foreach ($map as $slug => $url):
            $fullUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/$slug";
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?format=svg&data=" . urlencode($fullUrl);
            ?>
            <div class="card">
                <strong>/<?php echo htmlspecialchars($slug); ?></strong><br>
                <img src="<?php echo $qrUrl; ?>" alt="QR Code"><br>
                <small>Points to:<br><code><?php echo htmlspecialchars($url); ?></code></small>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>`