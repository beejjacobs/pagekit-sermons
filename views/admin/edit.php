<?php
  if(isset($error)) {
    echo '<h2>' . $error . '</h2>';
  } else {
    ?>

    <pre><?php var_dump($sermon); ?></pre>

    <?php
  }