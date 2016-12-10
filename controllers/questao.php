<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    //Routes with Named Placeholders
    $app->get('/conselho-classe/{id_conselho}/questionario/{id_questionario}/questao', function (Request $request, Response $response, $args) {
        $id_questionario = (int)$args['id_questionario'];
        $mapper = new QuestaoMapper($this->db);
        $questoes = $mapper->getQuestoes(array(':id_questionario' => $id_questionario));

        $response = $this->view->render($response, "topo.phtml");
        $response = $this->view->render($response, "questaoLista.phtml", ["questoes" => $questoes]);
        $response = $this->view->render($response, "rodape.phtml");
        return $response;
    });

    $app->get('/conselho-classe/{id_conselho}/questionario/{id_questionario}/questao/{id_questao}', function (Request $request, Response $response, $args) {
        $id_questionario = (int)$args['id_questionario'];
        $id_questao = (int)$args['id_questao'];
        $mapper = new QuestaoMapper($this->db);
        $questoes = $mapper->getQuestoes(array(':id_questao' => $id_questao));

        $response = $this->view->render($response, "topo.phtml");
        $response = $this->view->render($response, "questaoEdita.phtml", ["questoes" => $questoes]);
        $response = $this->view->render($response, "rodape.phtml");
        return $response;
    });

    $app->get('/conselho-classe/{id_conselho}/questionario/{id_questionario}/questao/novo/cadastro', function (Request $request, Response $response, $args) {
        $id_conselho = (int)$args['id_conselho'];
        $id_questionario = (int)$args['id_questionario'];
        $questoes = array('id_conselho'=>$id_conselho, 'id_questionario'=>$id_questionario);

        $response = $this->view->render($response, "topo.phtml");
        $response = $this->view->render($response, "questaoNovo.phtml", ["questoes" => $questoes]);
        $response = $this->view->render($response, "rodape.phtml");
        return $response;
    });

    $app->post('/conselho-classe/{id_conselho}/questionario/{id_questionario}/questao/{id_questao}/salvar', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $id_conselho = filter_var($data['id_conselho'], FILTER_SANITIZE_STRING);
        $id_questionario = filter_var($data['id_questionario'], FILTER_SANITIZE_STRING);
        $array = [];
        $array['id_questao'] = filter_var($data['id_questao'], FILTER_SANITIZE_STRING);
        $array['descricao_questao'] = filter_var($data['descricao_questao'], FILTER_SANITIZE_STRING);

        $mapper = new QuestaoMapper($this->db);
        $questionario = $mapper->saveQuestao($array);

        //return $response->withRedirect('/conselho-classe/'.$id_conselho.'/questionario/'.$id_questionario.'/questao');
        return $response->withRedirect('../../questao');
    });

    $app->post('/conselho-classe/{id_conselho}/questionario/{id_questionario}/questao/novo/cadastro/salvar', function (Request $request, Response $response) {

        $data = $request->getParsedBody();
        $id_conselho = filter_var($data['id_conselho'], FILTER_SANITIZE_STRING);
        $array = [];
        $array['id_questionario'] = filter_var($data['id_questionario'], FILTER_SANITIZE_STRING);
        $array['descricao_questao'] = filter_var($data['descricao_questao'], FILTER_SANITIZE_STRING);

        $mapper = new QuestaoMapper($this->db);
        $questionario = $mapper->saveQuestao($array);

        return $response->withRedirect('../../../questao');
    });