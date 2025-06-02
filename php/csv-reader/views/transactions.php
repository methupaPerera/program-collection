<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Check #</th>
            <th>Description</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $csv_data = readCSVFiles();
        $html = "";

        foreach ($csv_data as $data) {
            $data[0] = date('M d, Y', strtotime($data[0]));
            $data[1] = $data[1] ? $data[1] : '-';
            $color = strpos($data[3], "-") === false ? "#DAFFD5" : "#FA6B84";

            $html .= "
                <tr>
                    <td>{$data[0]}</td>
                    <td>{$data[1]}</td>
                    <td>{$data[2]}</td>
                    <td style='background-color: {$color}'>{$data[3]}</td>
                </tr>";
        }

        echo $html;

        ?>
    </tbody>

    <tfoot>
        <tr>
            <th colspan="3">Total Income:</th>
            <td>
                <?php echo getStatics()[0] ?>
            </td>
        </tr>
        <tr>
            <th colspan="3">Total Expense:</th>
            <td>
                <?php echo getStatics()[1] ?>
            </td>
        </tr>
        <tr>
            <th colspan="3">Net Total:</th>
            <td>
                <?php echo getStatics()[2] ?>
            </td>
        </tr>
    </tfoot>
</table>