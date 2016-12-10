<?php

    /**
    * Mapper da entidade Questionario
    */
    class QuestionarioMapper
    {
        private $id_questionario;
        private $titulo_questionario;
        private $descricao_questionario;
        private $id_conselho;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function __destruct() {
            $this->pdo = null;
        }

        public function setTitulo($titulo) {
            $this->titulo_questionario = $titulo;
        }

        public function setDescricao($descricao) {
            $this->descricao_questionario = $descricao;
        }

        public function setIdConselho($idConselho) {
            $this->id_conselho = $idConselho;
        }

        public function getId() {
            return $this->id_questionario;
        }

        public function getTitulo() {
            return $this->titulo_questionario;
        }

        public function getDescricao() {
            return $this->descricao_questionario;
        }

        public function getIdConselho() {
            return $this->id_conselho;
        }

        public function getQuestionarios($params) {

            $obj = $this->pdo->prepare('
                SELECT id_questionario, titulo_questionario, descricao_questionario, id_conselho
                FROM Questionario '.$this->getWhere($params),
                array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
            );

            if ($params != null) {
                $obj->execute($params);
            } else {
                $obj->execute();
            }

            $result = $obj->fetchAll();
            $obj = null;

            return $result;
        }

        public function saveQuestionario($params) {

             if(array_key_exists("id_questionario", $params)) {
                $obj = $this->pdo->prepare("UPDATE Questionario
                                                                SET titulo_questionario=:titulo_questionario,
                                                                       descricao_questionario=:descricao_questionario
                                                                WHERE id_questionario = :id_questionario",
                                                                array(':titulo_questionario' => $params['titulo_questionario'],
                                                                          ':descricao_questionario'   => $params['descricao_questionario'],
                                                                          ':id_questionario' => $params['id_questionario'])
                                                                );
            }
            else {

                    $obj = $this->pdo->prepare("INSERT INTO Questionario (id_conselho, titulo_questionario, descricao_questionario)
                                                                VALUES (:id_conselho, :titulo_questionario, :descricao_questionario)",
                                                                array(':id_conselho' => $params['id_conselho'],
                                                                          ':titulo_questionario' => $params['titulo_questionario'],
                                                                          ':descricao_questionario' => $params['descricao_questionario'])
                                                                );
            }
            $obj->execute($params);

            try {
                $message = array("message" => "", "type" => "SUCESS", "code" => 200);
            }
            catch(Exception $e) {
                $message = array("message" => $e->getMessage(), "type" => "ERROR", "code" => 400);
            }

            $obj = null;

            return $message;
        }

        private function getWhere($params) {

            $result = null;

            if (array_key_exists(":id_conselho", $params)) {
                $result = 'WHERE id_conselho= :id_conselho';
            }
            elseif (array_key_exists(":id_questionario", $params)) {
                $result = 'WHERE id_questionario = :id_questionario';
            }

            return $result;
        }
    }