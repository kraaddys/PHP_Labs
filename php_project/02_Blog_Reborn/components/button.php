<?php
function renderButton($href, $text, $extraClasses = '', $size = 'normal', $isSubmit = false) {
    $sizeClasses = ($size === 'small') ? 'text-xl py-2 px-4' : 'text-base py-2 px-4';
    
    if ($isSubmit) {
        echo '<button type="submit" 
                     class="bg-blue-600 hover:bg-blue-700 text-white rounded ' . $sizeClasses . ' ' . $extraClasses . '">
                     ' . htmlspecialchars($text) . '
              </button>';
    } else {
        echo '<a href="' . htmlspecialchars($href) . '" 
                 class="bg-blue-600 hover:bg-blue-700 text-white rounded ' . $sizeClasses . ' ' . $extraClasses . '">
                 ' . htmlspecialchars($text) . '
              </a>';
    }
}
?>
