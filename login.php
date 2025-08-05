<?php
include 'libs/load.php';


?>

        <?php load_template('_body'); ?>
        <?php load_template('_header'); ?>
        <?php load_template('_login'); ?>
        <?php load_template('_footer'); ?>
    <script src="/app/assets/js/color-modes.js"></script>
    <script src="/app/assets/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
    <script>
  // Initialize the agent at application startup.
  // If you're using an ad blocker or Brave/Firefox, this import will not work.
  // Please use the NPM package instead: https://t.ly/ORyXk
  const fpPromise = import('https://openfpcdn.io/fingerprintjs/v4')
    .then(FingerprintJS => FingerprintJS.load())

  // Get the visitor identifier when you need it.
  fpPromise
    .then(fp => fp.get())
    .then(result => {
      // This is the visitor identifier:
      const visitorId = result.visitorId
console.log(visitorId);           // Logs the visitorId to the browser console
alert(visitorId);                // Pops up an alert with the visitorId

    })
</script> -->