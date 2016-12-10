<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    //Rules default
    $app->get('/conselho-classe', function (Request $request, Response $response) {
        $mapper = new ConselhoMapper($this->db);
        $conselhos = $mapper->getConselhos();

        $response = $this->view->render($response, "topo.phtml");
        $response = $this->view->render($response, "conselhoLista.phtml", ["conselhos" => $conselhos]);
        $response = $this->view->render($response, "rodape.phtml");
        return $response;
    });

    //Working with POST Data
    $app->post('/conselho-classe/novo', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $array = [];
        $array['titulo_conselho'] = filter_var($data['titulo_conselho'], FILTER_SANITIZE_STRING);
        $array['descricao_conselho'] = filter_var($data['descricao_conselho'], FILTER_SANITIZE_STRING);
    });