<div class="tutor-wrapper">
  <?php if ($status): ?>
    <ul class="information">
      <?php foreach ($messages as $message): ?>
        <li class="information-message">
          <?php print $message; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <?php $form->render(); ?>
</div>