<?php

set_error_handler(function($errno, $errstr) {
    echo "<div style='background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 4px; margin: 10px 0;'>
            <strong>Error:</strong> $errstr
          </div>";
});

?>