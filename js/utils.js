
  
const self = {
  download : (filename, text)=> {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:application/xml;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);
    element.style.display = 'none';
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
  },
  tableToExcel : () => {
    var uri = 'data:application/vnd.ms-excel;base64,'
      , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="https://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
      , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
      , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(table, name, string_html) {
      let html = '';
      if (!table.nodeType){ // no existe en el dom
        html = document.createElement('div');
        html.innerHTML = string_html;
        html.style.display = 'none';
        html.firstChild.setAttribute('id',table);
        document.body.appendChild(html);
      }
      let table_ = document.getElementById(table);
      var ctx = {worksheet: name || 'Worksheet', table: table_.innerHTML}
      window.location.href = uri + base64(format(template, ctx))
      if (!table.nodeType) {
        document.body.removeChild(html);
      }
    }
  },
  toLower : text => {
    return text.toString().toLowerCase();
  },
  toUpper : text => {
    return text.toString().toUpper();
  },
  headersearch : (str,item) =>{
    return item[str];
  },
  searchByName : (items, term, namesearch) => {
    if (term) {
      console.log(items, term, namesearch);
      return items.filter(item =>{
        return item[namesearch].toLowerCase().indexOf(toLower(term)) > -1;
      })
    }
    return items;
  },
  romanize :(num)=> {
    if (!+num)
        return false;
    var digits = String(+num).split(""),
        key = ["","C","CC","CCC","CD","D","DC","DCC","DCCC","CM",
              "","X","XX","XXX","XL","L","LX","LXX","LXXX","XC",
              "","I","II","III","IV","V","VI","VII","VIII","IX"],
        roman = "",
        i = 3;
    while (i--)
        roman = (key[+digits.pop() + (i * 10)] || "") + roman;
    return Array(+digits.join("") + 1).join("M") + roman;
  },
  isempty : (str) => {
    return str === '' || str === undefined || str === null || typeof str === undefined || typeof str == undefined || typeof str === null || str.length === 0;
  },
  b64_to_utf8 : ( str ) => {
    return decodeURIComponent(escape(window.atob( str )));
  },
  culqi:()=> {
    if (Culqi.token) { // ¡Objeto Token creado exitosamente!
      let nombre=$('#nombre').val(),
        apellido=$('#apellido').val(),
        usuario=$('#usuario').val(),
        contrasena=$('#contrasena').val(),
        email=$('#email').val(),
        id_plan=$('.swal-button-plan-login.activated').children().attr("data-id");

      var token = Culqi.token.id;
      var email_token = Culqi.token.email;
      let data = {token:token,email_token:email_token,apellido:apellido,id_plan:id_plan,nombre:nombre,usuario:usuario,contrasena:contrasena,email:email};
      appVue.postCulqi(data);

    } else { // 
      console.log(Culqi.error);
      alert(Culqi.error.user_message);
    }
  }
}
export default self;
