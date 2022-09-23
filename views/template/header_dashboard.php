<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?php echo $data['page_title']; ?></title>
    <link rel="icon" type="image/png" href="https://i.ibb.co/DQstGsn/favicon1.png" sizes="16x16" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo server_url; ?>assets/libs/datatables/datatables.min.css">
    <link rel="stylesheet" href="<?php echo server_url; ?>assets/libs/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    
    <link rel="stylesheet" href="<?php echo server_url; ?>assets/libs/stisla/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo server_url; ?>assets/libs/stisla/assets/css/components.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css" integrity="sha512-E4kKreeYBpruCG4YNe4A/jIj3ZoPdpWhWgj9qwrr19ui84pU5gvNafQZKyghqpFIHHE4ELK7L9bqAv7wfIXULQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" integrity="sha512-/Ae8qSd9X8ajHk6Zty0m8yfnKJPlelk42HTJjOHDWs1Tjr41RfsSkceZ/8yyJGLkxALGMIYd5L2oGemy/x1PLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">

    <link rel="stylesheet" href="<?php echo server_url; ?>assets/css/custom.css">
</head>

<body oncontextmenu="return false;" class="sidebar-mini">
    <div id="app">
        <div class="main-wrapper">
            <?php require_once("./views/template/navbar_dashboard.php")?>
            <!-- Main Content -->
            <div class="main-content">
