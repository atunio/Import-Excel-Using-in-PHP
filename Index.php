<?php
include("conf/session_start.php");
include("conf/connection.php");
include("conf/functions.php");

$db                     = new mySqlDB;
$selected_db_name       = "";
$page_width             = "";
$subscriber_users_id     = "0";
$subscriber_users_id     = "0";
$user_id                 = "0";
if (!isset($all_data)) {
    $all_data = array();
}

$title_heading          = "Import Products";
$button_val             = "Preview";
extract($_POST);
foreach ($_POST as $key => $value) {
    if (!is_array($value)) {
        $data[$key] = remove_special_character(trim(htmlspecialchars(strip_tags(stripslashes($value)), ENT_QUOTES, 'UTF-8')));
        $$key = $data[$key];
    }
}
$supported_column_titles     = array("product_id", "product_category", "product_model_no", "product_desc");
$duplication_columns         = array("product_id", "product_model_no");
$required_columns             = array("product_id", "product_category");
if (isset($is_Submit) && $is_Submit == 'Y') {
    if (isset($excel_data) && $excel_data == "") {
        $error['excel_data']    = "Required";
        $category_name_valid     = "invalid";
    }
    if (empty($error)) {
        $excel_data = set_replace_string_char($excel_data);
        // Split the pasted data by new lines (each line is a row)
        $rows = explode(PHP_EOL, trim($excel_data));
        // Split each row by tabs or commas (each column in a row)
        $data = array();
        foreach ($rows as $row) {
            $data[] = preg_split('/[\t,]+/', trim($row)); // Split by tab or comma
        }
        // Separate headings (first row) from the data
        $headings = array_shift($data); // Get the first row as headings 
        ////////////// validation on missing headings  ///////////////////
        //////////////////////////////////////////////////////////////////
        foreach ($data as $row_v1) {
            if (count($row_v1) > count($headings)) {
                $error['msg'] = "One or more column headings are missing.";
            }
        }
        if (!empty($error)) {
            $error['msg'] .= "<br>Please check Supported column titles.";
        }
        //////////////////////////////////////////////////////////////////

        /// All data cells should have values or add - if no 
        foreach ($data as $row11) {
            foreach ($row11 as $cell_array) {
                if (sizeof($headings) != sizeof($row11)) {
                    if (!isset($error['msg'])) {
                        $error['msg'] = "Please ensure that all cells contain values, or insert a dash (' - ') for any blank cells.";
                    }
                }
            }
        }
    }
}
$added = 0;
$master_table = "products";
if (isset($is_Submit2) && $is_Submit2 == 'Y') {

    $import_colums_uniq         = array_unique($import_colums);
    $total_import_column_set    = count($import_colums_uniq);

    // if (sizeof($supported_column_titles) != $total_import_column_set) {
    // 	$error['msg'] = "One or more column headings are missing.";
    // }

    $required_columns_found = array();
    foreach ($import_colums_uniq as $import_colum) {
        if (in_array($import_colum, $required_columns)) {
            $required_columns_found[] = $import_colum;
        }
    }

    foreach ($required_columns as $required_column) {
        if (!in_array($required_column, $import_colums_uniq)) {
            if (isset($error['msg'])) {
                $error['msg'] .= "<br>" . $required_column . " column title is required.";
            } else {
                $error['msg'] = $required_column . " column title is required.";
            }
        }
    }

    // Initialize the new modified array
    $modified_array = array();
    $product_table_ids_already = array();
    $i = $modale_already =  0;
    foreach ($all_data as $value1) {
        $j = 0;
        foreach ($value1 as $key => $data) {
            $k = 0;
            foreach ($import_colums_uniq as $data2) {
                if ($k == $j) {
                    $modified_array[$i][$data2] = trim($data);
                }
                $k++;
            }
            $j++;
        }
        $modified_array[$i]["is_insert"] = $data;
        $i++; // increment the index
    }

    $all_data = $modified_array;
    if (empty($error)) {
        $duplicate_data_array = array();
        if (isset($all_data) && sizeof($all_data) > 0) {

            foreach ($all_data  as $key1 => $data1) {
                $product_table_id = $product_model_no_db = "";
                if (isset($data1['product_id']) && $data1['product_id'] != '' && $data1['product_id'] != NULL && $data1['product_id'] != 'blank') {

                    $columns = $column_data = $update_column = "";
                    foreach ($data1 as $key => $data) {
                        if ($key != "" && $key != 'is_insert') {
                            if ($data == '-' || $data == 'NA' || $data == 'N/A' || $data == 'blank') {
                                $data = "";
                            }
                            $columns         .= ", " . $key;
                            $column_data     .= ", '" . $data . "'";
                            $update_column    .= ", " . $key . " = '" . $data . "'";
                        }
                    }
                    $sql6 = "INSERT INTO " . $master_table . "(subscriber_users_id " . $columns . ")
                                VALUES('" . $subscriber_users_id . "' " . $column_data . ")";
                    $ok = $db->query($conn, $sql6);
                    if ($ok) {
                        $added++;
                    }
                }
            }
        }
        if ($added > 0) {
            if ($added == 1) {
                $msg['msg_success'] = $added . " record has been imported successfully.";
            } else {
                $msg['msg_success'] = $added . " records have been imported successfully.";
            }
        } else {
            if (!isset($error['msg'])) {
                $error['msg'] = " No record has been imported.";
            } else {
                $error['msg'] = "No record has been imported.<br><br>" . $error['msg'];
            }
        }
    }
}


?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/favicon/favicon-32x32.png">

    <!-- Comment if there is no internet -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/vendors.min.css">

    <link rel="stylesheet" type="text/css" href="app-assets/vendors/flag-icon/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/dropify/css/dropify.min.css">

    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/vertical-modern-menu-template/materialize.min.css">

    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/vertical-modern-menu-template/style.css">

    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/horizontal-menu-template/materialize.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/horizontal-menu-template/style.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/layouts/style-horizontal.css">

    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/intro.css">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/custom/custom.css">
    <!-- END: Page Level CSS-->


    <!-- Comment if there is no internet -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <title>Import in PHP_ROUND_HALF_ODD</title>
    <!-- Custom data tables Export Buttons -->
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/customdatatable-buttons.css">

    <!-- Custom data tables ends -->
    <!-- Custom CSS for Gradient Buttons -->
    <style>
        /* General button styling */
        .dt-button {
            color: white !important;
            /* Text color */
            border-radius: 5px !important;
            /* Rounded corners */
            padding: 3px 8px !important;
            /* Padding */
            margin: 2px !important;
            /* Margin between buttons */
            border: none !important;
            /* Remove border */
            font-weight: bold !important;
            /* Bold text */
            background-size: 150% auto !important;
            /* Gradient animation */
            transition: 0.5s !important;
            /* Smooth transition */
        }

        /* Gradient colors for each button */
        .dt-button.buttons-copy {
            background-image: linear-gradient(45deg, rgb(163, 166, 163), rgb(218, 222, 218)) !important;
            /* Green gradient */
        }

        .dt-button.buttons-csv {
            background-image: linear-gradient(45deg, #2196F3, #64B5F6) !important;
            /* Blue gradient */
        }

        .dt-button.buttons-excel {
            background-image: linear-gradient(45deg, #4CAF50, #81C784) !important;
            /* Green gradient */
        }

        .dt-button.buttons-pdf {
            background-image: linear-gradient(45deg, #F44336, #E57373) !important;
            /* Red gradient */
        }

        .dt-button.buttons-print {
            background-image: linear-gradient(45deg, #9C27B0, #BA68C8) !important;
            /* Purple gradient */
        }

        /* Hover effects */
        .dt-button:hover {
            background-position: right center !important;
            /* Gradient animation on hover */
        }

        .desc_po_detail {
            padding: 0px !important;
            min-height: 1rem !important;
            height: 2rem !important;
        }
    </style>
</head>
<!-- END: Head-->

<body class="horizontal-layout page-header-light horizontal-menu preload-transitions 2-columns" data-open="click" data-menu="horizontal-menu" data-col="2-columns">
    <!-- BEGIN: Page Main-->
    <!-- BEGIN: Page Main-->
    <div id="main" class="<?php echo $page_width; ?>">
        <div class="row">
            <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
            <div class="col s12 m12 l12">
                <div class="section section-data-tables">
                    <div class="card custom_margin_card_table_top custom_margin_card_table_bottom">
                        <div class="card-content custom_padding_card_content_table_top_bottom">
                            <div class="row">
                                <div class="input-field col m6 s12" style="margin-top: 3px; margin-bottom: 3px;">
                                    <h6 class="media-heading">
                                        <?php echo $title_heading; ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m12 l12">
                <div id="Form-advance" class="card card card-default scrollspy custom_margin_card_table_top custom_margin_card_table_bottom">
                    <div class="card-content custom_padding_card_content_table_top">

                        <h4 class="card-title">Import Excel Data</h4><br>
                        <?php
                        if (isset($msg['msg_success'])) { ?>
                            <div class="card-alert card green lighten-5">
                                <div class="card-content green-text">
                                    <p><?php echo $msg['msg_success']; ?></p>
                                </div>
                                <button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        <?php }
                        if (isset($error['msg'])) { ?>
                            <div class="card-alert card red lighten-5">
                                <div class="card-content red-text">
                                    <p><?php echo $error['msg']; ?></p>
                                </div>
                                <button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        <?php }
                        if ((!isset($excel_data) || (isset($excel_data) && $excel_data == "") || isset($error)) &&  !isset($is_Submit2)) { ?>

                            <form method="post" autocomplete="off">
                                <input type="hidden" name="is_Submit" value="Y" />
                                <div class="row">
                                    <div class="input-field col m12 s12">
                                        <?php
                                        $field_name     = "excel_data";
                                        $field_label     = "Paste Here";
                                        ?>
                                        <i class="material-icons prefix">description</i>
                                        <textarea type="text" id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="materialize-textarea excel_data_textarea validate"><?php if (isset(${$field_name})) {
                                                                                                                                                                                echo ${$field_name};
                                                                                                                                                                            } ?></textarea>
                                        <label for="<?= $field_name; ?>">
                                            <?= $field_label; ?>
                                            <span class="color-red">* <?php
                                                                        if (isset($error[$field_name])) {
                                                                            echo $error[$field_name];
                                                                        } ?>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col m4 s12">
                                        <button class="btn cyan waves-effect waves-light right" type="submit" name="action"><?php echo $button_val; ?>
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <div class="col m12 s12">
                                    <h4 class="card-title">Supported column titles</h4>
                                    <table class="bordered striped" style="padding: 0px; width: 95%;">
                                        <tr>
                                            <td style='padding: 3px 15px  !important; text-align: center; '>Column Name</td>
                                            <td style='padding: 3px 15px !important; '>Column Heading</td>
                                            <td style='padding: 3px 15px !important; '>Format</td>
                                        </tr>
                                        <?php
                                        $i = 0;
                                        $char = 'a';

                                        foreach ($supported_column_titles as $s_heading) {
                                            $cell_format = "Text";
                                            if ($s_heading == 'po_date' || $s_heading == 'estimated_receive_date') {
                                                $cell_format = "Date (d/m/Y)";
                                            }
                                            if ($s_heading == 'product_id') {
                                                $cell_format = "Text (Unique)";
                                            }
                                            if ($s_heading == 'product_model_no') {
                                                $cell_format = "Text (Multiple ModelNos separated by the '&' symbol.) Example: MW772LL/A & MD785LL/A";
                                            }

                                            echo " <tr>
													<td style='padding: 3px 15px !important; text-align: center; '>" . strtoupper($char) . "</td>
													<td style='padding: 3px 15px !important; '>" . $s_heading . "</td>
													<td style='padding: 3px 15px !important; '>" . $cell_format . "</td>
												</tr>";
                                            $i++;
                                            $char++;
                                        } ?>
                                    </table>
                                </div>
                            </div>
                            <?php
                        } else if (isset($headings) && sizeof($headings) > "0") {
                            if ((isset($excel_data) && $excel_data != "" && !isset($error)) || isset($is_Submit2)) { ?>
                                <div class="row">
                                    <div class="col m6 s12">
                                        Summary
                                        <table class="bordered striped">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 3px 15px !important">S.No</td>
                                                    <td style="padding: 3px 15px !important">Column Name</td>
                                                    <td style="padding: 3px 15px !important">Column Value</td>
                                                    <td style="padding: 3px 15px !important">Status</td>
                                                </tr>
                                                <?php
                                                foreach ($data as $row_c1) {
                                                    $col_c1_no =  0;
                                                    foreach ($row_c1 as $cell_c1) {
                                                        if (!isset($headings[$col_c1_no])) {
                                                            $headings[$col_c1_no] = "";
                                                        }
                                                        $column_name_c1 = $headings[$col_c1_no];
                                                        $col_c1_no++;
                                                    }
                                                }
                                                foreach ($headings as $heading_c1) {
                                                    if (isset(${$heading_c1 . "_array"})) {
                                                        $does_not_exist_unique = array_unique(${$heading_c1 . "_array"});
                                                        sort($does_not_exist_unique); // Sort the array before looping
                                                        $j = 0;
                                                        foreach ($does_not_exist_unique as $data_1) {
                                                            $j++; ?>
                                                            <tr>
                                                                <td style="padding: 3px 15px !important"><b><?php echo $j; ?></b></td>
                                                                <td style="padding: 3px 15px !important"><b><?php echo $heading_c1; ?></b></td>
                                                                <td style="padding: 3px 15px !important"><?php echo $data_1; ?></td>
                                                                <td style="padding: 3px 15px !important" class="color-green">Creates</td>
                                                            </tr>
                                                <?php }
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col m12 s12"><br></div>
                                </div>
                                <h4 class="card-title">Data to be imported</h4><br>
                                <form method="post" autocomplete="off">
                                    <input type="hidden" name="is_Submit2" value="Y" />
                                    <input type="hidden" name="excel_data" value="<?php if (isset($excel_data)) {
                                                                                        echo $excel_data;
                                                                                    } ?>" />
                                    <div class="row">
                                        <div class="col m12 s12">
                                            <table class="bordered striped">
                                                <thead>
                                                    <tr>
                                                        <?php
                                                        $m = 0;
                                                        foreach ($headings as $heading) {
                                                            $m++; ?>
                                                            <th>
                                                                <?php
                                                                $field_name = "import_colums[]";
                                                                ?>
                                                                <div class="select2div">
                                                                    <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="  validate">
                                                                        <option value="">Unassigned</option>
                                                                        <?php
                                                                        foreach ($supported_column_titles as $heading_main) {  ?>
                                                                            <option value="<?php echo $heading_main; ?>" <?php if (isset($heading) && $heading == $heading_main) { ?> selected="selected" <?php } ?>><?php echo $heading_main; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                        <?php } ?>
                                                        <th></th>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        foreach ($headings as $heading) {
                                                            $row_color     = "";
                                                            if (!in_array($heading, $supported_column_titles)) {
                                                                $row_color     = "color-red";
                                                            }
                                                            echo "<th class='" . $row_color . "'> " . htmlspecialchars($heading) . "</th>";
                                                        } ?>
                                                        <th>Import Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $row_no = 0;
                                                    foreach ($data as $row) {
                                                        echo "<tr>";
                                                        $row_error_status = "";
                                                        $col_no     = $is_error = 0;
                                                        $is_insert    = "Yes";
                                                        $row_color    = "color-green";
                                                        foreach ($row as $cell) {

                                                            $db_column             = $headings[$col_no];
                                                            $db_column_excel    = $db_column;


                                                            if (!in_array($db_column_excel, $supported_column_titles)) {
                                                                $row_color     = "color-red";
                                                                $is_error     = 1;
                                                                $is_insert     = "No";
                                                            }
                                                            if (in_array($db_column_excel, $duplication_columns)) {



                                                                $sql_dup     = " SELECT * FROM " . $master_table . " WHERE " . $db_column . "	= '" . htmlspecialchars($cell) . "' "; // echo "<br>" . $sql_dup;
                                                                $result_dup    = $db->query($conn, $sql_dup);
                                                                $count_dup    = $db->counter($result_dup);

                                                                if ($count_dup > 0) {
                                                                    $row_color     = "color-red";
                                                                    $is_error     = 1;
                                                                    $is_insert     = "No";
                                                                    if ($row_error_status != "") {
                                                                        $row_error_status .= ", Duplicate " . $db_column_excel;
                                                                    } else {
                                                                        $row_error_status = "Duplicate " . $db_column_excel;
                                                                    } ?>
                                                                    <input type="hidden" name="all_data[<?= $row_no; ?>][<?= $db_column_excel; ?>]" value="<?= $cell; ?>">
                                                                <?php
                                                                } else {
                                                                    $row_color = "color-green"; ?>
                                                                    <input type="hidden" name="all_data[<?= $row_no; ?>][<?= $db_column_excel; ?>]" value="<?= $cell; ?>">
                                                                <?php
                                                                }
                                                            } else {
                                                                $row_color = "color-green";  ?>
                                                                <input type="hidden" name="all_data[<?= $row_no; ?>][<?= $db_column_excel; ?>]" value="<?= $cell; ?>">
                                                        <?php
                                                            }
                                                            echo "<td class='" . $row_color . "'>" . htmlspecialchars($cell) . "</td>";
                                                            $col_no++;
                                                        } ?>
                                                        <input type="hidden" name="all_data[<?= $row_no; ?>][is_insert]" value="<?= $is_insert; ?>">
                                                    <?php
                                                        if ($is_error == 1) {
                                                            $row_color = "color-red";
                                                        } else {
                                                            $row_error_status = "Creates";
                                                        }
                                                        echo "<td class='" . $row_color . "'>" . $row_error_status . "</td>";
                                                        echo "</tr>";
                                                        $row_no++;
                                                    } ?>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col m2 s12">&nbsp;</div>
                                    </div>
                                    <div class="row">
                                        <div class="col m2 s12">&nbsp;</div>
                                        <div class="col m2 s12">
                                            <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Start Import
                                                <i class="material-icons right">send</i>
                                            </button>
                                        </div>
                                        <div class="col m2 s12">
                                            <a href="index.php" class="waves-effect waves-light btn modal-trigger mb-2 mr-1" type="submit" name="action">Copy New
                                                <i class="material-icons left">send</i>
                                            </a>
                                        </div>
                                        <div class="col m4 s12">&nbsp;</div>
                                    </div>
                                </form>
                            <?php
                            } else { ?>
                                <div class="row">
                                    <div class="col m2 s12">&nbsp;</div>
                                    <div class="col m2 s12">
                                        <a href="index.php" class="waves-effect waves-light btn modal-trigger mb-2 mr-1" type="submit" name="action">Copy New
                                            <i class="material-icons left">send</i>
                                        </a>
                                    </div>
                                    <div class="col m4 s12">&nbsp;</div>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="row">
                                <div class="col m2 s12">&nbsp;</div>
                                <div class="col m2 s12">
                                    <a href="index.php" class="waves-effect waves-light btn modal-trigger mb-2 mr-1" type="submit" name="action">Copy New
                                        <i class="material-icons left">send</i>
                                    </a>
                                </div>
                                <div class="col m4 s12">&nbsp;</div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                    //include('sub_files/right_sidebar.php');
                    ?>
                </div>
            </div>
        </div>
    </div><br><br><br><br>
    <!-- END: Page Main-->

    <br><br><br><br>
    <!-- END: Page Main--> <!-- END: Page Main-->
    <!-- Theme Customizer -->

    <!-- BEGIN: Footer-->
    <footer class="page-footer footer footer-static footer-dark gradient-45deg-indigo-purple gradient-shadow navbar-border navbar-shadow">
        <div class="footer-copyright">
            <div class="container">
                <span>&copy; 2025 <a href="javascript:void(0)">Aftab Tunio @ AMIZ (Private) Limited</a>
                    All rights reserved.
                </span>
                <span class="right hide-on-small-only">Developed by Aftab Tunio
                    <a href="javascript:void(0)"> AMIZ (Private) Limited </a>
                </span>
            </div>
        </div>
    </footer> <!-- END: Footer-->
    <!-- BEGIN VENDOR JS-->
    <script src="app-assets/js/vendors.min.js"></script>
    <script src="app-assets/vendors/sortable/jquery-sortable-min.js"></script>
    <script src="app-assets/vendors/quill/quill.min.js"></script>
    <script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <script src="app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
    <script src="app-assets/vendors/data-tables/js/dataTables.select.min.js"></script>

    <!-- Custom Datatables JS Export Buttons  -->
    <script src="app-assets/vendors/data-tables/js/dataTables.buttons.min.js"></script>
    <script src="app-assets/vendors/data-tables/js/jszip.min.js"></script>
    <script src="app-assets/vendors/data-tables/js/pdfmake.min.js"></script>
    <script src="app-assets/vendors/data-tables/js/vfs_fonts.js"></script>
    <script src="app-assets/vendors/data-tables/js/buttons.html5.min.js"></script>
    <script src="app-assets/vendors/data-tables/js/buttons.print.min.js"></script>
    <!-- Custom Datatables JS Ends-->


    <!-- BEGIN THEME  JS-->
    <script src="app-assets/js/plugins.js"></script>
    <script src="app-assets/js/search.js"></script>
    <script src="app-assets/js/custom/custom-script.js"></script>
    <script src="app-assets/js/scripts/customizer.js"></script>
    <!-- END THEME  JS-->

    <script src="app-assets/vendors/dropify/js/dropify.min.js"></script>
    <script src="app-assets/js/scripts/form-file-uploads.min.js"></script>
    <script src="app-assets/js/scripts/advance-ui-modals.js"></script>
    <script src="app-assets/ckeditor/ckeditor.js"></script>
    <!-- END PAGE LEVEL JS-->

</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        $(".sno_width_30").css("width", "30px");
        $(".sno_width_40").css("width", "40px");
        $(".sno_width_50").css("width", "50px");
        $(".sno_width_60").css("width", "60px");
        $(".sno_width_30").css("min-width", "10px");
    });

    $(".twoDecimalNumber").keyup(function() {
        var numberDecimal1 = this.value;
        var numberDecima2 = numberDecimal1.match(/^\d+\.?\d{0,2}/);
        $(this).val(numberDecima2);
    });

    $(".oneDecimalNumber").keyup(function() {
        var numberDecimal1 = this.value;
        var numberDecima2 = numberDecimal1.match(/^\d+\.?\d{0,1}/);
        $(this).val(numberDecima2);
    });

    $(".zeorDecimalNumber").keyup(function() {
        var numberDecimal1 = this.value;
        var numberDecima2 = numberDecimal1.match(/^\d+\.?\d{0,0}/);
        $(this).val(numberDecima2);
    });
</script>
<script type="text/javascript">
    window.onload = function() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("loader-bg").style.display = "none";
    };
</script>
<script>
    $(document).ready(function() {
        $('.toggle-column').on('change', function() {
            var columnClass = '.col-' + $(this).data('column');
            if ($(this).is(':checked')) {
                $(columnClass).show();
                $(columnClass).removeClass("display_none");
            } else {
                $(columnClass).hide();
                $(this).addClass("display_none");
            }
        });
    });
</script>
<script src="components/inventory/products/products.js"></script>