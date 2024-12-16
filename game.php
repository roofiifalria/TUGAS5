<?php
session_start();

// Jika belum ada angka rahasia, buat satu
if (!isset($_SESSION['angka_rahasia'])) {
    $_SESSION['angka_rahasia'] = rand(1, 100);
    $_SESSION['percobaan'] = 0;
}

// Proses tebakan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tebakan = intval($_POST['tebakan']);
    $_SESSION['percobaan']++;

    if ($tebakan == $_SESSION['angka_rahasia']) {
        $pesan = "Selamat! Anda menebak dengan benar dalam {$_SESSION['percobaan']} percobaan.";
        session_destroy(); // Reset permainan
    } elseif ($tebakan < $_SESSION['angka_rahasia']) {
        $pesan = "Terlalu rendah! Coba lagi.";
    } else {
        $pesan = "Terlalu tinggi! Coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Permainan Tebak Angka</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .message {
            margin-top: 20px;
            font-weight: bold;
        }
        .success { color: green; }
        .hint { color: blue; }
        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>Permainan Tebak Angka</h1>
    
    <?php if (isset($pesan)): ?>
        <div class="message <?php echo ($tebakan == $_SESSION['angka_rahasia']) ? 'success' : 'hint'; ?>">
            <?php echo $pesan; ?>
        </div>
    <?php endif; ?>

    <?php if ($tebakan != $_SESSION['angka_rahasia']): ?>
        <form action="game.php" method="post">
            <input type="number" name="tebakan" placeholder="Masukkan tebakan Anda (1-100)" required min="1" max="100">
            <button type="submit">Tebak!</button>
        </form>
    <?php else: ?>
        <a href="index.html">Mulai Permainan Baru</a>
    <?php endif; ?>
</body>
</html>
