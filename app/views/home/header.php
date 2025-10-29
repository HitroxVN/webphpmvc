<?php
$cateid = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>
<header class="bg-dark py-1">
  <div class="container">
    <ul class="nav justify-content-center">
      <?php if(!empty($categorys)): ?>
        <?php foreach($categorys as $cate): ?>
          <li class="nav-item mx-3">
            <a class="nav-link fw-bold text-uppercase <?php echo ($cateid === (int)$cate['id']) ? 'text-success border-bottom border-success' : 'text-white'; ?>" 
            href="index.php?page=category&id=<?php echo($cate['id']); ?>"><?php echo $cate["name"]; ?></a>
          </li>
        <?php endforeach; ?>
        <?php endif; ?>
    </ul>
  </div>
</header>
