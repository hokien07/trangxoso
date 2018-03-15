jQuery(document).ready(function($) {

    var mnumber = [];
    $('form[id="form-show-number-mien-bac"] input[name="show-digits"]').change(function () {
       $('#table-kiet-qua-mien-bac').find('tr td.number').each(function(index) {
            console.log($(this).text().length);
       });
    });
   

   
    
})