<?php


function generateHead($title = "My App", $use_bulma = true)
{
    echo '<meta charset="UTF-8">'
        . ' <meta name="viewport" content="width=device-width, initial-scale=1.0">'
        . "<title>$title</title>"
        . '<script src="//unpkg.com/alpinejs" defer></script>'
        .
        ($use_bulma ?
            '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">'
            : '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/picnic">');
}



function generateTableHead($cols)
{
    echo '<tr>';
    foreach ($cols as $col) {
        echo "<th>$col</th>";
    }
    echo '</tr>';
}


function renderTable($rows, $cols = null)
{
    if ($cols == null) $cols = isset($rows[0]) ? array_keys($rows[0]) : [];
    echo '<table>';
    echo '<thead>';
    generateTableHead($cols);
    echo '</thead>';
    echo '<tbody>';
    foreach ($rows as $row) {
        echo '<tr>';
        foreach ($cols as $cell) {
            if (gettype($row[$cell]) == "array") $row[$cell] = join($row[$cell]);
            echo '<td>' . $row[$cell] . '</td>';
        }
        echo '</tr>';
    }
    echo '</thead>';
    echo '</table>';
}
