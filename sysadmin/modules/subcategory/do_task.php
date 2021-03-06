<?php
session_start();
$isLoggedIn = $_SESSION['isLoggedin'];

if(!isset($isLoggedIn) || $isLoggedIn != TRUE){
    header('HTTP/1.1 403 Forbidden.', TRUE, 403);
    echo 'You dont have permissions to access this page! <a href="javascript:history.back()">Back</a>';
    exit(1); // EXIT_ERROR
}else{
    require("../../../includes/constants.php");
    require("../../../includes/common_helper.php");
    require_once("../../../includes/class.db.php");
//    include("../../../includes/verot_upload/class.upload.php");
    $database = DB::getInstance();

    $getpage = htmlspecialchars($_GET["page"], ENT_QUOTES, 'UTF-8');
    $getact = htmlspecialchars($_GET["act"], ENT_QUOTES, 'UTF-8');

    // Save data
    if ($getpage == "list-sub-kategori" AND $getact == "save"){
        $random = rand(000000,999999);
        $fcat = isset($_POST["fcat"]) ? filter_var($_POST['fcat'], FILTER_SANITIZE_NUMBER_INT) : null;
        $ftitle = isset($_POST["ftitle"]) ? filter_var($_POST['ftitle'], FILTER_SANITIZE_STRING) : null;
        $fslug = strtolower(str_replace(" ", "-", $ftitle));
        $fdesc = isset($_POST["fdesc"]) ? $_POST['fdesc'] : null;
        
        $arrValue = array();
        
        $arrValue = array(
            'kk_id' => $fcat,
            'skk_title' => $ftitle,
            'skk_slug' => $fslug,
            'skk_desc' => $fdesc
        );

        $add_query = $database->insert( 'sub_kategori_karir', $arrValue );
        if( $add_query )
        {
            header('location:../../?page='.$getpage);
        }
    }
    // Update data
    elseif ($getpage == "list-sub-kategori" AND $getact == "update"){
        $random = rand(000000,999999);
        $fkey = isset($_POST["fkey"]) ? filter_var($_POST['fkey'], FILTER_SANITIZE_STRING) : null;
        $fcat = isset($_POST["fcat"]) ? filter_var($_POST['fcat'], FILTER_SANITIZE_NUMBER_INT) : null;
        $ftitle = isset($_POST["ftitle"]) ? filter_var($_POST['ftitle'], FILTER_SANITIZE_STRING) : null;
        $fslug = isset($_POST["fslug"]) ? filter_var($_POST['fslug'], FILTER_SANITIZE_STRING) : null;
        $fdesc = isset($_POST["fdesc"]) ? $_POST['fdesc'] : null;
        $fpublish = isset($_POST["fpublish"]) ? filter_var($_POST['fpublish'], FILTER_SANITIZE_STRING) : null;
        
        $arrValue = array();
        
        $arrValue = array(
            'kk_id' => $fcat,
            'skk_title' => $ftitle,
            'skk_slug' => $fslug,
            'skk_desc' => $fdesc,
            'skk_publish' => $fpublish
        );
        
        //Add the WHERE clauses
        $arrWhere = array(
            'skk_id' => $fkey
        );
        $updated = $database->update( 'sub_kategori_karir', $arrValue, $arrWhere, 1 );
        if( $updated )
        {
            header('location:../../?page='.$getpage);
        }
    }
    // Delete data
    elseif ($getpage == "list-sub-kategori" AND $getact == "delete"){
        $key = htmlspecialchars($_GET["key"], ENT_QUOTES, 'UTF-8');
        //Add the WHERE clauses
        $where_clause = array(
            'skk_id' => $key
        );
        //Query delete
        $deleted = $database->delete( 'sub_kategori_karir', $where_clause);
        header('location:../../?page='.$getpage);
    }
}
?>