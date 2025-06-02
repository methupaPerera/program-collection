<?php

function readCSVFiles()
{
    $data = [];

    foreach (scandir(FILES_PATH) as $file) {
        if (is_dir($file)) {
            continue;
        }

        $opened_file = fopen(FILES_PATH . $file, 'r');
        $file_data = [];

        fgetcsv($opened_file); // Reads and ignores the first line.

        while (($line = fgetcsv($opened_file)) !== false) {
            array_push($file_data, $line);
        }

        array_push($data, $file_data);
        fclose($opened_file);
    }

    $csv_data = [];

    foreach ($data as $csv) {
        foreach ($csv as $item) {
            array_push($csv_data, $item);
        }
    }

    return $csv_data;
}

function getStatics()
{
    $csv_data = readCSVFiles();

    $income = 0;
    $expense = 0;

    foreach ($csv_data as $csv) {
        $value = (float) str_replace(["$", ","], "", $csv[3]);

        if ($value < 0) {
            $expense -= $value;
        } elseif ($value > 0) {
            $income += $value;
        }
    }

    $total = $income - $expense;

    return ['$' . number_format($income, 2, '.', ','), '-$' . number_format($expense, 2, '.', ','), '$' . number_format($total, 2, '.', ',')];
}
