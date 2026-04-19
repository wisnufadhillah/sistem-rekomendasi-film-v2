<?php
session_start();
include "../config/config.php";

$id_user_login = $_SESSION['user']['id_user'];

// --- 1. Ambil drama yang sudah ditonton (rating > 0)
$ditonton = [];
$ambil = $config->query("
    SELECT * FROM nilai 
    LEFT JOIN item ON nilai.id_item=item.id_item 
    WHERE id_user='$id_user_login' AND isi_nilai > 0
");
while ($tiap = $ambil->fetch_assoc()) {
  $ditonton[] = $tiap;
}

// --- 2. Ambil drama yang belum ditonton (rating = 0)
$drama_belum = [];
$ambil = $config->query("
    SELECT * FROM nilai 
    LEFT JOIN item ON nilai.id_item=item.id_item 
    WHERE id_user='$id_user_login' AND isi_nilai=0
");
while ($tiap = $ambil->fetch_assoc()) {
  $drama_belum[] = $tiap;
}

// Jika ada drama yang belum ditonton, lakukan perhitungan
$hasilPrediksi = [];
if (!empty($drama_belum)) {
  // Ambil semua data rating
  $result = $config->query("SELECT * FROM nilai");
  $ratings = [];
  while ($row = $result->fetch_assoc()) {
    $ratings[$row['id_user']][$row['id_item']] = $row['isi_nilai'];
  }

  // Ambil daftar drama
  $items = $config->query("SELECT * FROM item");
  $itemList = [];
  while ($i = $items->fetch_assoc()) {
    $itemList[$i['id_item']] = $i['nama_item'];
  }

  // Fungsi cosine similarity antar item (drama)
  function cosine_similarity($ratings, $itemA, $itemB)
  {
    $sumXX = $sumYY = $sumXY = 0;
    foreach ($ratings as $user => $userRatings) {
      if (isset($userRatings[$itemA]) && isset($userRatings[$itemB])) {
        $x = $userRatings[$itemA];
        $y = $userRatings[$itemB];
        if ($x > 0 && $y > 0) {
          $sumXY += $x * $y;
          $sumXX += $x * $x;
          $sumYY += $y * $y;
        }
      }
    }
    if ($sumXX == 0 || $sumYY == 0) return 0;
    return $sumXY / (sqrt($sumXX) * sqrt($sumYY));
  }

  // Hitung similarity antar drama
  $similarity = [];
  foreach ($itemList as $i => $nameI) {
    foreach ($itemList as $j => $nameJ) {
      if ($i != $j) {
        $similarity[$i][$j] = cosine_similarity($ratings, $i, $j);
      }
    }
  }

  // Hitung prediksi rating untuk drama yang belum ditonton
  $userRatings = $ratings[$id_user_login];

  foreach ($drama_belum as $target) {
    $targetItem = $target['id_item'];
    $numerator = 0;
    $denominator = 0;

    foreach ($userRatings as $item => $rating) {
      if ($rating > 0 && isset($similarity[$targetItem][$item])) {
        $sim = $similarity[$targetItem][$item];
        $numerator += $sim * $rating;
        $denominator += abs($sim);
      }
    }

    $predicted = ($denominator == 0) ? 0 : $numerator / $denominator;
    $predicted = max(1, min(5, $predicted));

    $hasilPrediksi[] = [
      'id_item' => $target['id_item'],
      'nama_item' => $target['nama_item'],
      'poster_url' => $target['poster_url'],
      'prediksi' => round($predicted, 2)
    ];
  }

  // Urutkan rekomendasi dari yang tertinggi
  usort($hasilPrediksi, function ($a, $b) {
    return $b['prediksi'] <=> $a['prediksi'];
  });
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>K-REC | Dashboard</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>

<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-pink-600">🎬 K-Drama Recommender</a>

            <div class="flex items-center space-x-4">
                <span class="text-gray-500 text-sm">
                    Welcome, <span
                        class="font-semibold text-gray-700"><?php echo $_SESSION['user']['nama_user']; ?></span>
                </span>
                <a href="logout.php"
                    class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-full text-sm font-medium transition-all duration-300">
                    Logout
                </a>
            </div>
        </div>
    </nav>


    <!-- Rekomendasi -->
    <?php if (!empty($hasilPrediksi)): ?>
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-3xl font-semibold mb-8 text-pink-600 border-b pb-2">Rekomendasi Drama untuk Anda</h1>
            <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <?php foreach ($hasilPrediksi as $value): ?>
                <?php
            $imgPath = !empty($value['poster_url']) ? $value['poster_url'] : '../images/default.png';
            ?>
                <div
                    class="bg-gray-50 rounded-xl shadow hover:shadow-lg overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
                    <img src="<?= htmlspecialchars($imgPath) ?>" alt="<?= htmlspecialchars($value['nama_item']) ?>"
                        class="w-full h-64 object-cover">
                    <div class="p-4 text-center">
                        <h5 class="font-semibold text-lg mb-2 text-gray-700">
                            <?= htmlspecialchars($value['nama_item']) ?></h5>
                        <span
                            class="inline-block bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium"><?= $value['prediksi'] ?></span>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Drama yang sudah ditonton -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-3xl font-semibold mb-8 text-gray-700 border-b pb-2">Drama yang Sudah Anda Tonton</h1>
            <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <?php foreach ($ditonton as $value): ?>
                <?php
          $imgPath = !empty($value['poster_url']) ? $value['poster_url'] : '../images/default.png';
          ?>
                <div
                    class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
                    <img src="<?= htmlspecialchars($imgPath) ?>" alt="<?= htmlspecialchars($value['nama_item']) ?>"
                        class="w-full h-64 object-cover">
                    <div class="p-4 text-center">
                        <h5 class="font-semibold text-lg mb-2 text-gray-700">
                            <?= htmlspecialchars($value['nama_item']) ?></h5>
                        <span class="inline-block bg-pink-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                            <?= $value['isi_nilai'] ?>
                        </span>

                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>

</body>

</html>