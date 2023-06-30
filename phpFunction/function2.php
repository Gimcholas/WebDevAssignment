<?php

function generateJavaScriptAlert($message) {
    echo<<<HTML
    <script>
        alert('{$message}');
    </script>
    HTML;
}

?>