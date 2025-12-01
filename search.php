<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/templates/header.php';

?>

<div class="container py-5">
  <h2>Recherche</h2>
  <form action="results.php" method="get" class="row g-3">
    <div class="col-md-8">
      <input type="text" name="q" class="form-control" placeholder="Tapez un mot français, un caractère chinois ou pinyin" required>
    </div>
    <div class="col-md-2">
      <select name="direction" class="form-select">
        <option value="fr_to_ch">FR → CH</option>
        <option value="ch_to_fr">CH/Pinyin → FR</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-danger w-100">Rechercher</button>
    </div>
  </form>
</div>
</body>
</html>

<?php
require_once __DIR__ . '/templates/footer.php';
?>