<?php
function renderTable(array $headers, array $rows)
{
    echo '<div class="table-wrapper" style="overflow-x:auto;">';
    echo '<table border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse; width:100%;">';
    echo '<thead><tr>';
    foreach ($headers as $header) {
        echo "<th>{$header}</th>";
    }
    echo '</tr></thead><tbody>';
    
    if (empty($rows)) {
        echo '<tr><td colspan="' . count($headers) . '" style="text-align:center; color:#999;">ยังไม่มีข้อมูล</td></tr>';
    } else {
        foreach ($rows as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo "<td>{$cell}</td>";
            }
            echo '</tr>';
        }
    }
    
    echo '</tbody></table></div>';
}
