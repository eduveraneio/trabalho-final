<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    //Routes with Named Placeholders
    $app->get('/conselho-classe/{id_conselho}/questionario', function (Request $request, Response $response, $args) {
        $id_conselho = (int)$args['id_conselho'];
        $mapper = new QuestionarioMapper($this->db);
        $questionarios = $mapper->getQuestionarios(array(':id_conselho' => $id_conselho));

        $response = $this->view->render($response, "topo.phtml");
        $response = $this->view->render($response, "questionarioLista.phtml", ["questionarios" => $questionarios]);
        $response = $this->view->render($response, "rodape.phtml");
        return $response;
    });

    $app->get('/conselho-classe/{id_conselho}/questionario/{id_questionario}', function (Request $request, Response $response, $args) {
        $id_questionario = (int)$args['id_questionario'];
        $mapper = new QuestionarioMapper($this->db);
        $questionarios = $mapper->getQuestionarios(array(':id_questionario' => $id_questionario));

        $response = $this->view->render($response, "topo.phtml");
        $response = $this->view->render($response, "questionarioEdita.phtml", ["questionarios" => $questionarios]);
        $response = $this->view->render($response, "rodape.phtml");
        return $response;
    });

    $app->post('/conselho-classe/{id_conselho}/questionario/{id_questionario}/salvar', function (Request $request, Response $response) {

        $data = $request->getParsedBody();
        $array = [];
        //$array['id_conselho'] = filter_var($data['id_conselho'], FILTER_SANITIZE_STRING);
        $array['id_questionario'] = filter_var($data['id_questionario'], FILTER_SANITIZE_STRING);
        $array['titulo_questionario'] = filter_var($data['titulo_questionario'], FILTER_SANITIZE_STRING);
        $array['descricao_questionario'] = filter_var($data['descricao_questionario'], FILTER_SANITIZE_STRING);

        $mapper = new QuestionarioMapper($this->db);
        $questionario = $mapper->saveQuestionario($array);

        return $response->withRedirect('/conselho-classe/'.$data['id_conselho'].'/questionario');
    });

    $app->get('/conselho-classe/{id_conselho}/questionario/novo/cadastro', function (Request $request, Response $response, $args) {
        $id_conselho = (int)$args['id_conselho'];
        $questionario = array('id_conselho'=>$id_conselho);

        $response = $this->view->render($response, "topo.phtml");
        $response = $this->view->render($response, "questionarioNovo.phtml", ["questionario" => $questionario]);
        $response = $this->view->render($response, "rodape.phtml");
        return $response;
    });

    $app->post('/conselho-classe/{id_conselho}/questionario/novo/cadastro/salvar', function (Request $request, Response $response) {

        $data = $request->getParsedBody();
        $id_conselho = filter_var($data['id_conselho'], FILTER_SANITIZE_STRING);
        $array = [];
        $array['id_conselho'] = filter_var($data['id_conselho'], FILTER_SANITIZE_STRING);
        $array['titulo_questionario'] = filter_var($data['titulo_questionario'], FILTER_SANITIZE_STRING);
        $array['descricao_questionario'] = filter_var($data['descricao_questionario'], FILTER_SANITIZE_STRING);

        $mapper = new QuestionarioMapper($this->db);
        $questionario = $mapper->saveQuestionario($array);

        return $response->withRedirect('/conselho-classe/'.$id_conselho.'/questionario');
    });