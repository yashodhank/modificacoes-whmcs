/*
    Criado por Victor Hugo Scatolon de Souza
    CompuLabs.com.br
*/
 
$(document).ready(function() {
    // Aqui você coloca o IP de seus nameservers (OBS.: TEM QUE SER O IP MESMO)
    // Você pode colocar vários IP de várias revendas, basta adicionar uma virgula, ex: var meusip = ['127.0.0.1', '192.0.0.1'];
    var meusip = ['127.0.0.1'];
    // Mensagem mostrada quando o dominio não é permitido
    var msgerro = "Você não inserir um subdominio já cadastrado, como dominio.";
    var rs = false;
    $("#useOwnDomain").hide();
    $("#useOwnDomain").hover(function(){$("#owndomaintld").change();});
    $('#owndomaintld').keypress(function (e) {rs = false;var code = null;code = (e.keyCode ? e.keyCode : e.which);if(code == 13){$("#owndomaintld").change();return (code == 13) ? false : true;}});
    $("#owndomaintld").click(function(event) {rs = false;if($("#owndomainsld").val() == ""){$("#owndomainsld").focus();$("#owndomaintld").val('')}});
    $("#owndomaintld").change(function(event) {
        if($("#owndomainsld").val() == ""){$("#owndomainsld").focus();$("#owndomaintld").val('')}
        else if(rs == false)
        {
            var dominio = $("#owndomainsld").val() + "." + $("#owndomaintld").val();
            $.get("http://ip-api.com/json/"+$("#owndomaintld").val(), function(data) {
                if(data.query === $("#owndomaintld").val())
                {
                    $("#useOwnDomain").show();
                }
                else
                {
                    var ip = data.query;
                    if($.inArray(ip, meusip) !== -1)
                    {
                        rs = true;
                        alert(msgerro);
                        $("#owndomaintld").val('');
                        $("#owndomaintld").focus();
                    }
                    else
                    {
                        $("#useOwnDomain").show();
                    }
                }
            });
        }
    });
});