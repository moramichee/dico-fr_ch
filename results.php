<?php 
// search_results.php (ou le nom que tu utilises)

// Charge la configuration (connexion PDO, session, constantes…)
require_once __DIR__ . '/config.php';

// Charge l'en-tête HTML commun (template)
require_once __DIR__ . '/templates/header.php';

// Récupère le paramètre GET "q" (la recherche), nettoyé des espaces
$q = trim($_GET['q'] ?? '');

// Récupère le sens de traduction choisi : fr_to_ch ou ch_to_fr
$direction = ($_GET['direction'] ?? 'fr_to_ch');

// Si la recherche est vide, on renvoie l'utilisateur à la page de recherche
if ($q === '') {
    header('Location: /search.php');
    exit;
}

// Tableau qui contiendra les résultats
$results = [];

// Recherche FR → CH
if ($direction === 'fr_to_ch') {
    $stmt = $pdo->prepare(
        'SELECT * FROM mots_fr
         WHERE mot LIKE :q OR traduction_ch LIKE :q
         LIMIT 50'
    );
    $stmt->execute([':q' => "%$q%"]);
    $results = $stmt->fetchAll();
} else { // Recherche CH → FR
    $stmt = $pdo->prepare(
        'SELECT * FROM mots_ch
         WHERE caractere LIKE :q OR pinyin LIKE :q OR traduction_fr LIKE :q
         LIMIT 50'
    );
    $stmt->execute([':q' => "%$q%"]);
    $results = $stmt->fetchAll();
}
?>

<div class="container py-5 d-flex flex-column align-items-center">

  <!-- Lien pour refaire une recherche -->
  <a href="search.php" class="btn btn-outline-primary mb-4 text-center">← Nouvelle recherche</a>

  <!-- Titre affichant la recherche + direction -->
  <h3 class="mb-4 text-center">
    Résultats pour : <span class="text-primary"><?= e($q) ?></span>
    <span class="badge bg-secondary ms-2"><?= $direction === 'fr_to_ch' ? 'FR → CH' : 'CH → FR' ?></span>
  </h3>

  <?php if (empty($results)): ?>
    <div class="alert alert-warning text-center">Aucun résultat trouvé.</div>
  <?php else: ?>
    <div class="row justify-content-center g-4 w-100">
      <?php foreach ($results as $row): ?>
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 d-flex justify-content-center">
          <div class="card h-100 shadow-sm border-0 result-card text-center">
            <div class="card-body d-flex flex-column align-items-center">

              <!-- Bloc texte -->
              <?php if ($direction === 'fr_to_ch'): ?>
                <h5 class="card-title">
                  <?= e($row['mot']) ?> →
                  <?= e($row['traduction_ch']) ?>
                  <small class="text-muted d-block"><?= e($row['pinyin']) ?></small>
                </h5>

                <?php if (!empty($row['exemple_fr']) || !empty($row['exemple_ch']) || !empty($row['exemple_pinyin'])): ?>
                  <p class="mb-1"><strong>FR :</strong> <?= e($row['exemple_fr']) ?></p>
                  <p class="mb-1"><strong>ZH :</strong> <?= e($row['exemple_ch']) ?></p>
                  <p class="mb-1"><strong>Pinyin :</strong> <?= e($row['exemple_pinyin']) ?></p>
                <?php endif; ?>

                <div class="mt-auto">
                  <h3><label class="form-label small">Noter ce résultat :</label></h3>
                  <div class="rating d-flex gap-1 flex-wrap justify-content-center" data-id="<?= (int)$row['id'] ?>" data-type="fr">
                    <?php for ($i=1; $i<=5; $i++): ?>
                      <button class="btn btn-sm btn-outline-secondary rate mb-1" data-value="<?= $i ?>"><?= $i ?></button>
                    <?php endfor; ?>
                  </div>
                  <div class="rating-message mt-1 small text-success"></div>
                </div>

              <?php else: ?>
                <h5 class="card-title">
                  <?= e($row['caractere']) ?> 
                  <small class="text-muted"><?= e($row['pinyin']) ?></small>
                  → <?= e($row['traduction_fr']) ?>
                </h5>

                <?php if (!empty($row['exemple_fr']) || !empty($row['exemple_ch']) || !empty($row['exemple_pinyin'])): ?>
                  <p class="mb-1"><strong>FR :</strong> <?= e($row['exemple_fr']) ?></p>
                  <p class="mb-1"><strong>ZH :</strong> <?= e($row['exemple_ch']) ?></p>
                  <p class="mb-1"><strong>Pinyin :</strong> <?= e($row['exemple_pinyin']) ?></p>
                <?php endif; ?>

                <div class="mt-auto">
                  <h3><label class="form-label small">Noter ce résultat :</label></h3>
                  <div class="rating d-flex gap-1 flex-wrap justify-content-center" data-id="<?= (int)$row['id'] ?>" data-type="ch">
                    <?php for ($i=1; $i<=5; $i++): ?>
                      <button class="btn btn-sm btn-outline-secondary rate mb-1" data-value="<?= $i ?>"><?= $i ?></button>
                    <?php endfor; ?>
                  </div>
                  <div class="rating-message mt-1 small text-success"></div>
                </div>
              <?php endif; ?>

            </div>

            <!-- Bloc image dictionnaire -->
            <div class="card-footer bg-transparent text-center">
              <img src="assets/img/dico.jpg" alt="Dictionnaire" class="img-fluid" style="max-height:60px; width:auto;">
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<style>
/* Cards design */
.result-card {
    border-radius: 12px;
    transition: transform 0.3s, box-shadow 0.3s;
}
.result-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Rating buttons hover */
.rating .rate:hover {
    background-color: #0d6efd !important;
    color: #fff !important;
}

/* Animation fade + slide pour les cartes */
.card {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeSlideUp 0.5s forwards;
}
@keyframes fadeSlideUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive tweaks */
@media (max-width: 576px) {
    .card-body p {
        font-size: 0.9rem;
    }
    .rating .rate {
        flex: 1 1 18%;
    }
}
@media (max-width: 768px) {
    .card-body h5 {
        font-size: 1rem;
    }
    .rating .rate {
        flex: 1 1 15%;
    }
}
</style>

<script>
$(document).ready(function() {
    // Animation fade des cartes
    $('.result-card').each(function(index){
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
});
</script>

<?php
// Charge le pied de page HTML
require_once __DIR__ . '/templates/footer.php';
?>
