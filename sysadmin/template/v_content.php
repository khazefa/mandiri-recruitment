<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <?php
    // Checking if the string contains parent directory
    if (strstr($_GET['page'], '../') !== false) {
        throw new \Exception("Directory traversal attempt!");
    }

    // Checking remote file inclusions
    if (strstr($_GET['page'], 'file://') !== false) {
        throw new \Exception("Remote file inclusion attempt!");
    }

    $page_files = array( 
        'list-kategori'=>'modules/category/v_list.php',
        'list-sub-kategori'=>'modules/subcategory/v_list.php',
        'list-karir'=>'modules/career/v_list.php',
        'list-pelamar'=>'modules/applicants/v_list.php',
        'list-pages'=>'modules/pages/v_list.php',
        'user-list'=>'modules/users/v_list.php',
        'dashboard'=>'modules/dashboard.php'
    );

    if (in_array($_GET['page'],array_keys($page_files))) {
        include $page_files[$_GET['page']];
    } else {
        include $page_files['dashboard'];
    }

    ?>

</div>	<!--/.main-->