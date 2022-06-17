#!/usr/bin/env php
<?php
$count = 100;
$sellerId = 367;
if(isset($_SERVER['argv'])){
    foreach ($_SERVER['argv'] as $argv){
        if(count(explode('limit=', $argv)) == 2){
            $count = explode('limit=', $argv)[1];
        }
        if(count(explode('sellerId=', $argv)) == 2){
            $count = explode('sellerId=', $argv)[1];
        }
    }
}

$myfile = 'catalog_product.csv';
$newfile = "import_products_new_$count.csv";

$fin = fopen($myfile, 'r');
$data = array();

/***********
 * header row
 */
$data[] = fgetcsv($fin, 1000000);
/***********
 * data rows
 */
echo "<pre>";
while ($line = fgetcsv($fin, 1000000)) {
    $data[] = $line;
    break;
}

fclose($fin);

$images = [
        'https://dummyimage.com/1535x1000/000/0312eb.png',
        'https://dummyimage.com/1535x1000/e02fe0/0312eb.png',
        'https://dummyimage.com/1535x1000/1d57c2/ffffff.png',
        'https://dummyimage.com/1535x1000/000/0312eb.png',
        'https://dummyimage.com/1535x1000/e02fe0/0312eb.png',
        'https://dummyimage.com/1535x1000/1d57c2/ffffff.png'
];

$fedNumber = time();
$random = rand(10,100);
while ($count-- >= 0){
    /*@note: update the keys here for the name, sku and URL KEY*/
    $tmp = $line;
    $tmp[0] = $line[0].$random.$count.$sellerId.$fedNumber;
    $tmp[6] = $line[1].$random.$count.$sellerId.$fedNumber;
    $tmp[17] = $line[1].$random.$count.$sellerId.$fedNumber;
    /*@note: update the below keys here for the images*/
    $image = $images[rand(0, count($images)-1)];
    $tmp[13] = rand(10,1000);
    $tmp[21] = $image;
    $tmp[23] = $image;
    $tmp[25] = $image;
    $tmp[27] = $image;
    $data[] = $tmp;
}
/******************
 * reopen file and
 * write array to file
 */
$totoalData = 0;
$fout = fopen($newfile, 'w');
foreach ($data as $line) {
    $totoalData++;
//    if(is_array($line))
    fputcsv($fout, $line);
}
fclose($fout);
var_dump($totoalData);
