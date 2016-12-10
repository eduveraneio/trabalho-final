$(document).ready(function()
{
    //Tabelas com cores zebradas
   $('table tbody tr:odd').addClass('zebraUm');
   $('table tbody tr:even').addClass('zebraDois');

   $('#voltar').click(function()
   {
        javascript:history.back();
        return false;
   });

   $('#salvar_questionario').click(function()
   {
        var titulo_questionario = $('#titulo_questionario');
        var descricao_questionario = $('#descricao_questionario');

        if(!titulo_questionario.val()) {
            alert('O campo Título é obrigatório!');
            titulo_questionario.focus();
            return false;
        }
        if(!descricao_questionario.val()) {
            alert('O campo Descrição é obrigatório!');
            descricao_questionario.focus();
            return false;
        }
   });

   $('#salvar_questao').click(function()
   {
        var descricao_questao = $('#descricao_questao');

        if(!descricao_questao.val()) {
            alert('O campo Descrição é obrigatório!');
            descricao_questao.focus();
            return false;
        }
   });
});