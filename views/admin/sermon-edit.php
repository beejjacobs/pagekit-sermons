<?php
if (isset($error)) {
  echo '<h2>' . $error . '</h2>';
} else if(isset($new)) {
  ?>
  <h2>new sermon</h2>
  <?php
} else {
  ?>

  <pre><?php var_dump($sermon); ?></pre>

  <?php
}