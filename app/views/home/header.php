<header class="bg-dark py-1">
  <div class="container">
    <ul class="nav justify-content-center">
      <?php if(!empty($categorys)): ?>
        <?php foreach($categorys as $cate): ?>
          <li class="nav-item mx-3">
            <a class="nav-link text-white fw-bold text-uppercase" href="index.php?page=categoty&category=<?= urlencode($cate['name']); ?>"><?php echo $cate["name"]; ?></a>
          </li>
        <?php endforeach; ?>
        <?php endif; ?>
    </ul>
  </div>
</header>
