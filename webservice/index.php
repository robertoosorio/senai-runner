<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Senai Runners - Web Service - Grupo 3</title>

    <style type="text/css">
        *, *:after, *:before                        { -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; margin: 0; padding: 0; border:0; }
        body                                        { font:14px "Trebuchet MS", Arial, Tahoma; background: #A7CBD9; }
        .container                                  { max-width: 98%; margin: 20px auto; background: #E4F1F2; padding:40px 20px; }
        h1                                          { font-size: 25px; text-align: center; margin-bottom: 30px; color: #025373; }
        h2                                          { font-size: 20px; margin-bottom: 20px; color: #699EBF; }
        p                                           { line-height: 150%; margin-bottom: 10px; }
        ol,ul                                          { margin: 10px 0 20px 20px; }
        ol li                                       { margin-bottom: 10px; line-height: 150%; }
        a                                           { text-decoration: underline; color:#000; }

        table tr.head td                            { text-align: center; background:#025373; color: #fff; font-size: 18px;  }
        table tr td                                 { font-size: 12px; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; padding: 5px; }

        .borderRightNone                            { border-right: none; }
        .borderBottomNone                           { border-bottom: none; }

        .width250                                   { width: 250px; }


    </style>

</head>
<body data-feedly-mini="yes">

    <div class="container">
        <h1>Grupo 3 - Web Service - Senai Runners</h1>
        <h2>Introdução</h2>
        <p>O presente projeto trata-se de um web service de gerenciamento de corridas apresentado para conclusão da matéria de Web Service, da Pós Graduação de Sistemas Web e Dispositivos Móveis no Senai/SC.</p>
        <p>O mesmo está disponível no GitHub, pelo endereço: <a href="https://github.com/robertoosorio/senai-runner" target="_blank">https://github.com/robertoosorio/senai-runner</a></p>
        <p>Para acessar o serviço, o mesmo encontra-se publicado em: <a href="http://runners.acertenet.com.br" target="_blank">http://runners.acertenet.com.br</a></p>

        <br>
        <h2>Especificação Técnica</h2>
        <p>Para desenvolvimento deste foi utilizado o Slim Framework, um micro framework  que fornece meios de desenvolvimento de aplicações simples, porém poderosas.</p>
        <p>A linguagem utilizada foi o PHP, junto com o banco de dados MySQL.</p>

        <br>
        <h2>Requisitos da plataforma</h2>
        <p>Os requisitos da plataforma são descritos a seguir:</p>
        <ol>
            <li>
                O organizador poderá cadastrar, incluir, atualizar e excluir corridas através de uma plataforma WEB
                <ul>
                    <li>Informações minimas da corrida: nome, data, cidade, estado, descrição, valor de inscrição, status (Agendada, Cancelada)</li>
                </ul>                        
            </li>
            <li>O organizador poderá inativar um corredor ou atualizar suas informações</li>
            <li>
                O corredor poderá realizar seu próprio cadastro
                <ul>
                    <li>Informações minimas do corredor: Nome, Data Nascimento, Cidade e Estado.</li>
                </ul>
            </li>
            <li>
                O corredor poderá realizar inscrições para qualquer corrida aberta.
                <ul>
                    <li>Informações minimas para inscrição: Corredor, Corrida, Status do Pagamento</li>
                </ul>
            </li>
        </ol>

        <br>
        <h2>Chamadas possíveis</h2>
        
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody><tr class="head">
            <td>Tipo</td>
            <td>URLs</td>
          </tr>
          <tr>
            <td width="14%">Corredores</td>
            <td width="59%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tbody><tr>
                <td rowspan="4">GET</td>
                <td class="width250">/webservice/runners</td>
                <td class="width250">Busca Corredores</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td class="width250">/webservice/runners/actives</td>
                <td class="width250">Busca Corredores Ativos</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td class="width250">/webservice/runners/:id</td>
                <td class="width250">Busca um corredor pelo ID</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td class="width250">/webservice/runners/:id/runsEntry</td>
                <td class="width250">Busca inscrições deste corredor</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>POST</td>
                <td class="width250">/webservice/runners</td>
                <td class="width250">Cadastra corredor</td>
                <td><p>Dados enviados via formulário html ou json.</p>
                  <p>Campos possíveis:<br>
                    nome*<br>
                    data_nascimento<br>
                    cidade<br>
                    estado<br>
                    status (ativo, inativo) - padrão "ativo"      </p>
                </td>
                </tr>
              <tr>
                <td>PUT</td>
                <td class="width250">/webservice/runners/:id</td>
                <td class="width250">Atualiza corredor com o ID</td>
                <td><p>Dados enviados via formulario html** ou json.</p>
                  <p>Mesmos campos citados acima. Apenas atualiza campos enviados, deixando os demais inalterados.</p></td>
              </tr>
              <tr>
                <td class="borderBottomNone">DELETE</td>
                <td class="borderBottomNone">/webservice/runners/:id</td>
                <td class="borderBottomNone">Apaga corredor com o ID</td>
                <td class="borderBottomNone">&nbsp;</td>
              </tr>
            </tbody></table></td>
          </tr>
          <tr>
            <td>Corridas</td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tbody><tr>
                <td rowspan="4">GET</td>
                <td class="width250">/webservice/runs</td>
                <td class="width250">Busca Corridas</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="width250">/webservice/runs/open</td>
                <td class="width250">Busca Corridas Agendadas</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="width250">/webservice/runs/:id</td>
                <td class="width250">Busca uma corrida pelo ID</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="width250">/webservice/runs/:id/runsEntry</td>
                <td class="width250">Busca inscrições desta corrida</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>POST</td>
                <td class="width250">/webservice/runs</td>
                <td class="width250">Cadastra corrida</td>
                <td><p>Dados enviados via formulário html ou json.</p>
                  <p>Campos possíveis:<br>
                    nome*<br>
                    data*<br>
                    cidade<br>
                    estado<br>
                    descricao<br>
                    valor_inscricao<br>
                  status (agendada,cancelada) - padrão "agendada"          </p></td>
              </tr>
              <tr>
                <td>PUT</td>
                <td class="width250">/webservice/runs/:id</td>
                <td class="width250">Atualiza corrida com o ID</td>
                <td><p>Dados enviados via formulario html** ou json.</p>
                  <p>Mesmos campos citados acima. Apenas atualiza campos enviados, deixando os demais inalterados.</p></td>
              </tr>
              <tr>
                <td class="borderBottomNone">DELETE</td>
                <td class="borderBottomNone">/webservice/runs/:id</td>
                <td class="borderBottomNone">Apaga corrida com o ID</td>
                <td class="borderBottomNone">&nbsp;</td>
              </tr>
            </tbody></table></td>
          </tr>
          <tr>
            <td>Inscrições</td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tbody><tr>
                <td rowspan="3">GET</td>
                <td class="width250">/webservice/runsEntry<br></td>
                <td class="width250">Busca Inscrições</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="width250">/webservice/runsEntry/:id</td>
                <td class="width250">Busca uma inscrição pelo ID</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="width250">/webservice/runners/:runnerId/runs/:runId</td>
                <td class="width250">Busca inscrições pelo ID da corrida e do corredor</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td rowspan="2">POST</td>
                <td class="width250">/webservice/runsEntry</td>
                <td class="width250">Cadastra inscrição</td>
                <td><p>Dados enviados via formulário html ou json.</p>
                  <p>Campos possíveis:<br>
                    id_corrida*<br>
                    id_corredor*<br>
                    status - status do pagamento (varchar)<br>
                  data - timestamp (gerada automaticamente)</p></td>
              </tr>
              <tr>
                <td class="width250">/webservice/runners/:runnerId/runs/:runId</td>
                <td class="width250">Cadastra inscrição</td>
                <td>Cadastro direto, passando o ID da corrida e do corredor</td>
              </tr>
              <tr>
                <td rowspan="2">PUT</td>
                <td class="width250">/webservice/runsEntry/:id</td>
                <td class="width250">Atualiza corrida com o ID</td>
                <td><p>Dados enviados via formulario html** ou json.</p>
                  <p>Mesmos campos citados acima. Apenas atualiza campos enviados, deixando os demais inalterados.</p></td>
              </tr>
              <tr>
                <td class="width250">/webservice/runners/:runnerId/runs/:runId</td>
                <td class="width250">Atualiza inscrição</td>
                <td>Atualiza direto, passando o ID da corrida e do corredor</td>
              </tr>
              <tr>
                <td class="borderBottomNone" rowspan="2">DELETE</td>
                <td class="width250">/webservice/runsEntry/:id</td>
                <td class="width250">Apaga corrida com o ID</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="borderBottomNone width250">/webservice/runners/:runnerId/runs/:runId</td>
                <td class="borderBottomNone width250">Apaga corrida pelo ID da corrida e do corredor</td>
                <td class="borderBottomNone">&nbsp;</td>
              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table>
        <p>* campos obrigatórios<br>
        </p><p>
            ** formulário html não enviam informação de header diferentes de POST e GET. Para contornar esta situação, o framework permite envio de um campo oculto na seguinte estrutura:<br> 
            PUT - &lt;input type="hidden" name="_METHOD" value="PUT" /&gt;<br>
            DELETE - &lt;input type="hidden" name="_METHOD" value="DELETE" /&gt; 
        </p>

        <br>
        <h2>Mensagens de retorno</h2>
        <p>200 - Status OK. Ex.: Informação deletada com sucesso</p>
        <p>201 - Informação inserida com sucesso</p>
        <p>202 - Informação atualizada com sucesso</p>
        <p>203 - Erro ao realizar busca. Parâmetro ID precisa ser numérico (informação incorreta)</p>
        <p>204 - Nenuma informação retornada</p>
        <p>503 - Erro ao realizar ação. Problemas com conexão ao banco.</p>

        <br>
        <h2>Créditos - Grupo 3</h2>
        <p>Tiago Lorenzoni - <a href="mailto:tiagolorenzoni@gmail.com" target="_blank">tiagolorenzoni@gmail.com</a></p>
        <p>Gustavo Appel - <a href="mailto:gu.appel@gmail.com" target="_blank">gu.appel@gmail.com</a></p>
        <p>Antonio Rafael Ortega - <a href="mailto:antonioiae@gmail.com" target="_blank">antonioiae@gmail.com</a></p>
        <p>Roberto Willadino Osório - <a href="mailto:willadino@gmail.com" target="_blank">willadino@gmail.com</a></p>

    </div>

</body>
</html>