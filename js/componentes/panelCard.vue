<template>
    <div>
        <v-layout row style="padding:8px;">
            <v-flex xs12 sm12>
                <v-card class="card--flex-toolbar">
                    <v-toolbar card prominent>
                        <v-toolbar-title class="body-2 grey--text">{{title_modulo}}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <slot name="optionsbuttonstop">
                         
                        </slot>
                    </v-toolbar>
                    <v-divider></v-divider>
                    <v-card-text>
                        <slot name="bodycard">
                            
                        </slot>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>
 
<script>
export default {
    name: 'panelCard',
	props: ['title_modulo','options']
}
</script>