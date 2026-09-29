<?php /** Shop — in scope: $t, $base, $lang */ ?>

<section class="section-head">
  <h1><?= htmlspecialchars($t['page.shop.title']) ?></h1>
  <p><?= htmlspecialchars($t['page.shop.body']) ?></p>
</section>

<div class="shop-note">
  <span><span class="dot"></span><?= htmlspecialchars($t['shop.note.cod']) ?></span>
  <span><span class="dot"></span><?= htmlspecialchars($t['shop.note.world']) ?></span>
  <span><span class="dot"></span><?= htmlspecialchars($t['shop.note.pilot']) ?></span>
</div>

<ul id="products" class="products"
    data-products="/assets/data/products.json"
    data-lang="<?= htmlspecialchars($lang) ?>"
    data-currency="<?= htmlspecialchars($t['shop.currency']) ?>"
    data-add="<?= htmlspecialchars($t['shop.add']) ?>"
    aria-live="polite"></ul>

<div id="basket" class="basket-bar" aria-label="Order list">
  <div class="basket-inner">
    <p class="basket-info" id="basket-info"></p>
    <div class="basket-actions">
      <button class="btn btn-ghost btn-sm" id="basket-clear"><?= htmlspecialchars($t['shop.basket.clear']) ?></button>
      <button class="btn btn-whatsapp btn-sm" id="basket-send"><?= htmlspecialchars($t['shop.basket.send']) ?></button>
    </div>
  </div>
</div>
