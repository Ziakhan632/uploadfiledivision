<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Small Business & Enterprise Solutions | Comcast Business</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .top-nav {
            background-color: black;
            width: 100%;
            height: 22px;
        }

        .main-nav {
            background-color: #191919;
            height: 72px;
        }

        .top-nav-list {
            list-style-type: none;
            color: white;
        }

        .list-item {
            display: inline-block;
            font-size: 11px;
            padding-right: 15px;
            color: #a5afb8;
            font-weight: 400;
            text-decoration: none;
            text-transform: uppercase;
        }


        .footer-item {
            letter-spacing: 1px;
            list-style-type: none;
            font-size: 1.075em;
            font-weight: 700;
            text-decoration: none;
            text-transform: uppercase;
            color: #fff;
            margin-top: 20px;

            float: left;
            /* padding-right: 35px; */
            cursor: pointer;
        }

        .brand {
            cursor: pointer;
            /* font-weight: bold; */
            font-size: 20px;
        }

        .nav-list {
            color: white;
        }

        a {
            color: white;
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
            color: gray;
        }
    </style>
</head>

<body>
<?php 
#include("menu.php"); 

?>

<main id="main">


    <section class="inner-page">
        <div class="container" style="min-height: 600px">
            <?php

            #require 'vendor/autoload.php';

            //session_start();
            if( isset( $_POST[ "submit" ] ) ) {

                $uploads_dir = 'uploads';

                if( $_FILES[ "excelfile" ][ "error" ] == UPLOAD_ERR_OK ) {

                    $file_ext = @strtolower( end( explode( '.', $_FILES[ 'excelfile' ][ 'name' ] ) ) );
                    if( $file_ext != 'xlsx' ) {
                        $_SESSION[ 'success_message' ] = "This file type is not supported. Please, only XLSX format.";
                    } else {
                        $tmp_name = $_FILES[ "excelfile" ][ "tmp_name" ];

                        // может быть целесообразным дополнительно проверить имя файла
                        $name = basename( $_FILES[ "excelfile" ][ "name" ] );

                        $uploadFilePath = "$uploads_dir/$name";
                        $z = move_uploaded_file( $tmp_name, $uploadFilePath );

                        $reader = PhpOffice\PhpSpreadsheet\IOFactory::createReader( "Xlsx" );
                        $reader->setReadDataOnly( true );
                        ini_set( 'memory_limit', '-1' );
                        $spreadsheet = $reader->load( './' . $uploadFilePath );
                        $sheetCount = $spreadsheet->getSheetCount();
                        $dataRow = [];
                        $rowIndex = 0;
                        echo $sheetCount;
                        for( $j = 0; $j <= $sheetCount - 1; $j++ ) {//Total number of loop sheets

                            $worksheet = $spreadsheet->getSheet( $j );

                            foreach( $worksheet->getRowIterator() as $row ) {
                                $cellIterator = $row->getCellIterator();
                                $cellIterator->setIterateOnlyExistingCells( false );

                                $cell_value_first_column = '';

                                foreach( $cellIterator as $cell ) {

                                    $cell_value = $cell->getCalculatedValue();


                                    if( $cell->getColumn() == "B" ) {
                                        $cell_value_first_column = $cell_value;
                                    }

                                    if( $cell->getColumn() != "B" ) {

                                        switch( $cell_value_first_column ) {
                                            case 'New/Current Offer':
                                                $dataRow[ 'Title' ][] = $cell_value;
                                                $dataRow[ 'Details_and_Restrictions' ][] = $cell_value;
                                                break;
                                            case 'Offer Name':
                                                $dataRow[ 'Offer_Name' ][] = $cell_value;
                                                break;
                                            case 'Offer Type':
                                                $dataRow[ 'Offer_Type' ][] = $cell_value;
                                                break;
                                            case 'Internet':
                                                $dataRow[ 'Internet' ][] = $cell_value;
                                                break;
                                            case 'Voice':
                                                $dataRow[ 'Voice' ][] = $cell_value;
                                                break;
                                            case 'SecurityEdge':
                                                $dataRow[ 'SecurityEdge' ][] = $cell_value;
                                                break;
                                            case 'Connection Pro':
                                                $dataRow[ 'Connection_Pro' ][] = $cell_value;
                                                break;
                                            case 'Wifi Pro':
                                                $dataRow[ 'Wifi_Pro' ][] = $cell_value;
                                                break;
                                            case 'Static IP':
                                                $dataRow[ 'Static_IP' ][] = $cell_value;
                                                break;
                                            case 'Promo':
                                                $dataRow[ 'Promo' ][] = $cell_value;
                                                break;
                                            case 'Visa Prepaid Card (Amount)':
                                                $dataRow[ 'Visa_Prepaid_Card' ][] = $cell_value;
                                                break;
                                            case 'Free Install':
                                                $dataRow[ 'Free_Install' ][] = $cell_value;
                                                break;
                                            case 'Other':
                                                $dataRow[ 'Other' ][] = $cell_value;
                                                break;
                                            case 'Total Offer Price':
                                                $dataRow[ 'Total_Offer_Price' ][] = $cell_value;
                                                break;
                                            case 'Self-Service Eligibile':
                                                $dataRow[ 'Self_Service_Eligibile' ][] = $cell_value;
                                                break;
                                            case 'Advertised Price':
                                                $dataRow[ 'Advertised_Price' ][] = $cell_value;
                                                break;
                                            case 'Term':
                                                $dataRow[ 'Term' ][] = $cell_value;
                                                break;
                                            case 'Contract':
                                                $dataRow[ 'Contract' ][] = $cell_value;
                                                break;
                                            case 'Roll-To Price':
                                                $dataRow[ 'Roll_To_Price' ][] = $cell_value;
                                                break;
                                            case 'EDP':
                                                $dataRow[ 'EDP' ][] = $cell_value;
                                                break;
                                            case 'Promo Start Date':
                                                $dataRow[ 'Promo_Start_Date' ][] = $cell_value;
                                                break;
                                            case 'Promo End Date':
                                                $dataRow[ 'Promo_End_Date' ][] = $cell_value;
                                                break;
                                            case 'Homepage Message':
                                                $dataRow[ 'Homepage_Message' ][] = $cell_value;
                                                break;
                                            case 'Offer Chart':
                                                $dataRow[ 'Offer_Chart' ][] = $cell_value;
                                                break;
                                            case 'Offer ID':
                                                $dataRow[ 'Offer_ID' ][] = $cell_value;
                                                break;
                                            case 'In Media':
                                                $dataRow[ 'In_Media' ][] = $cell_value;
                                                break;

                                        }
                                    }
                                }
                            }
                        }

                        /* database connection */
                        $host = "localhost";
                        $user = "root";
                        $pass = "comcast";
                        //$pass = '';
                        $db_name = "crawl_summary";
                        $connection = mysqli_connect( $host, $user, $pass, $db_name );
                        /* database connection */

                        if( mysqli_connect_errno() ) {
                            die( "connection failed: "
                                 . mysqli_connect_error()
                                 . " (" . mysqli_connect_errno()
                                 . ")" );
                        }

                        $sqlcreate = "CREATE TABLE IF NOT EXISTS crawl_summary.offers_from_division (
Offer_ID INT, 
Title VARCHAR(255), 
Promo_Start_Date VARCHAR(255), 
Promo_End_Date VARCHAR(255), 
Offer_Name VARCHAR(255), 
Offer_Type VARCHAR(255), 
Offer_Chart VARCHAR(255), 
In_Media VARCHAR(255), 
Internet VARCHAR(255), 
Voice VARCHAR(255), 
SecurityEdge VARCHAR(255), 
Connection_Pro VARCHAR(255), 
Wifi_Pro VARCHAR(255), 
Static_IP VARCHAR(255), 
Promo VARCHAR(255), 
Visa_Prepaid_Card VARCHAR(255), 
Free_Install VARCHAR(255), 
Other VARCHAR(255), 
Homepage_Message VARCHAR(255),
Total_Offer_Price VARCHAR(255), 
Self_Service_Eligibile VARCHAR(255), 
Advertised_Price VARCHAR(255), 
Term VARCHAR(255), 
Contract VARCHAR(255), 
Roll_To_Price VARCHAR(255), 
EDP VARCHAR(255), 
Details_and_Restrictions TEXT);";

                        if( !$connection->query( $sqlcreate ) === true ) {
                            echo "Error: " . $sqlcreate . "<br>" . $connection->error;
                        }


                       /* $sql = "TRUNCATE TABLE crawl_summary.offers_from_division;";
                        if( !$connection->query( $sql ) === true ) {
                            echo "Error: " . $sql . "<br>" . $connection->error;
                        }*/


                        $offersData = [];

                        foreach( $dataRow as $key => $value ) {
                            $i = 0;
                            foreach( $value as $val ) {
                                if( !is_null( $val ) ) {
                                    $offersData[ $i ][ $key ] = $val;
                                } else {
                                    continue;
                                }
                                $i++;
                            }

                        }

                        foreach( $offersData as $offer ) {
                            $sql = "INSERT INTO crawl_summary.offers_from_division (";
                            $values = "VALUES (";
                            foreach( $offer as $key => $val ) {

                                if( $val == null ) {
                                    continue;
                                }
                                $sql .= $key . ', ';
                                $escapestr = $connection->real_escape_string( htmlspecialchars( $val, ENT_QUOTES ) );
                                $values .= "'$escapestr'" . ', ';
                            }
                            $sql = substr( $sql, 0, strlen( $sql ) - 2 ) . ') ';
                            $values = substr( $values, 0, strlen( $values ) - 2 ) . ');';

                            $sql .= $values;
                            if( !$connection->query( $sql ) === true ) {
                                echo "Error: " . $sql . "<br>" . $connection->error;
                            }
                        }
                        $_SESSION[ 'success_message' ] = "File uploaded successfully.";
                    }

                }

            }


            ?>
            </br>
            <form method="POST" action="upload_file_division.php" enctype="multipart/form-data">
                <div class="upload-wrapper">
                    <h4>Upload file to database</h4></br>
                    <?php
                    if( isset( $_SESSION[ 'success_message' ] ) && $_SESSION[ 'success_message' ] != '' ) {
                        echo '<p style="color:green">' . $_SESSION[ 'success_message' ] . '</p>';
                        //session_destroy();
                    }
                    ?>
                    <label for="file-upload">Choose File<span>*</span> </br><input type="file" id="file-upload"
                                                                                   name="excelfile" required></label>
                </div>

                <input type="submit" class='btn-primary' name="submit" value="Submit"/>
            </form>
        </div>
    </section>

</main><!-- End #main -->


<div class="col-lg-12" style="background-color: black; width: 100%; height: 600px; color: white;">
    <div class="col-lg-1">

    </div>
    <div class="col-lg-10" style="height: 80%;">
        <div class="col-lg-2" style="height: 100%; padding-top: 60px;">
            <img src="./logo_black_bg.jpg"/>
        </div>

        <div class="col-lg-2" style="height: 100%;padding-top: 72px;">
            <h4 style="text-align: center;font-weight: 700;">
                Business
                <hr>
            </h4>
            <ul>
                <li class="footer-item">
                    <a href="business.php">
                        Offers
                    </a>
                </li>
                <li class="footer-item">

                    <a href="business.php">
                        Configure
                    </a>
                </li>
                <li class="footer-item">

                    <a href="business.php">
                        Checkout
                    </a>
                </li>
            </ul>

        </div>

        <div class="col-lg-2" style="height: 100%;padding-top: 72px;">
            <h4 style="text-align: center;font-weight: 700;">
                Preview
                <hr>
            </h4>
            <ul>
                <li class="footer-item">

                    <a href="preview.php">
                        Main Page
                    </a>
                </li>
                <li class="footer-item">

                    <a href="preview.php">
                        Second Page
                    </a>
                </li>
            </ul>


        </div>

        <div class="col-lg-2" style="height: 100%;padding-top: 72px;">
            <h4 style="text-align: center;font-weight: 700;">
                Healthcheck
                <hr>
            </h4>
            <ul>
                <li class="footer-item">

                    <a href="healthcheck.php">
                        Business Page
                    </a>
                </li>
                <li class="footer-item">
                    <a href="healthcheck.php">

                        Preview Page
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-lg-2" style="height: 100%;padding-top: 72px;">

        </div>

        <div class="col-lg-2" style="height: 100%;padding-top: 72px;">

        </div>

    </div>
    <div class="col-lg-1">

    </div>
    <hr width="83%">

    <span style="margin-left: 550px; font-weight: 700;font-size: 15px;">
            ©2020 Comcast Corporation
        </span>
</div>

<script>


	$(document).ready(function () {
		$('#btnOutlook').click(function () {
			var x = 'http://hqswl-c051213:8080/comcast/index.php'

			var today = new Date()
			var dd = String(today.getDate()).padStart(2, '0')
			var mm = String(today.getMonth() + 1).padStart(2, '0') //January is 0!
			// var yyyy = today.getFullYear();

			var b = 'Offers Section by Address and Date ' + mm + '/' + dd
			x = 'Here is the link: ' + x

			window.open('mailto:test@example.com?subject=' + b + '&body=' + x)
		})
	})
</script>

</body>
</html>
