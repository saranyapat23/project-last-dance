<?php
function renderSearchBox(string $name = 'q', string $value = '', string $placeholder = 'ค้นหา...')
{
    echo "<input type='text' name='{$name}' value='{$value}' placeholder='{$placeholder}' style='padding:8px; width:250px; margin:15px 0;' />";
}
