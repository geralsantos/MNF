<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo NOMBRE_PAGINA?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo ASSETS ?>/img/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo ASSETS?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/pc-bootstrap4-datetimepicker@4.17.50/build/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo CSS?>/plantilla.css">
    <link rel="stylesheet" href="<?php echo CSS?>/peruvian.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
  
<div class="" id="vue_app">
    <div class="wrapper">

<!-- Main Header -->
        <header class="main-header">

        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">
            <img src="<?php echo ASSETS?>/img/logo-peruvian-small.png" />
            </span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
            <img src="<?php echo ASSETS?>/img/logo-peruvian.png" />
            </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="hidden-xs">Nestor Ojeda</span>
                </a>
                </li>
                <li @click="cerrar()">
                <a href="" data-toggle="control-sidebar">
                    <i class="fa fa-power-off"></i>
                </a>
                </li>
            </ul>
            </div>
        </nav>
        </header>
    <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
            <li class="header">SISTEMA DE PRUEBA</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Opcion 1</span></a></li>
            <li><a href="#"><i class="fa fa-link"></i> <span>Opcion 2</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Opcion 3</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                <li><a href="#">Opcion 3.1</a></li>
                <li><a href="#">Opcion 3.2</a></li>
                </ul>
            </li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
        </aside>

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Nombre de Pagina
                <small>Descripcion</small>
                </h1>
                <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-thumb-tack"></i> Nivel 1</a></li>
                <li class="active">Nivel Actual</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class='box box-danger'>
                <div class="box-header with-border">
                    <h3 class="box-title">Titulo tabla</h3>
                </div>
                <div class="box-body">
                        <div class="main-body">
                        <router-view></router-view> 
                        </div>
                </div>
                <div class="box-footer clearfix">

                </div>
                </div>

            </section>
            <!-- /.content -->
        </div>  
    </div>