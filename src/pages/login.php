<?php
session_start();
include "../config/config.php";
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>K-REC | Login</title>
    <!-- Link CSS Tailwind -->
    <link rel="stylesheet" href="../css/style.css" />
    <!-- <link rel="icon" href="../images/ea-logo.png" /> -->
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('../images/bg-drama.png');">
    <div class="min-h-screen bg-black/60 flex items-center justify-center px-4">

        <div class="bg-white/95 backdrop-blur-md shadow-2xl rounded-2xl w-full max-w-md p-8">
            <h2 class="text-3xl font-bold text-center text-pink-600 mb-6">🎬 K-REC Login</h2>
            <p class="text-gray-500 text-center mb-8">Masuk untuk melihat rekomendasi drama favoritmu</p>

            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Username</label>
                    <input type="text" name="username"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none"
                        placeholder="Masukkan username" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none"
                        placeholder="Masukkan password" required>
                </div>

                <button type="submit" name="login"
                    class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-md">
                    Login
                </button>
            </form>

            <p class="text-center text-gray-400 text-sm mt-8">
                © <?= date('Y') ?> K-REC — Sistem Rekomendasi K-Drama
            </p>
        </div>
    </div>
</body>

</html>

<?php
if (isset($_POST["login"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];

	$ambil = $config->query("SELECT * FROM user 
        WHERE username='$username' AND password='$password' ");

	$user = $ambil->fetch_assoc();

	if (empty($user)) {
		echo "<script>alert('Login gagal! Periksa username & password.')</script>";
		echo "<script>location='login.php'</script>";
	} else {
		$_SESSION['user'] = $user;
		echo "<script>alert('Login berhasil!')</script>";
		echo "<script>location='dashboard.php'</script>";
	}
}
?>