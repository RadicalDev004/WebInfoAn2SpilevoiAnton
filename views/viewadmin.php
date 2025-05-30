<?php

class ViewAdmin {
    private $templatePath = 'templates/admin.tpl';
    private $vars = [];

    public function incarcaDatele($tables, $selectedTable, $rows) {
        $tableOptions = '';
        //print_r($tables);
        foreach ($tables as $tbl) {
            $selected = ($tbl === $selectedTable) ? 'selected' : '';
            $tableOptions .= "<option value=\"$tbl\" $selected>$tbl</option>\n";
        }

        $headersHtml = '';
        $rowsHtml = '';
        //print_r($rows);

        if (!empty($rows)) {
            $headers = array_keys($rows[0]);
            $headersHtml = '';
            foreach ($headers as $header) {
                $headersHtml .= "<th>" . htmlspecialchars($header) . "</th>";
            }
        
            $rowsHtml = '';
            foreach ($rows as $row) {
                $rowsHtml .= "<tr>";
                foreach ($row as $cell) {
                    $rowsHtml .= "<td>" . htmlspecialchars($cell) . "</td>";
                }
                $rowsHtml .= "</tr>";
            }
        
            $tableContent = "<table>
                <thead><tr>$headersHtml</tr></thead>
                <tbody>$rowsHtml</tbody>
            </table>";
        } elseif ($selectedTable) {
            $tableContent = "<p>No data found in <strong>" . htmlspecialchars($selectedTable) . "</strong>.</p>";
        } else {
            $tableContent = "";
        }
        
        $addEntryForm = '';

        $addEntryForm = '';

        if (!empty($rows)) {
            $columns = array_keys($rows[0]);
            $formFields = '';
        
            foreach ($columns as $col) {
                $formFields .= '<label>' . htmlspecialchars($col) . ': ';
                $formFields .= '<input name="' . htmlspecialchars($col) . '" type="text" /></label><br/>';
            }
        
            $addEntryForm  = '<div id="entry-form" style="display:none; margin-top:20px; border:1px solid #ccc; padding:10px;">';
            $addEntryForm .= '<form onsubmit="return submitNewEntry(this)">';
            $addEntryForm .= $formFields;
            $addEntryForm .= '<button type="submit">Submit</button> ';
            $addEntryForm .= '<button type="button" onclick="document.getElementById(\'entry-form\').style.display=\'none\'">Cancel</button>';
            $addEntryForm .= '</form></div>';
            $addEntryForm .= '<button onclick="document.getElementById(\'entry-form\').style.display=\'block\'">Add Entry</button>';
        }
              
        $this->vars = [
            '{{table_options}}' => $tableOptions,
            '{{selected_table}}' => htmlspecialchars($selectedTable ?? ''),
            '{{table_headers}}' => $headersHtml,
            '{{table_rows}}' => $rowsHtml,
            '{{title}}' => 'Admin Panel',
            '{{table_content}}' => $tableContent,
            '{{add_entry_panel}}' =>$addEntryForm
        ];
    }

    public function oferaVizualizare() {
        $html = file_get_contents($this->templatePath);
        foreach ($this->vars as $key => $val) {
            $html = str_replace($key, $val, $html);
        }
        return $html;
    }
}
