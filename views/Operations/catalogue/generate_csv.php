<?php
    require_once ('../../../App/init.php');
    $params = json_decode($_REQUEST['ids']);

    if(empty($params)){
        echo "No data";
    }else{
        $products = array(
            [
                'productId',
                'productName',
                'currentStock',
                'units',
                'min_limit',
                'max_limit',
                'sale_price',
                'supply_price',
                'date_created',
                'date_modified',
                'created_by',
                'modified_by',
                'notes',
                'allow_stock_tracking'
            ]
        );


        foreach ($params as $value) {
            $sql = 'SELECT * FROM tbl_catalogue WHERE productId=:productId';
            $catalogue_return = $admin->runQuery($sql);
            $catalogue_return->execute(
                array(
                    ":productId"=>$value
                )
            );
            $catalogue = $catalogue_return->fetchAll();
            $product = $catalogue[0];

            array_push($products,$product);
        }

        $list = array(
            ['Name', 'age', 'Gender'],
            ['Bob', 20, 'Male'],
            ['John', 25, 'Male'],
            ['Jessica', 30, 'Female']
        );

        array_to_csv_download($products);

        ob_start();
        ?>
        <script>
            Window.close();
        </script>
        <?php
        ob_end_clean();
    }
    
    function array_to_csv_download($array, $filename = "export.csv") {

        ob_start();

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        
        // open the "output" stream
        // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
        $f = fopen('php://output', 'w');
        
        foreach ($array as $line) {
            fputcsv($f, $line);
        }

        fclose($f);

        ob_end_flush(); 

    }
?>




