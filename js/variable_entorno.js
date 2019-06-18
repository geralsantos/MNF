/*
  var SITE_URL = 'http://localhost:8085',
  SITE_URL_DIR=SITE_URL+'/'+'portal-liga',
  PORT_NODE='8090',
  SOCKET_CHAT=SITE_URL+':'+PORT_NODE,
  NOMBRE_PAGINA='Pulpo Masters',
  PUBLIC_KEY_CULQI_PRODUCTION='pk_live_DHRfwdoDSNfU7eDL';
  PUBLIC_KEY_CULQI_TEST='pk_test_Pshc5cwXrPo4PrIw';*/
  const self = {
    SITE_URL : "https://"+window.location.hostname,
    PORT_NODE : '8095',
    SITE_URL_DIR:'',
    NOMBRE_PAGINA : 'Proyecto Template',
    SOCKET_CHAT:'',
    PUBLIC_KEY_CULQI_PRODUCTION : 'pk_live_DHRfwdoDSNfU7eDL',
    PUBLIC_KEY_CULQI_TEST : 'pk_test_Pshc5cwXrPo4PrIw',
    DS: '/',
    //UBICACIONES PRIVADAS
    ROOT : '/MNF',
    BASE : "/MNF/",
  }
  self.SITE_URL_DIR = self.SITE_URL;
  self.SOCKET_CHAT = self.SITE_URL+':'+self.PORT_NODE;
  self.APP= self.ROOT + self.DS + 'app';
  self.JS_ROOT= self.ROOT + self.DS + 'js';
  self.PUBLICO= self.ROOT;
  self.DIR_CARGAS= self.APP + self.DS + "cargas" +self.DS +"equipos_avatar" + self.DS;

  self.IMG = self.BASE + 'img';
  self.JS = self.BASE + 'js';
  self.CSS = self.BASE + 'css';
  self.ASSETS = self.BASE + 'assets';
  self.IMAGES= self.BASE + 'images';
  export default self;
