<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo NOMBRE_PAGINA?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo ASSETS ?>/img/favicon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">

    <!-- main CSS
		============================================ -->

    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo ASSETS ?>/style.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>

<body>
  
<div class="" id="vue_app">
        <v-app>
            <v-toolbar color="white" grey>
                <v-toolbar-side-icon @click.stop="mini = !mini" style="margin-left:66px !important;">
                </v-toolbar-side-icon>

                <v-toolbar-title>TITULO MODULO</v-toolbar-title>

                <v-spacer></v-spacer>

            </v-toolbar>

            <template>
                <v-hover>
                    <v-navigation-drawer dark id="mini" v-model="drawer" class="navigation-drawer-manual" stateless
                        overlay :temporary="!mini" slot-scope="{ hover }" :mini-variant="mini && !hover" value="true"
                        style="position: fixed;">
                        <v-toolbar flat class="transparent">
                            <v-list class="pa-0">
                                <v-list-tile avatar>
                                    <v-list-tile-avatar>
                                        <img src="https://randomuser.me/api/portraits/men/85.jpg">
                                    </v-list-tile-avatar>

                                    <v-list-tile-content>
                                        <v-list-tile-title>John Leider</v-list-tile-title>
                                    </v-list-tile-content>

                                    <v-list-tile-action>
                                        <v-btn icon @click.stop="mini = !mini">
                                            <v-icon style="margin-top: -8px;">chevron_left</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </v-list-tile>
                            </v-list>
                        </v-toolbar>
                        <v-list>
                            <div v-for="(row,index) in rowsmodulos" :href="'#'+row.url_module">

                                <v-list-group v-if="row.children" :prepend-icon="row.icon_module">
                                    <template v-slot:activator>
                                        <v-list-tile>
                                            <v-list-tile-title>{{row.name_module}}</v-list-tile-title>
                                        </v-list-tile>
                                    </template>

                                    <div v-for="(row,index) in row.children">
                                        <v-list-group v-if="row.children" :prepend-icon="row.icon_module">
                                            <template v-slot:activator>
                                                <v-list-tile>
                                                    <v-list-tile-title>{{row.name_module}}</v-list-tile-title>
                                                </v-list-tile>
                                            </template>
                                            <v-list-tile v-if="row.children==null" :href="'#'+row.url_module">
                                                <v-list-tile-action>
                                                    <v-icon>{{row.icon_module}}</v-icon>
                                                </v-list-tile-action>
                                                <v-list-tile-title>{{row.name_module}}</v-list-tile-title>
                                            </v-list-tile>
                                        </v-list-group>

                                        <v-list-tile v-if="row.children==null" :href="'#'+row.url_module">
                                            <v-list-tile-action>
                                                <v-icon>{{row.icon_module}}</v-icon>
                                            </v-list-tile-action>
                                            <v-list-tile-title>{{row.name_module}}</v-list-tile-title>
                                        </v-list-tile>

                                    </div>

                                </v-list-group>

                                <v-list-tile v-if="row.children==null" :href="'#'+row.url_module">
                                    <v-list-tile-action>
                                        <v-icon>{{row.icon_module}}</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-title>{{row.name_module}}</v-list-tile-title>
                                </v-list-tile>

                            </div>

                            <v-list-tile href="<?php $this->url("cerrar", "acceso"); ?>">
                                <v-list-tile-action>
                                    <v-icon>power_settings_new</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Cerrar sesión</v-list-tile-title>
                            </v-list-tile>
                            <!--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>-->
                        </v-list>
                    </v-navigation-drawer>
                </v-hover>
            </template>
            <div class="main-body" v-bind:class="{'sidenav-close':!sidenavopen}">
              <router-view></router-view> 
            </div>
    </v-app>